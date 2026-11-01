<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$page_title = 'Order Confirmed';
$uid = $_SESSION['user_id'];
$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM orders WHERE id=? AND user_id=?");
$stmt->execute([$id, $uid]);
$order = $stmt->fetch();
if (!$order) redirect('user/orders.php');

$items_stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id=?");
$items_stmt->execute([$id]);
$items = $items_stmt->fetchAll();

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>
<section class="py-5">
  <div class="container">
    <div class="text-center mb-5">
      <div class="icon-circle mx-auto mb-3" style="width:90px;height:90px;font-size:2.5rem;background:#e6f7ee;color:var(--bfs-green);">
        <i class="fa-solid fa-check"></i>
      </div>
      <h2>Order Placed Successfully!</h2>
      <p class="text-muted">Thank you for shopping with Blossom. Your order number is <strong class="text-pink"><?php echo e($order['order_number']); ?></strong></p>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="dash-card mb-4">
          <h5 class="mb-3">Order Details</h5>
          <table class="table table-bfs">
            <thead><tr><th>Item</th><th>Qty</th><th>Total</th></tr></thead>
            <tbody>
            <?php foreach ($items as $it): ?>
              <tr><td><?php echo e($it['product_name']); ?></td><td><?php echo $it['quantity']; ?></td><td><?php echo format_price($it['total']); ?></td></tr>
            <?php endforeach; ?>
            </tbody>
          </table>
          <div class="d-flex justify-content-between"><span>Subtotal</span><span><?php echo format_price($order['subtotal']); ?></span></div>
          <?php if ($order['discount'] > 0): ?><div class="d-flex justify-content-between text-success"><span>Discount</span><span>-<?php echo format_price($order['discount']); ?></span></div><?php endif; ?>
          <div class="d-flex justify-content-between"><span>Delivery Fee</span><span><?php echo $order['delivery_fee'] > 0 ? format_price($order['delivery_fee']) : 'FREE'; ?></span></div>
          <hr>
          <div class="d-flex justify-content-between"><strong>Total Paid</strong><strong class="text-pink fs-5"><?php echo format_price($order['total']); ?></strong></div>
        </div>

        <div class="dash-card mb-4">
          <h6>Delivery Address</h6>
          <p class="mb-1"><?php echo e($order['full_name']); ?> &middot; <?php echo e($order['phone']); ?></p>
          <p class="text-muted mb-0"><?php echo e($order['address']); ?>, <?php echo e($order['city']); ?> <?php echo e($order['pincode']); ?></p>
        </div>

        <div class="text-center">
          <a href="<?php echo BASE_URL; ?>user/order-track.php?id=<?php echo $order['id']; ?>" class="btn btn-bloom me-2">Track Order</a>
          <a href="<?php echo BASE_URL; ?>products.php" class="btn btn-bloom-outline">Continue Shopping</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
