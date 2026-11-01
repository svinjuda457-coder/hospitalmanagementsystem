<?php
// Requires require_admin() to have been called, and $page_title set.
$current = basename($_SERVER['PHP_SELF']);
function admin_nav_active($file, $current) { return $file === $current ? 'active' : ''; }
?>
<div class="bfs-sidebar">
  <div class="brand"><i class="fa-solid fa-spa"></i> Blossom <span class="fw-light">Admin</span></div>
  <ul class="nav flex-column py-2">
    <li class="nav-item"><a class="nav-link <?php echo admin_nav_active('dashboard.php',$current); ?>" href="<?php echo BASE_URL; ?>admin/dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
    <li class="nav-item"><a class="nav-link <?php echo admin_nav_active('categories.php',$current); ?>" href="<?php echo BASE_URL; ?>admin/categories.php"><i class="fa-solid fa-tags"></i> Categories</a></li>
    <li class="nav-item"><a class="nav-link <?php echo admin_nav_active('products.php',$current); ?>" href="<?php echo BASE_URL; ?>admin/products.php"><i class="fa-solid fa-seedling"></i> Manage Flowers</a></li>
    <li class="nav-item"><a class="nav-link <?php echo admin_nav_active('add-product.php',$current); ?>" href="<?php echo BASE_URL; ?>admin/add-product.php"><i class="fa-solid fa-plus"></i> Add Flower</a></li>
    <li class="nav-item"><a class="nav-link <?php echo admin_nav_active('orders.php',$current); ?>" href="<?php echo BASE_URL; ?>admin/orders.php"><i class="fa-solid fa-box"></i> Manage Orders</a></li>
    <li class="nav-item"><a class="nav-link <?php echo admin_nav_active('customers.php',$current); ?>" href="<?php echo BASE_URL; ?>admin/customers.php"><i class="fa-solid fa-users"></i> Customers</a></li>
    <li class="nav-item"><a class="nav-link <?php echo admin_nav_active('payments.php',$current); ?>" href="<?php echo BASE_URL; ?>admin/payments.php"><i class="fa-solid fa-credit-card"></i> Payments</a></li>
    <li class="nav-item"><a class="nav-link <?php echo admin_nav_active('offers.php',$current); ?>" href="<?php echo BASE_URL; ?>admin/offers.php"><i class="fa-solid fa-percent"></i> Offers / Discounts</a></li>
    <li class="nav-item"><a class="nav-link <?php echo admin_nav_active('enquiries.php',$current); ?>" href="<?php echo BASE_URL; ?>admin/enquiries.php"><i class="fa-solid fa-envelope-open-text"></i> Enquiries</a></li>
    <li class="nav-item"><a class="nav-link <?php echo admin_nav_active('reviews.php',$current); ?>" href="<?php echo BASE_URL; ?>admin/reviews.php"><i class="fa-solid fa-star"></i> Reviews</a></li>
    <li class="nav-item"><a class="nav-link <?php echo admin_nav_active('reports.php',$current); ?>" href="<?php echo BASE_URL; ?>admin/reports.php"><i class="fa-solid fa-chart-line"></i> Reports</a></li>
    <li class="nav-item"><a class="nav-link <?php echo admin_nav_active('settings.php',$current); ?>" href="<?php echo BASE_URL; ?>admin/settings.php"><i class="fa-solid fa-gear"></i> Settings</a></li>
    <li class="nav-item"><a class="nav-link <?php echo admin_nav_active('profile.php',$current); ?>" href="<?php echo BASE_URL; ?>admin/profile.php"><i class="fa-solid fa-user"></i> Admin Profile</a></li>
    <li class="nav-item"><a class="nav-link text-danger" href="<?php echo BASE_URL; ?>admin/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
  </ul>
</div>

<div class="bfs-main">
  <div class="bfs-topheader">
    <div>
      <button class="btn btn-sm btn-bloom-outline d-lg-none me-2" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
      <strong><?php echo e($page_title ?? 'Dashboard'); ?></strong>
    </div>
    <div class="dropdown">
      <a href="#" class="text-dark dropdown-toggle" data-bs-toggle="dropdown"><i class="fa-solid fa-circle-user me-1"></i> <?php echo e($_SESSION['admin_name'] ?? 'Admin'); ?></a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>admin/profile.php">Profile</a></li>
        <li><a class="dropdown-item text-danger" href="<?php echo BASE_URL; ?>admin/logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
