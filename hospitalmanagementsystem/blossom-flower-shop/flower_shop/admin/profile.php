<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
$page_title = 'Admin Profile';
$aid = $_SESSION['admin_id'];

$stmt = $pdo->prepare("SELECT * FROM admins WHERE id=?");
$stmt->execute([$aid]);
$admin = $stmt->fetch();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    if (isset($_POST['update_profile'])) {
        $name = trim($_POST['name']);
        if ($name === '') $errors[] = 'Name is required.';
        if (!$errors) {
            $pdo->prepare("UPDATE admins SET name=? WHERE id=?")->execute([$name, $aid]);
            $_SESSION['admin_name'] = $name;
            flash('success', 'Profile updated.');
            redirect('admin/profile.php');
        }
    } elseif (isset($_POST['change_password'])) {
        $current = $_POST['current_password'];
        $new = $_POST['new_password'];
        $confirm = $_POST['confirm_password'];
        if (!password_verify($current, $admin['password'])) $errors[] = 'Current password is incorrect.';
        if (strlen($new) < 6) $errors[] = 'New password must be at least 6 characters.';
        if ($new !== $confirm) $errors[] = 'New passwords do not match.';
        if (!$errors) {
            $pdo->prepare("UPDATE admins SET password=? WHERE id=?")->execute([password_hash($new, PASSWORD_BCRYPT), $aid]);
            flash('success', 'Password changed successfully.');
            redirect('admin/profile.php');
        }
    }
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>
<?php if ($msg = flash('success')): ?><div class="alert alert-success"><?php echo e($msg); ?></div><?php endif; ?>
<?php if ($errors): ?><div class="alert alert-danger"><?php foreach($errors as $err) echo e($err) . '<br>'; ?></div><?php endif; ?>

<div class="row g-4">
  <div class="col-lg-6">
    <div class="dash-card">
      <h6 class="mb-3">Profile Details</h6>
      <form method="POST">
        <?php echo csrf_field(); ?>
        <div class="mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" value="<?php echo e($admin['name']); ?>" required></div>
        <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control" value="<?php echo e($admin['email']); ?>" disabled></div>
        <button type="submit" name="update_profile" class="btn btn-bloom">Save Changes</button>
      </form>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="dash-card">
      <h6 class="mb-3">Change Password</h6>
      <form method="POST">
        <?php echo csrf_field(); ?>
        <div class="mb-3"><label class="form-label">Current Password</label><input type="password" name="current_password" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">New Password</label><input type="password" name="new_password" class="form-control" required minlength="6"></div>
        <div class="mb-3"><label class="form-label">Confirm New Password</label><input type="password" name="confirm_password" class="form-control" required minlength="6"></div>
        <button type="submit" name="change_password" class="btn btn-bloom">Update Password</button>
      </form>
    </div>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
