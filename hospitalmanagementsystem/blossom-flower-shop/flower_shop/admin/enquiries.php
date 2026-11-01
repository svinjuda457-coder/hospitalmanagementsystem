<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
$page_title = 'Enquiries';

if (isset($_GET['mark_read'])) {
    $pdo->prepare("UPDATE enquiries SET status='read' WHERE id=?")->execute([(int)$_GET['mark_read']]);
    redirect('admin/enquiries.php');
}
if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM enquiries WHERE id=?")->execute([(int)$_GET['delete']]);
    redirect('admin/enquiries.php');
}

$enquiries = $pdo->query("SELECT * FROM enquiries ORDER BY created_at DESC")->fetchAll();

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>
<div class="dash-card">
  <h6 class="mb-3">Contact Enquiries (<?php echo count($enquiries); ?>)</h6>
  <div class="table-responsive">
    <table class="table table-bfs align-middle">
      <thead><tr><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
      <tbody>
      <?php foreach ($enquiries as $en): ?>
        <tr>
          <td><?php echo e($en['name']); ?></td>
          <td><?php echo e($en['email']); ?></td>
          <td><?php echo e($en['subject']); ?></td>
          <td style="max-width:260px;" class="small text-truncate"><?php echo e($en['message']); ?></td>
          <td><span class="badge status-badge bg-<?php echo $en['status']=='new'?'warning text-dark':'secondary'; ?>"><?php echo ucfirst($en['status']); ?></span></td>
          <td class="small"><?php echo date('d M Y', strtotime($en['created_at'])); ?></td>
          <td>
            <?php if ($en['status']=='new'): ?><a href="?mark_read=<?php echo $en['id']; ?>" class="btn btn-sm btn-bloom-outline">Mark Read</a><?php endif; ?>
            <a href="?delete=<?php echo $en['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this enquiry?');"><i class="fa-solid fa-trash"></i></a>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$enquiries): ?><tr><td colspan="7" class="text-center text-muted py-4">No enquiries yet.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
