<?php
require_once __DIR__ . '/../includes/auth.php';
require_delivery();
$page_title = 'Order Details';
$did = $_SESSION['delivery_id'];
$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM orders WHERE id=? AND delivery_staff_id=?");
$stmt->execute([$id, $did]);
$order = $stmt->fetch();
if (!$order) redirect('delivery/assigned-orders.php');

$items_stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id=?");
$items_stmt->execute([$id]);
$items = $items_stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    verify_csrf();
    $status = $_POST['order_status'];
    if (in_array($status, ['processing','shipped','out_for_delivery','delivered'])) {
        $pdo->prepare("UPDATE orders SET order_status=? WHERE id=?")->execute([$status, $id]);
        flash('success', 'Status updated.');
        redirect('delivery/order-details.php?id=' . $id);
    }
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>
<?php if ($msg = flash('success')): ?><div class="alert alert-success"><?php echo e($msg); ?></div><?php endif; ?>
<a href="<?php echo BASE_URL; ?>delivery/assigned-orders.php" class="btn btn-sm btn-bloom-outline mb-3"><i class="fa-solid fa-arrow-left me-1"></i> Back</a>

<div class="row g-4">
  <div class="col-lg-7">
    <div class="dash-card mb-4">
      <div class="d-flex justify-content-between mb-3">
        <h6>Order #<?php echo e($order['order_number']); ?></h6>
        <?php echo order_status_badge($order['order_status']); ?>
      </div>
      <table class="table table-bfs">
        <tbody>
        <?php foreach ($items as $it): ?>
          <tr><td><?php echo e($it['product_name']); ?></td><td><?php echo $it['quantity']; ?></td><td><?php echo format_price($it['total']); ?></td></tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <div class="d-flex justify-content-between"><strong>Order Amount</strong><strong class="text-pink"><?php echo format_price($order['total']); ?></strong></div>
      <p class="small text-muted mt-2 mb-0">Payment Method: <?php echo e($order['payment_method']); ?> &middot; <?php echo ucfirst($order['payment_status']); ?></p>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="dash-card mb-4">
      <h6 class="mb-3">Customer & Delivery Info</h6>
      <p class="mb-1"><i class="fa-solid fa-user me-2 text-pink"></i><?php echo e($order['full_name']); ?></p>
      <p class="mb-1"><i class="fa-solid fa-phone me-2 text-pink"></i><?php echo e($order['phone']); ?></p>
      <p class="mb-0"><i class="fa-solid fa-location-dot me-2 text-pink"></i><?php echo e($order['address']); ?>, <?php echo e($order['city']); ?> <?php echo e($order['pincode']); ?></p>
    </div>
    <div class="dash-card">
      <h6 class="mb-3">Update Delivery Status</h6>
      <form method="POST">
        <?php echo csrf_field(); ?>
        <select name="order_status" class="form-select mb-3">
          <?php foreach (['processing','shipped','out_for_delivery','delivered'] as $s): ?>
            <option value="<?php echo $s; ?>" <?php echo $order['order_status']==$s?'selected':''; ?>><?php echo ucwords(str_replace('_',' ',$s)); ?></option>
          <?php endforeach; ?>
        </select>
        <button type="submit" name="update_status" class="btn btn-bloom w-100">Update Status</button>
      </form>
    </div>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
