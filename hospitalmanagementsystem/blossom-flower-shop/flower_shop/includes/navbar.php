<?php
// Requires $pdo, session already started (via includes/auth.php)
$cart_count = 0; $wishlist_count = 0;
if (is_logged_in()) {
    $cart_count = get_cart_count($pdo, $_SESSION['user_id']);
    $wishlist_count = get_wishlist_count($pdo, $_SESSION['user_id']);
}
$current = basename($_SERVER['PHP_SELF']);
?>
<div class="bfs-topbar">
  <div class="container d-flex justify-content-between align-items-center flex-wrap">
    <div><i class="fa-solid fa-truck-fast me-1"></i> Free delivery on orders above ₹999</div>
    <div>
      <a href="<?php echo BASE_URL; ?>contact.php" class="me-3"><i class="fa-solid fa-phone me-1"></i> +91 98765 43210</a>
      <a href="<?php echo BASE_URL; ?>user/orders.php"><i class="fa-solid fa-box me-1"></i> Track Order</a>
    </div>
  </div>
</div>

<nav class="navbar navbar-expand-lg bfs-navbar sticky-top">
  <div class="container">
    <a class="navbar-brand" href="<?php echo BASE_URL; ?>index.php">
      <i class="fa-solid fa-spa"></i> Blossom <span style="color:var(--bfs-text)">Flower Shop</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#bfsNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="bfsNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link <?php echo $current=='index.php'?'active':''; ?>" href="<?php echo BASE_URL; ?>index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $current=='about.php'?'active':''; ?>" href="<?php echo BASE_URL; ?>about.php">About Us</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $current=='products.php'?'active':''; ?>" href="<?php echo BASE_URL; ?>products.php">Flowers</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $current=='categories.php'?'active':''; ?>" href="<?php echo BASE_URL; ?>categories.php">Categories</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $current=='contact.php'?'active':''; ?>" href="<?php echo BASE_URL; ?>contact.php">Contact Us</a></li>
      </ul>
      <form class="d-flex me-3" role="search" action="<?php echo BASE_URL; ?>search.php" method="GET">
        <input class="form-control" type="search" name="q" placeholder="Search flowers..." value="<?php echo e($_GET['q'] ?? ''); ?>">
      </form>
      <div class="d-flex align-items-center">
        <a href="<?php echo BASE_URL; ?><?php echo is_logged_in() ? 'user/wishlist.php' : 'login.php'; ?>" class="bfs-icon-link" title="Wishlist">
          <i class="fa-regular fa-heart"></i>
          <?php if ($wishlist_count > 0): ?><span class="bfs-badge-count" id="wishlist-count-badge"><?php echo $wishlist_count; ?></span><?php endif; ?>
        </a>
        <a href="<?php echo BASE_URL; ?>user/cart.php" class="bfs-icon-link" title="Cart">
          <i class="fa-solid fa-cart-shopping"></i>
          <?php if ($cart_count > 0): ?><span class="bfs-badge-count" id="cart-count-badge"><?php echo $cart_count; ?></span><?php endif; ?>
        </a>
        <?php if (is_logged_in()): ?>
          <div class="dropdown ms-3">
            <a class="bfs-icon-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              <i class="fa-solid fa-circle-user"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>user/dashboard.php"><i class="fa-solid fa-gauge me-2"></i>Dashboard</a></li>
              <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>user/orders.php"><i class="fa-solid fa-box me-2"></i>My Orders</a></li>
              <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>user/profile.php"><i class="fa-solid fa-user me-2"></i>My Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="<?php echo BASE_URL; ?>logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>
            </ul>
          </div>
        <?php else: ?>
          <a href="<?php echo BASE_URL; ?>login.php" class="btn btn-bloom ms-3">Login / Register</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
