<?php
require_once __DIR__ . '/includes/auth.php';
$page_title = 'Search Results';
$q = trim($_GET['q'] ?? '');
$products = [];
if ($q !== '') {
    $stmt = $pdo->prepare("SELECT p.*, c.name AS cat_name FROM products p JOIN categories c ON p.category_id=c.id
                            WHERE p.status='active' AND (p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?)
                            ORDER BY p.created_at DESC");
    $like = "%$q%";
    $stmt->execute([$like, $like, $like]);
    $products = $stmt->fetchAll();
}
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>
<div class="page-banner">
  <div class="container">
    <h1>Search Results</h1>
    <p class="text-muted"><?php echo $q!==''? 'Showing results for "' . e($q) . '"' : 'Enter a search term to find flowers'; ?></p>
  </div>
</div>

<section class="py-5">
  <div class="container">
    <form method="GET" class="mb-4 mx-auto" style="max-width:500px;">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search flowers, bouquets, plants..." value="<?php echo e($q); ?>">
        <button class="btn btn-bloom" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
      </div>
    </form>

    <div class="row g-4">
      <?php if ($q === ''): ?>
        <div class="col-12 text-center text-muted py-4">Start typing above to search our full flower collection.</div>
      <?php elseif ($products): foreach ($products as $p): include __DIR__ . '/includes/product-card.php'; endforeach; else: ?>
        <div class="col-12 text-center text-muted py-5">
          <i class="fa-solid fa-magnifying-glass fa-2x mb-3"></i>
          <p>No flowers matched "<?php echo e($q); ?>". Try a different search term.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
