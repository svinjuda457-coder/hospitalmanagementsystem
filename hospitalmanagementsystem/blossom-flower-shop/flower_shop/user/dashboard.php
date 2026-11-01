<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$page_title = 'My Dashboard';

$uid = $_SESSION['user_id'];
$total_orders = $pdo->prepare("SELECT COUNT(*) c FROM orders WHERE user_id=?");
$total_orders->execute([$uid]); $total_orders = $total_orders->fetch()['c'];

$pending_orders = $pdo->prepare("SELECT COUNT(*) c FROM orders WHERE user_id=? AND order_status NOT IN ('delivered','cancelled')");
$pending_orders->execute([$uid]); $pending_orders = $pending_orders->fetch()['c'];

$wishlist_count = get_wishlist_count($pdo, $uid);

$recent = $pdo->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY created_at DESC LIMIT 5");
$recent->execute([$uid]);
$recent = $recent->fetchAll();

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>
<div class="page-banner">
  <div class="container">
    <h1>Hello, <?php echo e($_SESSION['user_name']); ?> 🌸</h1>
    <p class="text-muted">Here's what's happening with your account</p>
  </div>
</div>

<section class="py-5">
  <div class="container">
    <div class="row g-4 mb-4">
      <div class="col-md-4">
        <div class="dash-card">
          <div class="dash-icon"><i class="fa-solid fa-box"></i></div>
          <h3><?php echo $total_orders; ?></h3><p>Total Orders</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="dash-card">
          <div class="dash-icon"><i class="fa-solid fa-truck"></i></div>
          <h3><?php echo $pending_orders; ?></h3><p>Active Orders</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="dash-card">
          <div class="dash-icon"><i class="fa-solid fa-heart"></i></div>
          <h3><?php echo $wishlist_count; ?></h3><p>Wishlist Items</p>
        </div>
      </div>
    </div>

    <div class="row g-4 mb-4">
      <div class="col-md-3 col-6"><a href="<?php echo BASE_URL; ?>products.php" class="btn btn-bloom-outline w-100"><i class="fa-solid fa-basket-shopping me-1"></i> Browse Flowers</a></div>
      <div class="col-md-3 col-6"><a href="<?php echo BASE_URL; ?>user/cart.php" class="btn btn-bloom-outline w-100"><i class="fa-solid fa-cart-shopping me-1"></i> View Cart</a></div>
      <div class="col-md-3 col-6"><a href="<?php echo BASE_URL; ?>user/orders.php" class="btn btn-bloom-outline w-100"><i class="fa-solid fa-clock-rotate-left me-1"></i> My Orders</a></div>
      <div class="col-md-3 col-6"><a href="<?php echo BASE_URL; ?>user/profile.php" class="btn btn-bloom-outline w-100"><i class="fa-solid fa-user-pen me-1"></i> Edit Profile</a></div>
    </div>

    <div class="dash-card">
      <h5 class="mb-3">Recent Orders</h5>
      <?php if ($recent): ?>
      <div class="table-responsive">
        <table class="table table-bfs align-middle">
          <thead><tr><th>Order #</th><th>Date</th><th>Total</th><th>Status</th><th></th></tr></thead>
          <tbody>
          <?php foreach ($recent as $o): ?>
            <tr>
              <td><?php echo e($o['order_number']); ?></td>
              <td><?php echo date('d M Y', strtotime($o['created_at'])); ?></td>
              <td><?php echo format_price($o['total']); ?></td>
              <td><?php echo order_status_badge($o['order_status']); ?></td>
              <td><a href="<?php echo BASE_URL; ?>user/order-track.php?id=<?php echo $o['id']; ?>" class="btn btn-sm btn-bloom-outline">Track</a></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
        <p class="text-muted mb-0">You haven't placed any orders yet. <a href="<?php echo BASE_URL; ?>products.php" class="text-pink">Start shopping</a>!</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
