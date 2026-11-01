<?php
require_once __DIR__ . '/includes/auth.php';
$page_title = 'Categories';
$categories = $pdo->query("
    SELECT c.*, COUNT(p.id) AS product_count
    FROM categories c LEFT JOIN products p ON p.category_id = c.id AND p.status='active'
    WHERE c.status='active'
    GROUP BY c.id ORDER BY c.name
")->fetchAll();
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>
<div class="page-banner">
  <div class="container">
    <h1>Flower Categories</h1>
    <p class="text-muted">Explore our full collection by category</p>
  </div>
</div>

<section class="py-5">
  <div class="container">
    <div class="row g-4">
      <?php foreach ($categories as $cat): ?>
      <div class="col-md-4 col-6">
        <a href="<?php echo BASE_URL; ?>products.php?category=<?php echo $cat['id']; ?>" class="category-card d-block" style="height:220px;">
          <img src="https://images.unsplash.com/photo-1487070183336-b863922373d4?w=500&q=70&sig=<?php echo $cat['id']; ?>" alt="<?php echo e($cat['name']); ?>">
          <div class="overlay">
            <span><?php echo e($cat['name']); ?><br><small class="fw-normal"><?php echo $cat['product_count']; ?> products</small></span>
          </div>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
