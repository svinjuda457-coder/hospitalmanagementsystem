<?php
require_once __DIR__ . '/../includes/auth.php';
require_delivery();
$page_title = 'Dashboard';
$did = $_SESSION['delivery_id'];

$assigned = $pdo->prepare("SELECT COUNT(*) c FROM orders WHERE delivery_staff_id=? AND order_status NOT IN ('delivered','cancelled')");
$assigned->execute([$did]); $assigned = $assigned->fetch()['c'];

$delivered_today = $pdo->prepare("SELECT COUNT(*) c FROM orders WHERE delivery_staff_id=? AND order_status='delivered' AND DATE(created_at)=CURDATE()");
$delivered_today->execute([$did]); $delivered_today = $delivered_today->fetch()['c'];

$pending = $pdo->prepare("SELECT COUNT(*) c FROM orders WHERE delivery_staff_id=? AND order_status='pending'");
$pending->execute([$did]); $pending = $pending->fetch()['c'];

$orders = $pdo->prepare("SELECT * FROM orders WHERE delivery_staff_id=? ORDER BY created_at DESC LIMIT 6");
$orders->execute([$did]);
$orders = $orders->fetchAll();

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>
<div class="row g-4 mb-4">
  <div class="col-md-4">
    <div class="dash-card"><div class="dash-icon"><i class="fa-solid fa-truck"></i></div><h3><?php echo $assigned; ?></h3><p>Assigned Orders</p></div>
  </div>
  <div class="col-md-4">
    <div class="dash-card"><div class="dash-icon"><i class="fa-solid fa-box-open"></i></div><h3><?php echo $delivered_today; ?></h3><p>Delivered Today</p></div>
  </div>
  <div class="col-md-4">
    <div class="dash-card"><div class="dash-icon"><i class="fa-solid fa-hourglass-half"></i></div><h3><?php echo $pending; ?></h3><p>Pending Orders</p></div>
  </div>
</div>

<div class="dash-card">
  <h6 class="mb-3">Recent Assigned Orders</h6>
  <div class="table-responsive">
    <table class="table table-bfs align-middle">
      <thead><tr><th>Order #</th><th>Customer</th><th>City</th><th>Amount</th><th>Status</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($orders as $o): ?>
        <tr>
          <td><?php echo e($o['order_number']); ?></td>
          <td><?php echo e($o['full_name']); ?></td>
          <td><?php echo e($o['city']); ?></td>
          <td><?php echo format_price($o['total']); ?></td>
          <td><?php echo order_status_badge($o['order_status']); ?></td>
          <td><a href="<?php echo BASE_URL; ?>delivery/order-details.php?id=<?php echo $o['id']; ?>" class="btn btn-sm btn-bloom-outline">View</a></td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$orders): ?><tr><td colspan="6" class="text-center text-muted py-4">No orders assigned yet.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
