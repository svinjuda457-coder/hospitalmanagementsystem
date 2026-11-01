<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$page_title = 'My Profile';
$uid = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([$uid]);
$user = $stmt->fetch();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $full_name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');

    if ($full_name === '') $errors[] = 'Full name is required.';

    if (!$errors) {
        $upd = $pdo->prepare("UPDATE users SET full_name=?, phone=?, address=?, city=? WHERE id=?");
        $upd->execute([$full_name, $phone, $address, $city, $uid]);
        $_SESSION['user_name'] = $full_name;
        flash('success', 'Profile updated successfully.');
        redirect('user/profile.php');
    }
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>
<div class="page-banner"><div class="container"><h1>My Profile</h1><p class="text-muted">Manage your personal information</p></div></div>

<section class="py-5">
  <div class="container">
    <div class="row justify-content-center g-4">
      <div class="col-lg-8">
        <?php if ($msg = flash('success')): ?><div class="alert alert-success"><?php echo e($msg); ?></div><?php endif; ?>
        <?php if ($errors): ?><div class="alert alert-danger"><?php foreach($errors as $err) echo e($err) . '<br>'; ?></div><?php endif; ?>
        <div class="dash-card mb-4">
          <h5 class="mb-3">Profile Details</h5>
          <form method="POST">
            <?php echo csrf_field(); ?>
            <div class="row g-3">
              <div class="col-md-6"><label class="form-label">Full Name</label><input type="text" name="full_name" class="form-control" value="<?php echo e($user['full_name']); ?>" required></div>
              <div class="col-md-6"><label class="form-label">Email</label><input type="email" class="form-control" value="<?php echo e($user['email']); ?>" disabled></div>
              <div class="col-md-6"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="<?php echo e($user['phone']); ?>"></div>
              <div class="col-md-6"><label class="form-label">City</label><input type="text" name="city" class="form-control" value="<?php echo e($user['city']); ?>"></div>
              <div class="col-12"><label class="form-label">Address</label><textarea name="address" class="form-control" rows="3"><?php echo e($user['address']); ?></textarea></div>
              <div class="col-12"><button type="submit" class="btn btn-bloom">Save Changes</button></div>
            </div>
          </form>
        </div>
        <div class="dash-card">
          <h5 class="mb-3">Security</h5>
          <a href="<?php echo BASE_URL; ?>user/change-password.php" class="btn btn-bloom-outline"><i class="fa-solid fa-key me-1"></i> Change Password</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
