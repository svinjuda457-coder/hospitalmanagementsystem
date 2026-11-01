<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$page_title = 'My Wishlist';
$uid = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT p.*, c.name AS cat_name
    FROM wishlist w JOIN products p ON w.product_id = p.id JOIN categories c ON p.category_id = c.id
    WHERE w.user_id = ? ORDER BY w.id DESC
");
$stmt->execute([$uid]);
$products = $stmt->fetchAll();

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>
<div class="page-banner">
  <div class="container">
    <h1>My Wishlist</h1>
    <p class="text-muted"><?php echo count($products); ?> item(s) saved</p>
  </div>
</div>

<section class="py-5">
  <div class="container">
    <?php if (!$products): ?>
      <div class="text-center py-5">
        <i class="fa-regular fa-heart fa-3x text-pink mb-3"></i>
        <h5>Your wishlist is empty</h5>
        <a href="<?php echo BASE_URL; ?>products.php" class="btn btn-bloom mt-2">Browse Flowers</a>
      </div>
    <?php else: ?>
      <div class="row g-4">
        <?php foreach ($products as $p): include __DIR__ . '/../includes/product-card.php'; endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
