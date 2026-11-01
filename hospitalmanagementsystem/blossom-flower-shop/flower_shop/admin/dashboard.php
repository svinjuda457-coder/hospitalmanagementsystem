<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
$page_title = 'Dashboard';

$total_orders = $pdo->query("SELECT COUNT(*) c FROM orders")->fetch()['c'];
$total_customers = $pdo->query("SELECT COUNT(*) c FROM users")->fetch()['c'];
$total_products = $pdo->query("SELECT COUNT(*) c FROM products")->fetch()['c'];
$total_revenue = $pdo->query("SELECT COALESCE(SUM(total),0) r FROM orders WHERE payment_status='paid' OR payment_method='COD'")->fetch()['r'];

$pending = $pdo->query("SELECT COUNT(*) c FROM orders WHERE order_status='pending'")->fetch()['c'];
$processing = $pdo->query("SELECT COUNT(*) c FROM orders WHERE order_status='processing'")->fetch()['c'];
$shipped = $pdo->query("SELECT COUNT(*) c FROM orders WHERE order_status='shipped'")->fetch()['c'];
$delivered = $pdo->query("SELECT COUNT(*) c FROM orders WHERE order_status='delivered'")->fetch()['c'];

$recent_orders = $pdo->query("SELECT o.*, u.full_name FROM orders o JOIN users u ON o.user_id=u.id ORDER BY o.created_at DESC LIMIT 6")->fetchAll();
$top_products = $pdo->query("
    SELECT p.name, p.image, SUM(oi.quantity) AS sold
    FROM order_items oi JOIN products p ON oi.product_id = p.id
    GROUP BY oi.product_id ORDER BY sold DESC LIMIT 5
")->fetchAll();

// Sales for last 7 days (for chart)
$sales_data = $pdo->query("
    SELECT DATE(created_at) AS d, SUM(total) AS total
    FROM orders WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
    GROUP BY DATE(created_at) ORDER BY d
")->fetchAll();
$sales_labels = []; $sales_values = [];
for ($i = 6; $i >= 0; $i--) {
    $d = date('Y-m-d', strtotime("-$i day"));
    $sales_labels[] = date('d M', strtotime($d));
    $match = array_filter($sales_data, fn($r) => $r['d'] === $d);
    $sales_values[] = $match ? array_values($match)[0]['total'] : 0;
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>
<div class="row g-4 mb-4">
  <div class="col-xl-3 col-md-6">
    <div class="dash-card"><div class="dash-icon"><i class="fa-solid fa-box"></i></div><h3><?php echo $total_orders; ?></h3><p>Total Orders</p></div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="dash-card"><div class="dash-icon"><i class="fa-solid fa-users"></i></div><h3><?php echo $total_customers; ?></h3><p>Total Customers</p></div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="dash-card"><div class="dash-icon"><i class="fa-solid fa-seedling"></i></div><h3><?php echo $total_products; ?></h3><p>Total Products</p></div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="dash-card"><div class="dash-icon"><i class="fa-solid fa-indian-rupee-sign"></i></div><h3><?php echo format_price($total_revenue); ?></h3><p>Total Revenue</p></div>
  </div>
</div>

<div class="row g-4 mb-4">
  <div class="col-xl-3 col-md-6"><div class="dash-card" style="border-left-color:#6c757d;"><h3><?php echo $pending; ?></h3><p>Pending Orders</p></div></div>
  <div class="col-xl-3 col-md-6"><div class="dash-card" style="border-left-color:#0dcaf0;"><h3><?php echo $processing; ?></h3><p>Processing Orders</p></div></div>
  <div class="col-xl-3 col-md-6"><div class="dash-card" style="border-left-color:#0d6efd;"><h3><?php echo $shipped; ?></h3><p>Shipped Orders</p></div></div>
  <div class="col-xl-3 col-md-6"><div class="dash-card" style="border-left-color:#198754;"><h3><?php echo $delivered; ?></h3><p>Delivered Orders</p></div></div>
</div>

<div class="row g-4 mb-4">
  <div class="col-lg-8">
    <div class="dash-card">
      <h6 class="mb-3">Sales Overview (Last 7 Days)</h6>
      <canvas id="salesChart" height="110"></canvas>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="dash-card">
      <h6 class="mb-3">Order Status Breakdown</h6>
      <canvas id="statusChart" height="180"></canvas>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-7">
    <div class="dash-card">
      <h6 class="mb-3">Recent Orders</h6>
      <div class="table-responsive">
        <table class="table table-bfs align-middle">
          <thead><tr><th>Order #</th><th>Customer</th><th>Total</th><th>Status</th></tr></thead>
          <tbody>
          <?php foreach ($recent_orders as $o): ?>
            <tr>
              <td><a href="<?php echo BASE_URL; ?>admin/order-details.php?id=<?php echo $o['id']; ?>"><?php echo e($o['order_number']); ?></a></td>
              <td><?php echo e($o['full_name']); ?></td>
              <td><?php echo format_price($o['total']); ?></td>
              <td><?php echo order_status_badge($o['order_status']); ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="dash-card">
      <h6 class="mb-3">Top Selling Flowers</h6>
      <?php foreach ($top_products as $tp): ?>
        <div class="d-flex align-items-center justify-content-between mb-3">
          <div class="d-flex align-items-center gap-2">
            <img src="<?php echo product_image_url($tp['image']); ?>" style="width:40px;height:40px;object-fit:cover;border-radius:8px;">
            <span class="small"><?php echo e($tp['name']); ?></span>
          </div>
          <span class="badge bg-pink-light text-pink"><?php echo $tp['sold']; ?> sold</span>
        </div>
      <?php endforeach; ?>
      <?php if (!$top_products): ?><p class="text-muted small mb-0">No sales data yet.</p><?php endif; ?>
    </div>
  </div>
</div>

<script>
const salesCtx = document.getElementById('salesChart');
new Chart(salesCtx, {
  type: 'line',
  data: {
    labels: <?php echo json_encode($sales_labels); ?>,
    datasets: [{
      label: 'Sales (₹)',
      data: <?php echo json_encode($sales_values); ?>,
      borderColor: '#e85d8a',
      backgroundColor: 'rgba(232,93,138,0.12)',
      fill: true, tension: 0.35, pointBackgroundColor: '#e85d8a'
    }]
  },
  options: { plugins: { legend: { display: false } } }
});

const statusCtx = document.getElementById('statusChart');
new Chart(statusCtx, {
  type: 'doughnut',
  data: {
    labels: ['Pending','Processing','Shipped','Delivered'],
    datasets: [{
      data: [<?php echo $pending; ?>, <?php echo $processing; ?>, <?php echo $shipped; ?>, <?php echo $delivered; ?>],
      backgroundColor: ['#6c757d','#0dcaf0','#0d6efd','#198754']
    }]
  }
});
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
