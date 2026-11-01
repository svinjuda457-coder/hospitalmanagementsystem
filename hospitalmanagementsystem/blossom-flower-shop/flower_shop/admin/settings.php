<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
$page_title = 'Settings';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    flash('success', 'Settings saved (demo only — wire this up to a settings table for production use).');
    redirect('admin/settings.php');
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>
<?php if ($msg = flash('success')): ?><div class="alert alert-success"><?php echo e($msg); ?></div><?php endif; ?>

<div class="dash-card" style="max-width:700px;">
  <h6 class="mb-3">Store Settings</h6>
  <form method="POST">
    <?php echo csrf_field(); ?>
    <div class="mb-3"><label class="form-label">Store Name</label><input type="text" class="form-control" value="Blossom Flower Shop"></div>
    <div class="mb-3"><label class="form-label">Support Email</label><input type="email" class="form-control" value="hello@blossomflowers.com"></div>
    <div class="mb-3"><label class="form-label">Support Phone</label><input type="text" class="form-control" value="+91 98765 43210"></div>
    <div class="mb-3"><label class="form-label">Free Delivery Threshold (₹)</label><input type="number" class="form-control" value="999"></div>
    <div class="mb-3"><label class="form-label">Delivery Fee (₹)</label><input type="number" class="form-control" value="60"></div>
    <button type="submit" class="btn btn-bloom">Save Settings</button>
  </form>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
