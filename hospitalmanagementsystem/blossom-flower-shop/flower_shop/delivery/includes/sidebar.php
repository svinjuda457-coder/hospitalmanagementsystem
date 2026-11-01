<?php
$current = basename($_SERVER['PHP_SELF']);
function delivery_nav_active($file, $current) { return $file === $current ? 'active' : ''; }
?>
<div class="bfs-sidebar">
  <div class="brand"><i class="fa-solid fa-truck-fast"></i> Blossom <span class="fw-light">Delivery</span></div>
  <ul class="nav flex-column py-2">
    <li class="nav-item"><a class="nav-link <?php echo delivery_nav_active('dashboard.php',$current); ?>" href="<?php echo BASE_URL; ?>delivery/dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
    <li class="nav-item"><a class="nav-link <?php echo delivery_nav_active('assigned-orders.php',$current); ?>" href="<?php echo BASE_URL; ?>delivery/assigned-orders.php"><i class="fa-solid fa-clipboard-list"></i> Assigned Orders</a></li>
    <li class="nav-item"><a class="nav-link <?php echo delivery_nav_active('profile.php',$current); ?>" href="<?php echo BASE_URL; ?>delivery/profile.php"><i class="fa-solid fa-user"></i> Profile</a></li>
    <li class="nav-item"><a class="nav-link text-danger" href="<?php echo BASE_URL; ?>delivery/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
  </ul>
</div>

<div class="bfs-main">
  <div class="bfs-topheader">
    <div>
      <button class="btn btn-sm btn-bloom-outline d-lg-none me-2" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
      <strong><?php echo e($page_title ?? 'Dashboard'); ?></strong>
    </div>
    <div class="dropdown">
      <a href="#" class="text-dark dropdown-toggle" data-bs-toggle="dropdown"><i class="fa-solid fa-circle-user me-1"></i> <?php echo e($_SESSION['delivery_name'] ?? 'Staff'); ?></a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>delivery/profile.php">Profile</a></li>
        <li><a class="dropdown-item text-danger" href="<?php echo BASE_URL; ?>delivery/logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
