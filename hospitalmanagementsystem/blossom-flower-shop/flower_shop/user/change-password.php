<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$page_title = 'Change Password';
$uid = $_SESSION['user_id'];

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    $stmt = $pdo->prepare("SELECT password FROM users WHERE id=?");
    $stmt->execute([$uid]);
    $row = $stmt->fetch();

    if (!password_verify($current, $row['password'])) $errors[] = 'Current password is incorrect.';
    if (strlen($new) < 6) $errors[] = 'New password must be at least 6 characters.';
    if ($new !== $confirm) $errors[] = 'New passwords do not match.';

    if (!$errors) {
        $hash = password_hash($new, PASSWORD_BCRYPT);
        $pdo->prepare("UPDATE users SET password=? WHERE id=?")->execute([$hash, $uid]);
        flash('success', 'Password changed successfully.');
        redirect('user/profile.php');
    }
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>
<div class="page-banner"><div class="container"><h1>Change Password</h1></div></div>

<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <?php if ($errors): ?><div class="alert alert-danger"><?php foreach($errors as $err) echo e($err) . '<br>'; ?></div><?php endif; ?>
        <div class="dash-card">
          <form method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-3"><label class="form-label">Current Password</label><input type="password" name="current_password" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">New Password</label><input type="password" name="new_password" class="form-control" required minlength="6"></div>
            <div class="mb-3"><label class="form-label">Confirm New Password</label><input type="password" name="confirm_password" class="form-control" required minlength="6"></div>
            <button type="submit" class="btn btn-bloom">Update Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
