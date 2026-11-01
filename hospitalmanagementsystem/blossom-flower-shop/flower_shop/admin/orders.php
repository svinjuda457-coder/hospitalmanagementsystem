<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
$page_title = 'Manage Orders';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    verify_csrf();
    $order_id = (int)$_POST['order_id'];
    $status = $_POST['order_status'];
    $delivery_staff_id = $_POST['delivery_staff_id'] !== '' ? (int)$_POST['delivery_staff_id'] : null;

    $pdo->prepare("UPDATE orders SET order_status=?, delivery_staff_id=? WHERE id=?")->execute([$status, $delivery_staff_id, $order_id]);
    flash('success', 'Order updated.');
    redirect('admin/orders.php');
}

$status_filter = $_GET['status'] ?? '';
$sql = "SELECT o.*, u.full_name AS customer_name, d.name AS staff_name FROM orders o JOIN users u ON o.user_id=u.id LEFT JOIN delivery_staff d ON o.delivery_staff_id = d.id";
$params = [];
if ($status_filter !== '') { $sql .= " WHERE o.order_status = ?"; $params[] = $status_filter; }
$sql .= " ORDER BY o.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$orders = $stmt->fetchAll();

$staff = $pdo->query("SELECT * FROM delivery_staff WHERE status='active'")->fetchAll();

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>
<?php if ($msg = flash('success')): ?><div class="alert alert-success"><?php echo e($msg); ?></div><?php endif; ?>

<div class="dash-card">
  <div class="d-flex justify-content-between mb-3 flex-wrap gap-2">
    <form class="d-flex gap-2">
      <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
        <option value="">All Statuses</option>
        <?php foreach (['pending','processing','shipped','out_for_delivery','delivered','cancelled'] as $s): ?>
          <option value="<?php echo $s; ?>" <?php echo $status_filter==$s?'selected':''; ?>><?php echo ucwords(str_replace('_',' ',$s)); ?></option>
        <?php endforeach; ?>
      </select>
    </form>
  </div>
  <div class="table-responsive">
    <table class="table table-bfs align-middle">
      <thead><tr><th>Order #</th><th>Customer</th><th>Date</th><th>Total</th><th>Delivery Staff</th><th>Status</th><th>Action</th></tr></thead>
      <tbody>
      <?php foreach ($orders as $o): ?>
        <tr>
          <td><a href="<?php echo BASE_URL; ?>admin/order-details.php?id=<?php echo $o['id']; ?>"><?php echo e($o['order_number']); ?></a></td>
          <td><?php echo e($o['customer_name']); ?></td>
          <td><?php echo date('d M Y', strtotime($o['created_at'])); ?></td>
          <td><?php echo format_price($o['total']); ?></td>
          <td><?php echo $o['staff_name'] ? e($o['staff_name']) : '<span class="text-muted">Unassigned</span>'; ?></td>
          <td><?php echo order_status_badge($o['order_status']); ?></td>
          <td>
            <button class="btn btn-sm btn-bloom-outline" data-bs-toggle="modal" data-bs-target="#statusModal<?php echo $o['id']; ?>"><i class="fa-solid fa-pen"></i></button>
          </td>
        </tr>

        <!-- Status update modal -->
        <div class="modal fade" id="statusModal<?php echo $o['id']; ?>" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="order_id" value="<?php echo $o['id']; ?>">
                <div class="modal-header"><h5 class="modal-title">Update Order #<?php echo e($o['order_number']); ?></h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label class="form-label">Order Status</label>
                    <select name="order_status" class="form-select">
                      <?php foreach (['pending','processing','shipped','out_for_delivery','delivered','cancelled'] as $s): ?>
                        <option value="<?php echo $s; ?>" <?php echo $o['order_status']==$s?'selected':''; ?>><?php echo ucwords(str_replace('_',' ',$s)); ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Assign Delivery Staff</label>
                    <select name="delivery_staff_id" class="form-select">
                      <option value="">-- Unassigned --</option>
                      <?php foreach ($staff as $s): ?>
                        <option value="<?php echo $s['id']; ?>" <?php echo $o['delivery_staff_id']==$s['id']?'selected':''; ?>><?php echo e($s['name']); ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" name="update_status" class="btn btn-bloom">Save Changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
      <?php if (!$orders): ?><tr><td colspan="7" class="text-center text-muted py-4">No orders found.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
