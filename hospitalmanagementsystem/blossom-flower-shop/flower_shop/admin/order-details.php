<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
$page_title = 'Order Details';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT o.*, u.full_name AS customer_name, u.email, d.name AS staff_name FROM orders o JOIN users u ON o.user_id=u.id LEFT JOIN delivery_staff d ON o.delivery_staff_id=d.id WHERE o.id=?");
$stmt->execute([$id]);
$order = $stmt->fetch();
if (!$order) redirect('admin/orders.php');

$items_stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id=?");
$items_stmt->execute([$id]);
$items = $items_stmt->fetchAll();

$pay_stmt = $pdo->prepare("SELECT * FROM payments WHERE order_id=?");
$pay_stmt->execute([$id]);
$payment = $pay_stmt->fetch();

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>
<a href="<?php echo BASE_URL; ?>admin/orders.php" class="btn btn-sm btn-bloom-outline mb-3"><i class="fa-solid fa-arrow-left me-1"></i> Back to Orders</a>

<div class="row g-4">
  <div class="col-lg-8">
    <div class="dash-card mb-4">
      <div class="d-flex justify-content-between mb-3">
        <h6>Order #<?php echo e($order['order_number']); ?></h6>
        <?php echo order_status_badge($order['order_status']); ?>
      </div>
      <table class="table table-bfs">
        <thead><tr><th>Item</th><th>Price</th><th>Qty</th><th>Total</th></tr></thead>
        <tbody>
        <?php foreach ($items as $it): ?>
          <tr><td><?php echo e($it['product_name']); ?></td><td><?php echo format_price($it['price']); ?></td><td><?php echo $it['quantity']; ?></td><td><?php echo format_price($it['total']); ?></td></tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <div class="d-flex justify-content-between"><span>Subtotal</span><span><?php echo format_price($order['subtotal']); ?></span></div>
      <?php if ($order['discount']>0): ?><div class="d-flex justify-content-between text-success"><span>Discount</span><span>-<?php echo format_price($order['discount']); ?></span></div><?php endif; ?>
      <div class="d-flex justify-content-between"><span>Delivery Fee</span><span><?php echo format_price($order['delivery_fee']); ?></span></div>
      <hr>
      <div class="d-flex justify-content-between"><strong>Total</strong><strong class="text-pink"><?php echo format_price($order['total']); ?></strong></div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="dash-card mb-4">
      <h6 class="mb-3">Customer</h6>
      <p class="mb-1"><?php echo e($order['customer_name']); ?></p>
      <p class="text-muted small mb-0"><?php echo e($order['email']); ?></p>
    </div>
    <div class="dash-card mb-4">
      <h6 class="mb-3">Delivery Address</h6>
      <p class="mb-1"><?php echo e($order['full_name']); ?> &middot; <?php echo e($order['phone']); ?></p>
      <p class="text-muted small mb-0"><?php echo e($order['address']); ?>, <?php echo e($order['city']); ?> <?php echo e($order['pincode']); ?></p>
    </div>
    <div class="dash-card mb-4">
      <h6 class="mb-3">Payment</h6>
      <p class="mb-1">Method: <strong><?php echo e($order['payment_method']); ?></strong></p>
      <p class="mb-1">Status: <span class="badge bg-<?php echo $order['payment_status']=='paid'?'success':'secondary'; ?>"><?php echo ucfirst($order['payment_status']); ?></span></p>
      <?php if ($payment && $payment['transaction_id']): ?><p class="small text-muted mb-0">Txn ID: <?php echo e($payment['transaction_id']); ?></p><?php endif; ?>
    </div>
    <div class="dash-card">
      <h6 class="mb-3">Delivery Staff</h6>
      <p class="mb-0"><?php echo $order['staff_name'] ? e($order['staff_name']) : 'Not yet assigned'; ?></p>
    </div>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
