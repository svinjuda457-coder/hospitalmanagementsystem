<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
$page_title = 'Payments';

$payments = $pdo->query("
    SELECT p.*, o.order_number, u.full_name
    FROM payments p JOIN orders o ON p.order_id = o.id JOIN users u ON p.user_id = u.id
    ORDER BY p.created_at DESC
")->fetchAll();

$total_success = $pdo->query("SELECT COALESCE(SUM(amount),0) t FROM payments WHERE status='success'")->fetch()['t'];
$total_pending = $pdo->query("SELECT COALESCE(SUM(amount),0) t FROM payments WHERE status='pending'")->fetch()['t'];

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>
<div class="row g-4 mb-4">
  <div class="col-md-6">
    <div class="dash-card"><div class="dash-icon"><i class="fa-solid fa-circle-check"></i></div><h3><?php echo format_price($total_success); ?></h3><p>Successful Payments</p></div>
  </div>
  <div class="col-md-6">
    <div class="dash-card"><div class="dash-icon"><i class="fa-solid fa-clock"></i></div><h3><?php echo format_price($total_pending); ?></h3><p>Pending (COD) Payments</p></div>
  </div>
</div>

<div class="dash-card">
  <h6 class="mb-3">Payment Transactions</h6>
  <div class="table-responsive">
    <table class="table table-bfs align-middle">
      <thead><tr><th>Order #</th><th>Customer</th><th>Method</th><th>Amount</th><th>Transaction ID</th><th>Status</th><th>Date</th></tr></thead>
      <tbody>
      <?php foreach ($payments as $p): ?>
        <tr>
          <td><?php echo e($p['order_number']); ?></td>
          <td><?php echo e($p['full_name']); ?></td>
          <td><?php echo e($p['method']); ?></td>
          <td><?php echo format_price($p['amount']); ?></td>
          <td><?php echo $p['transaction_id'] ? e($p['transaction_id']) : '—'; ?></td>
          <td><span class="badge status-badge bg-<?php echo $p['status']=='success'?'success':($p['status']=='failed'?'danger':'secondary'); ?>"><?php echo ucfirst($p['status']); ?></span></td>
          <td><?php echo date('d M Y', strtotime($p['created_at'])); ?></td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$payments): ?><tr><td colspan="7" class="text-center text-muted py-4">No payments recorded yet.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
