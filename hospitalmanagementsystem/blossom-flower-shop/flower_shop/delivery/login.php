<?php
require_once __DIR__ . '/../includes/auth.php';
$page_title = 'Delivery Staff Login';

if (is_delivery()) redirect('delivery/dashboard.php');

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM delivery_staff WHERE email = ?");
    $stmt->execute([$email]);
    $staff = $stmt->fetch();

    if ($staff && password_verify($password, $staff['password'])) {
        if ($staff['status'] === 'inactive') {
            $error = 'Your account is inactive. Please contact the admin.';
        } else {
            $_SESSION['delivery_id'] = $staff['id'];
            $_SESSION['delivery_name'] = $staff['name'];
            redirect('delivery/dashboard.php');
        }
    } else {
        $error = 'Invalid delivery staff credentials.';
    }
}

include __DIR__ . '/../includes/header.php';
?>
<div class="auth-wrapper">
  <div class="auth-card">
    <div class="text-center mb-3"><i class="fa-solid fa-truck-fast fa-2x text-pink"></i></div>
    <h3 class="mb-4">Delivery Staff Login</h3>
    <?php if ($error): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
    <form method="POST">
      <?php echo csrf_field(); ?>
      <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
      <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
      <button type="submit" class="btn btn-bloom w-100 mb-3">Login</button>
    </form>
    <p class="text-center"><a href="<?php echo BASE_URL; ?>login.php" class="text-muted small">&larr; Back to Customer Login</a></p>
    <div class="alert alert-light border mt-3 small mb-0">Demo staff: <strong>delivery@blossom.com</strong> / <strong>delivery123</strong></div>
  </div>
</div>
</body>
</html>
