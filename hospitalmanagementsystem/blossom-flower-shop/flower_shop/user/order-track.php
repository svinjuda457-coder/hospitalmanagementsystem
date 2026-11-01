<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$page_title = 'Track Order';
$uid = $_SESSION['user_id'];
$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM orders WHERE id=? AND user_id=?");
$stmt->execute([$id, $uid]);
$order = $stmt->fetch();
if (!$order) { redirect('user/orders.php'); }

$items_stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id=?");
$items_stmt->execute([$id]);
$items = $items_stmt->fetchAll();

$steps = ['pending' => 'Order Placed', 'processing' => 'Processing', 'shipped' => 'Shipped', 'out_for_delivery' => 'Out for Delivery', 'delivered' => 'Delivered'];
$order_keys = array_keys($steps);
$current_index = array_search($order['order_status'], $order_keys);
if ($current_index === false) $current_index = -1; // cancelled

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>
<div class="page-banner"><div class="container"><h1>Track Order</h1><p class="text-muted">Order #<?php echo e($order['order_number']); ?></p></div></div>

<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="dash-card mb-4">
          <?php if ($order['order_status'] === 'cancelled'): ?>
            <div class="alert alert-danger mb-0"><i class="fa-solid fa-circle-xmark me-2"></i>This order was cancelled.</div>
          <?php else: ?>
          <div class="d-flex justify-content-between position-relative mb-2">
            <?php foreach ($steps as $key => $label): $idx = array_search($key, $order_keys); $done = $idx <= $current_index; ?>
              <div class="text-center flex-fill">
                <div class="mx-auto d-flex align-items-center justify-content-center rounded-circle" style="width:38px;height:38px;background:<?php echo $done ? 'var(--bfs-pink)' : '#eee'; ?>;color:#fff;">
                  <i class="fa-solid <?php echo $done ? 'fa-check' : 'fa-circle'; ?>"></i>
                </div>
                <div class="small mt-2 <?php echo $done ? 'text-pink fw-semibold' : 'text-muted'; ?>"><?php echo $label; ?></div>
              </div>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>

        <div class="dash-card mb-4">
          <h6>Order Items</h6>
          <table class="table table-bfs mb-0">
            <tbody>
            <?php foreach ($items as $it): ?>
              <tr><td><?php echo e($it['product_name']); ?></td><td><?php echo $it['quantity']; ?></td><td><?php echo format_price($it['total']); ?></td></tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <div class="dash-card">
          <h6>Delivery Details</h6>
          <p class="mb-1"><?php echo e($order['full_name']); ?> &middot; <?php echo e($order['phone']); ?></p>
          <p class="text-muted mb-0"><?php echo e($order['address']); ?>, <?php echo e($order['city']); ?> <?php echo e($order['pincode']); ?></p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
