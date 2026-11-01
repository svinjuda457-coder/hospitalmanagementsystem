<?php
require_once __DIR__ . '/includes/auth.php';
$page_title = 'Register';

if (is_logged_in()) redirect('user/dashboard.php');

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($full_name === '') $errors[] = 'Full name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email is required.';
    if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
    if ($password !== $confirm) $errors[] = 'Passwords do not match.';

    if (!$errors) {
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);
        if ($check->fetch()) {
            $errors[] = 'An account with this email already exists.';
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (full_name, email, phone, password) VALUES (?,?,?,?)");
            $stmt->execute([$full_name, $email, $phone, $hash]);
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['user_name'] = $full_name;
            flash('success', 'Welcome to Blossom Flower Shop!');
            redirect('user/dashboard.php');
        }
    }
}

include __DIR__ . '/includes/header.php';
?>
<div class="auth-wrapper">
  <div class="auth-card" style="max-width:480px;">
    <a href="<?php echo BASE_URL; ?>index.php" class="d-block text-center mb-3 text-pink fs-4 fw-bold"><i class="fa-solid fa-spa"></i> Blossom</a>
    <h3 class="mb-4">Create an Account</h3>
    <?php if ($errors): ?><div class="alert alert-danger"><?php foreach($errors as $err) echo e($err) . '<br>'; ?></div><?php endif; ?>
    <form method="POST">
      <?php echo csrf_field(); ?>
      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="full_name" class="form-control" required value="<?php echo e($_POST['full_name'] ?? ''); ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control" required value="<?php echo e($_POST['email'] ?? ''); ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Phone Number</label>
        <input type="text" name="phone" class="form-control" value="<?php echo e($_POST['phone'] ?? ''); ?>">
      </div>
      <div class="row">
        <div class="col-6 mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required minlength="6">
        </div>
        <div class="col-6 mb-3">
          <label class="form-label">Confirm Password</label>
          <input type="password" name="confirm_password" class="form-control" required minlength="6">
        </div>
      </div>
      <button type="submit" class="btn btn-bloom w-100 mb-3">Register</button>
    </form>
    <p class="text-center mb-0">Already have an account? <a href="<?php echo BASE_URL; ?>login.php" class="text-pink">Login</a></p>
  </div>
</div>
</body>
</html>
