<?php
require_once __DIR__ . '/includes/auth.php';
$page_title = 'Login';

if (is_logged_in()) redirect('user/dashboard.php');

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Please enter both email and password.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            if ($user['status'] === 'blocked') {
                $error = 'Your account has been blocked. Please contact support.';
            } else {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                $redirect_to = $_SESSION['redirect_after_login'] ?? 'user/dashboard.php';
                unset($_SESSION['redirect_after_login']);
                redirect(str_replace(BASE_URL, '', $redirect_to));
            }
        } else {
            $error = 'Invalid email or password.';
        }
    }
}

include __DIR__ . '/includes/header.php';
?>
<div class="auth-wrapper">
  <div class="auth-card">
    <a href="<?php echo BASE_URL; ?>index.php" class="d-block text-center mb-3 text-pink fs-4 fw-bold"><i class="fa-solid fa-spa"></i> Blossom</a>
    <h3 class="mb-4">Customer Login</h3>
    <?php if ($error): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
    <form method="POST">
      <?php echo csrf_field(); ?>
      <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control" required value="<?php echo e($_POST['email'] ?? ''); ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-bloom w-100 mb-3">Login</button>
    </form>
    <p class="text-center mb-1">Don't have an account? <a href="<?php echo BASE_URL; ?>register.php" class="text-pink">Register</a></p>
    <hr>
    <div class="text-center small">
      <a href="<?php echo BASE_URL; ?>admin/login.php" class="text-muted me-3"><i class="fa-solid fa-user-shield me-1"></i>Admin Login</a>
      <a href="<?php echo BASE_URL; ?>delivery/login.php" class="text-muted"><i class="fa-solid fa-truck me-1"></i>Delivery Staff Login</a>
    </div>
    <div class="alert alert-light border mt-3 small mb-0">
      Demo customer account: <strong>customer@blossom.com</strong> / <strong>customer123</strong>
    </div>
  </div>
</div>
</body>
</html>
