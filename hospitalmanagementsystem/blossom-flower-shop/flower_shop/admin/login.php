<?php
require_once __DIR__ . '/../includes/auth.php';
$page_title = 'Admin Login';

if (is_admin()) redirect('admin/dashboard.php');

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        redirect('admin/dashboard.php');
    } else {
        $error = 'Invalid admin credentials.';
    }
}

include __DIR__ . '/../includes/header.php';
?>
<div class="auth-wrapper">
  <div class="auth-card">
    <div class="text-center mb-3"><i class="fa-solid fa-user-shield fa-2x text-pink"></i></div>
    <h3 class="mb-4">Admin Login</h3>
    <?php if ($error): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
    <form method="POST">
      <?php echo csrf_field(); ?>
      <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
      <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
      <button type="submit" class="btn btn-bloom w-100 mb-3">Login</button>
    </form>
    <p class="text-center"><a href="<?php echo BASE_URL; ?>login.php" class="text-muted small">&larr; Back to Customer Login</a></p>
    <div class="alert alert-light border mt-3 small mb-0">Demo admin: <strong>admin@blossom.com</strong> / <strong>admin123</strong></div>
  </div>
</div>
</body>
</html>
