<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
$page_title = 'Reports';

$from = $_GET['from'] ?? date('Y-m-01');
$to = $_GET['to'] ?? date('Y-m-d');

$stmt = $pdo->prepare("SELECT COUNT(*) orders_count, COALESCE(SUM(total),0) revenue FROM orders WHERE DATE(created_at) BETWEEN ? AND ?");
$stmt->execute([$from, $to]);
$summary = $stmt->fetch();

$cat_stmt = $pdo->prepare("
    SELECT c.name, SUM(oi.total) AS revenue, SUM(oi.quantity) AS qty
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    JOIN categories c ON p.category_id = c.id
    JOIN orders o ON oi.order_id = o.id
    WHERE DATE(o.created_at) BETWEEN ? AND ?
    GROUP BY c.id ORDER BY revenue DESC
");
$cat_stmt->execute([$from, $to]);
$by_category = $cat_stmt->fetchAll();

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>
<div class="dash-card mb-4">
  <form method="GET" class="d-flex align-items-end gap-3 flex-wrap">
    <div><label class="form-label">From</label><input type="date" name="from" class="form-control" value="<?php echo e($from); ?>"></div>
    <div><label class="form-label">To</label><input type="date" name="to" class="form-control" value="<?php echo e($to); ?>"></div>
    <button class="btn btn-bloom">Generate Report</button>
  </form>
</div>

<div class="row g-4 mb-4">
  <div class="col-md-6">
    <div class="dash-card"><div class="dash-icon"><i class="fa-solid fa-box"></i></div><h3><?php echo $summary['orders_count']; ?></h3><p>Orders in Period</p></div>
  </div>
  <div class="col-md-6">
    <div class="dash-card"><div class="dash-icon"><i class="fa-solid fa-indian-rupee-sign"></i></div><h3><?php echo format_price($summary['revenue']); ?></h3><p>Revenue in Period</p></div>
  </div>
</div>

<div class="dash-card">
  <h6 class="mb-3">Sales by Category</h6>
  <div class="table-responsive">
    <table class="table table-bfs">
      <thead><tr><th>Category</th><th>Units Sold</th><th>Revenue</th></tr></thead>
      <tbody>
      <?php foreach ($by_category as $row): ?>
        <tr><td><?php echo e($row['name']); ?></td><td><?php echo $row['qty']; ?></td><td><?php echo format_price($row['revenue']); ?></td></tr>
      <?php endforeach; ?>
      <?php if (!$by_category): ?><tr><td colspan="3" class="text-center text-muted py-4">No sales in this period.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
