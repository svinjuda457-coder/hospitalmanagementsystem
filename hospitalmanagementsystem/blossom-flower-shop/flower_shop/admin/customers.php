<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
$page_title = 'Customers';

if (isset($_GET['toggle'])) {
    $pdo->prepare("UPDATE users SET status = IF(status='active','blocked','active') WHERE id=?")->execute([(int)$_GET['toggle']]);
    redirect('admin/customers.php');
}

$customers = $pdo->query("
    SELECT u.*, COUNT(o.id) AS order_count, COALESCE(SUM(o.total),0) AS total_spent
    FROM users u LEFT JOIN orders o ON o.user_id = u.id
    GROUP BY u.id ORDER BY u.created_at DESC
")->fetchAll();

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>
<div class="dash-card">
  <h6 class="mb-3">All Customers (<?php echo count($customers); ?>)</h6>
  <div class="table-responsive">
    <table class="table table-bfs align-middle">
      <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Orders</th><th>Total Spent</th><th>Status</th><th>Action</th></tr></thead>
      <tbody>
      <?php foreach ($customers as $c): ?>
        <tr>
          <td><?php echo e($c['full_name']); ?></td>
          <td><?php echo e($c['email']); ?></td>
          <td><?php echo e($c['phone']); ?></td>
          <td><?php echo $c['order_count']; ?></td>
          <td><?php echo format_price($c['total_spent']); ?></td>
          <td><span class="badge status-badge bg-<?php echo $c['status']=='active'?'success':'danger'; ?>"><?php echo ucfirst($c['status']); ?></span></td>
          <td><a href="?toggle=<?php echo $c['id']; ?>" class="btn btn-sm btn-bloom-outline" onclick="return confirm('<?php echo $c['status']=='active'?'Block':'Unblock'; ?> this customer?');"><?php echo $c['status']=='active'?'Block':'Unblock'; ?></a></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
