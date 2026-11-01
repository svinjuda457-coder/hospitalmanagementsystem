<?php
require_once __DIR__ . '/includes/auth.php';
$page_title = 'Contact Us';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '') $errors[] = 'Name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email is required.';
    if ($message === '') $errors[] = 'Message cannot be empty.';

    if (!$errors) {
        $stmt = $pdo->prepare("INSERT INTO enquiries (name, email, phone, subject, message) VALUES (?,?,?,?,?)");
        $stmt->execute([$name, $email, $phone, $subject, $message]);
        flash('success', 'Thank you for reaching out! We will get back to you soon.');
        redirect('contact.php');
    }
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>
<div class="page-banner">
  <div class="container">
    <h1>Contact Us</h1>
    <p class="text-muted">We'd love to hear from you</p>
  </div>
</div>

<section class="py-5">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-5">
        <h4 class="mb-4">Get In Touch</h4>
        <div class="d-flex mb-4">
          <div class="dash-icon me-3"><i class="fa-solid fa-location-dot"></i></div>
          <div><strong>Our Store</strong><p class="text-muted mb-0">12 Garden Street, Rajkot, Gujarat, India</p></div>
        </div>
        <div class="d-flex mb-4">
          <div class="dash-icon me-3"><i class="fa-solid fa-phone"></i></div>
          <div><strong>Call Us</strong><p class="text-muted mb-0">+91 98765 43210</p></div>
        </div>
        <div class="d-flex mb-4">
          <div class="dash-icon me-3"><i class="fa-solid fa-envelope"></i></div>
          <div><strong>Email Us</strong><p class="text-muted mb-0">hello@blossomflowers.com</p></div>
        </div>
        <div class="d-flex">
          <div class="dash-icon me-3"><i class="fa-solid fa-clock"></i></div>
          <div><strong>Working Hours</strong><p class="text-muted mb-0">Mon - Sun: 8:00 AM - 9:00 PM</p></div>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="dash-card">
          <h5 class="mb-3">Send Us a Message</h5>
          <?php if ($msg = flash('success')): ?><div class="alert alert-success"><?php echo e($msg); ?></div><?php endif; ?>
          <?php if ($errors): ?><div class="alert alert-danger"><?php foreach($errors as $err) echo e($err) . '<br>'; ?></div><?php endif; ?>
          <form method="POST">
            <?php echo csrf_field(); ?>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" required value="<?php echo e($_POST['name'] ?? ''); ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required value="<?php echo e($_POST['email'] ?? ''); ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="<?php echo e($_POST['phone'] ?? ''); ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Subject</label>
                <input type="text" name="subject" class="form-control" value="<?php echo e($_POST['subject'] ?? ''); ?>">
              </div>
              <div class="col-12">
                <label class="form-label">Message</label>
                <textarea name="message" rows="5" class="form-control" required><?php echo e($_POST['message'] ?? ''); ?></textarea>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-bloom">Send Message</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
