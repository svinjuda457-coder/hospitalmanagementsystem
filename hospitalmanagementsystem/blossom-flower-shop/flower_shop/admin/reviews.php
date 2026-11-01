<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
$page_title = 'Reviews';

if (isset($_GET['toggle'])) {
    $pdo->prepare("UPDATE reviews SET status = IF(status='visible','hidden','visible') WHERE id=?")->execute([(int)$_GET['toggle']]);
    redirect('admin/reviews.php');
}
if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM reviews WHERE id=?")->execute([(int)$_GET['delete']]);
    redirect('admin/reviews.php');
}

$reviews = $pdo->query("
    SELECT r.*, u.full_name, p.name AS product_name
    FROM reviews r JOIN users u ON r.user_id=u.id JOIN products p ON r.product_id=p.id
    ORDER BY r.created_at DESC
")->fetchAll();

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>
<div class="dash-card">
  <h6 class="mb-3">Product Reviews (<?php echo count($reviews); ?>)</h6>
  <div class="table-responsive">
    <table class="table table-bfs align-middle">
      <thead><tr><th>Product</th><th>Customer</th><th>Rating</th><th>Comment</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
      <?php foreach ($reviews as $r): ?>
        <tr>
          <td><?php echo e($r['product_name']); ?></td>
          <td><?php echo e($r['full_name']); ?></td>
          <td class="text-warning"><?php echo str_repeat('★', $r['rating']) . str_repeat('☆', 5-$r['rating']); ?></td>
          <td style="max-width:260px;" class="small text-truncate"><?php echo e($r['comment']); ?></td>
          <td><span class="badge status-badge bg-<?php echo $r['status']=='visible'?'success':'secondary'; ?>"><?php echo ucfirst($r['status']); ?></span></td>
          <td>
            <a href="?toggle=<?php echo $r['id']; ?>" class="btn btn-sm btn-bloom-outline"><?php echo $r['status']=='visible'?'Hide':'Show'; ?></a>
            <a href="?delete=<?php echo $r['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this review?');"><i class="fa-solid fa-trash"></i></a>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$reviews): ?><tr><td colspan="6" class="text-center text-muted py-4">No reviews yet.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
