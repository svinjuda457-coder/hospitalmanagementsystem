<?php
require_once __DIR__ . '/../includes/auth.php';
require_delivery();
$page_title = 'Assigned Orders';
$did = $_SESSION['delivery_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    verify_csrf();
    $order_id = (int)$_POST['order_id'];
    $status = $_POST['order_status'];
    // Only allow valid delivery-stage statuses
    if (in_array($status, ['processing','shipped','out_for_delivery','delivered'])) {
        $own = $pdo->prepare("SELECT id FROM orders WHERE id=? AND delivery_staff_id=?");
        $own->execute([$order_id, $did]);
        if ($own->fetch()) {
            $pdo->prepare("UPDATE orders SET order_status=? WHERE id=?")->execute([$status, $order_id]);
            flash('success', 'Order status updated.');
        }
    }
    redirect('delivery/assigned-orders.php');
}

$status_filter = $_GET['status'] ?? '';
$sql = "SELECT * FROM orders WHERE delivery_staff_id = ?";
$params = [$did];
if ($status_filter === 'out_for_delivery') { $sql .= " AND order_status='out_for_delivery'"; }
elseif ($status_filter === 'delivered') { $sql .= " AND order_status='delivered'"; }
$sql .= " ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$orders = $stmt->fetchAll();

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>
<?php if ($msg = flash('success')): ?><div class="alert alert-success"><?php echo e($msg); ?></div><?php endif; ?>

<div class="dash-card">
  <div class="d-flex gap-2 mb-3">
    <a href="?status=" class="btn btn-sm <?php echo $status_filter===''?'btn-bloom':'btn-bloom-outline'; ?>">All</a>
    <a href="?status=out_for_delivery" class="btn btn-sm <?php echo $status_filter==='out_for_delivery'?'btn-bloom':'btn-bloom-outline'; ?>">Out for Delivery</a>
    <a href="?status=delivered" class="btn btn-sm <?php echo $status_filter==='delivered'?'btn-bloom':'btn-bloom-outline'; ?>">Delivered</a>
  </div>
  <div class="table-responsive">
    <table class="table table-bfs align-middle">
      <thead><tr><th>Order #</th><th>Customer</th><th>Phone</th><th>Address</th><th>Amount</th><th>Status</th><th>Update</th></tr></thead>
      <tbody>
      <?php foreach ($orders as $o): ?>
        <tr>
          <td><a href="<?php echo BASE_URL; ?>delivery/order-details.php?id=<?php echo $o['id']; ?>"><?php echo e($o['order_number']); ?></a></td>
          <td><?php echo e($o['full_name']); ?></td>
          <td><?php echo e($o['phone']); ?></td>
          <td class="small"><?php echo e($o['address']); ?>, <?php echo e($o['city']); ?></td>
          <td><?php echo format_price($o['total']); ?></td>
          <td><?php echo order_status_badge($o['order_status']); ?></td>
          <td>
            <form method="POST" class="d-flex gap-1">
              <?php echo csrf_field(); ?>
              <input type="hidden" name="order_id" value="<?php echo $o['id']; ?>">
              <select name="order_status" class="form-select form-select-sm">
                <?php foreach (['processing','shipped','out_for_delivery','delivered'] as $s): ?>
                  <option value="<?php echo $s; ?>" <?php echo $o['order_status']==$s?'selected':''; ?>><?php echo ucwords(str_replace('_',' ',$s)); ?></option>
                <?php endforeach; ?>
              </select>
              <button type="submit" name="update_status" class="btn btn-sm btn-bloom">Save</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$orders): ?><tr><td colspan="7" class="text-center text-muted py-4">No orders assigned to you yet.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
