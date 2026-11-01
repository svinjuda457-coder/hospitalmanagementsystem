<?php
require_once __DIR__ . '/includes/auth.php';
$page_title = 'Our Flowers';

$category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$sort = $_GET['sort'] ?? 'newest';
$featured_only = isset($_GET['featured']);

$where = ["p.status = 'active'"];
$params = [];
if ($category_id) { $where[] = "p.category_id = ?"; $params[] = $category_id; }
if ($featured_only) { $where[] = "p.is_featured = 1"; }
$where_sql = implode(' AND ', $where);

$order_sql = "p.created_at DESC";
if ($sort === 'price_low') $order_sql = "COALESCE(p.discount_price, p.price) ASC";
if ($sort === 'price_high') $order_sql = "COALESCE(p.discount_price, p.price) DESC";
if ($sort === 'rating') $order_sql = "p.rating DESC";

$sql = "SELECT p.*, c.name AS cat_name FROM products p JOIN categories c ON p.category_id = c.id WHERE $where_sql ORDER BY $order_sql";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

$categories = $pdo->query("SELECT * FROM categories WHERE status='active' ORDER BY name")->fetchAll();

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>
<div class="page-banner">
  <div class="container">
    <h1>Our Flowers</h1>
    <p class="text-muted">Fresh blooms for every occasion</p>
  </div>
</div>

<section class="py-5">
  <div class="container">
    <div class="row g-4">
      <!-- Sidebar filters -->
      <div class="col-lg-3">
        <div class="dash-card mb-4">
          <h6 class="mb-3">Categories</h6>
          <ul class="list-unstyled mb-0">
            <li class="mb-2"><a href="<?php echo BASE_URL; ?>products.php" class="<?php echo !$category_id?'text-pink fw-semibold':'text-dark'; ?>">All Flowers</a></li>
            <?php foreach ($categories as $cat): ?>
              <li class="mb-2">
                <a href="<?php echo BASE_URL; ?>products.php?category=<?php echo $cat['id']; ?>" class="<?php echo $category_id==$cat['id']?'text-pink fw-semibold':'text-dark'; ?>">
                  <?php echo e($cat['name']); ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <!-- Products -->
      <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
          <span class="text-muted"><?php echo count($products); ?> products found</span>
          <form method="GET" class="d-flex align-items-center gap-2">
            <?php if ($category_id): ?><input type="hidden" name="category" value="<?php echo $category_id; ?>"><?php endif; ?>
            <label class="small text-muted mb-0">Sort by:</label>
            <select name="sort" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
              <option value="newest" <?php echo $sort=='newest'?'selected':''; ?>>Newest</option>
              <option value="price_low" <?php echo $sort=='price_low'?'selected':''; ?>>Price: Low to High</option>
              <option value="price_high" <?php echo $sort=='price_high'?'selected':''; ?>>Price: High to Low</option>
              <option value="rating" <?php echo $sort=='rating'?'selected':''; ?>>Top Rated</option>
            </select>
          </form>
        </div>
        <div class="row g-4">
          <?php if ($products): foreach ($products as $p): include __DIR__ . '/includes/product-card.php'; endforeach; else: ?>
            <div class="col-12 text-center text-muted py-5">
              <i class="fa-solid fa-seedling fa-2x mb-3"></i>
              <p>No flowers found in this category yet.</p>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
