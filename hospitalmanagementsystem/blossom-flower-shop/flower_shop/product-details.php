<?php
require_once __DIR__ . '/includes/auth.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT p.*, c.name AS cat_name, c.id AS cat_id FROM products p JOIN categories c ON p.category_id=c.id WHERE p.id=? AND p.status='active'");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    include __DIR__ . '/includes/header.php';
    include __DIR__ . '/includes/navbar.php';
    echo '<div class="container py-5 text-center"><h3>Product not found</h3><a href="' . BASE_URL . 'products.php" class="btn btn-bloom mt-3">Back to Flowers</a></div>';
    include __DIR__ . '/includes/footer.php';
    exit;
}

$page_title = $product['name'];

// Reviews
$rstmt = $pdo->prepare("SELECT r.*, u.full_name FROM reviews r JOIN users u ON r.user_id=u.id WHERE r.product_id=? AND r.status='visible' ORDER BY r.created_at DESC");
$rstmt->execute([$id]);
$reviews = $rstmt->fetchAll();

// Related products
$related_stmt = $pdo->prepare("SELECT p.*, c.name AS cat_name FROM products p JOIN categories c ON p.category_id=c.id WHERE p.category_id=? AND p.id<>? AND p.status='active' LIMIT 4");
$related_stmt->execute([$product['category_id'], $id]);
$related = $related_stmt->fetchAll();

// Handle review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    require_login();
    verify_csrf();
    $rating = max(1, min(5, (int)$_POST['rating']));
    $comment = trim($_POST['comment']);
    $ins = $pdo->prepare("INSERT INTO reviews (product_id, user_id, rating, comment) VALUES (?,?,?,?)");
    $ins->execute([$id, $_SESSION['user_id'], $rating, $comment]);
    flash('success', 'Thank you! Your review has been posted.');
    redirect('product-details.php?id=' . $id . '#reviews');
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';

$in_wishlist = false;
if (is_logged_in()) {
    $w = $pdo->prepare("SELECT id FROM wishlist WHERE user_id=? AND product_id=?");
    $w->execute([$_SESSION['user_id'], $id]);
    $in_wishlist = (bool)$w->fetch();
}
?>
<div class="container py-4">
  <nav aria-label="breadcrumb" class="breadcrumb-bfs mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>index.php">Home</a></li>
      <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>products.php?category=<?php echo $product['cat_id']; ?>"><?php echo e($product['cat_name']); ?></a></li>
      <li class="breadcrumb-item active"><?php echo e($product['name']); ?></li>
    </ol>
  </nav>

  <?php if ($msg = flash('success')): ?><div class="alert alert-success"><?php echo e($msg); ?></div><?php endif; ?>

  <div class="row g-5">
    <div class="col-lg-6">
      <div class="rounded-bfs overflow-hidden">
        <img src="<?php echo product_image_url($product['image']); ?>" class="img-fluid w-100" style="max-height:500px;object-fit:cover;" alt="<?php echo e($product['name']); ?>">
      </div>
    </div>
    <div class="col-lg-6">
      <span class="product-cat"><?php echo e($product['cat_name']); ?></span>
      <h2 class="mt-1"><?php echo e($product['name']); ?></h2>
      <div class="rating mb-2">
        <?php for($i=0;$i<5;$i++) echo $i < round($product['rating']) ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>'; ?>
        <span class="text-muted small"><?php echo $product['rating']; ?> (<?php echo count($reviews); ?> reviews)</span>
      </div>

      <div class="mb-3">
        <?php if (!empty($product['discount_price'])): ?>
          <span class="price-old fs-5"><?php echo format_price($product['price']); ?></span>
          <span class="price-new fs-3"><?php echo format_price($product['discount_price']); ?></span>
        <?php else: ?>
          <span class="price-new fs-3"><?php echo format_price($product['price']); ?></span>
        <?php endif; ?>
      </div>

      <p class="text-muted"><?php echo nl2br(e($product['description'])); ?></p>

      <p>
        <?php if ($product['stock'] > 0): ?>
          <span class="badge bg-success status-badge"><i class="fa-solid fa-check me-1"></i> In Stock (<?php echo $product['stock']; ?> available)</span>
        <?php else: ?>
          <span class="badge bg-danger status-badge">Out of Stock</span>
        <?php endif; ?>
      </p>

      <div class="d-flex align-items-center gap-3 mb-4">
        <div class="qty-selector">
          <button type="button" class="qty-minus">−</button>
          <input type="number" id="qty-<?php echo $product['id']; ?>" value="1" min="1" max="<?php echo max(1,$product['stock']); ?>">
          <button type="button" class="qty-plus">+</button>
        </div>
        <button class="btn btn-bloom js-add-to-cart" data-product-id="<?php echo $product['id']; ?>" <?php echo $product['stock']<1?'disabled':''; ?>>
          <i class="fa-solid fa-cart-plus me-1"></i> Add to Cart
        </button>
        <a href="<?php echo BASE_URL; ?>user/checkout.php?buy_now=<?php echo $product['id']; ?>" class="btn btn-bloom-outline" <?php echo $product['stock']<1?'onclick="return false;" aria-disabled="true"':''; ?>>
          Buy Now
        </a>
        <button class="wishlist-btn js-toggle-wishlist <?php echo $in_wishlist?'active':''; ?>" data-product-id="<?php echo $product['id']; ?>" style="position:static;">
          <i class="fa-<?php echo $in_wishlist?'solid':'regular'; ?> fa-heart"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Reviews -->
  <div class="mt-5" id="reviews">
    <h4 class="mb-4">Customer Reviews</h4>
    <div class="row g-4">
      <?php if ($reviews): foreach ($reviews as $r): ?>
        <div class="col-md-6">
          <div class="review-card">
            <div class="stars"><?php for($i=0;$i<5;$i++) echo $i < $r['rating'] ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>'; ?></div>
            <p class="mt-2 mb-1"><?php echo e($r['comment']); ?></p>
            <small class="text-muted"><?php echo e($r['full_name']); ?> &middot; <?php echo date('d M Y', strtotime($r['created_at'])); ?></small>
          </div>
        </div>
      <?php endforeach; else: ?>
        <div class="col-12 text-muted">No reviews yet for this product.</div>
      <?php endif; ?>
    </div>

    <div class="mt-4" style="max-width:500px;">
      <h6>Write a Review</h6>
      <?php if (is_logged_in()): ?>
      <form method="POST">
        <?php echo csrf_field(); ?>
        <div class="star-rating mb-3">
          <?php for ($i=5;$i>=1;$i--): ?>
            <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" <?php echo $i==5?'checked':''; ?>>
            <label for="star<?php echo $i; ?>"><i class="fa-solid fa-star"></i></label>
          <?php endfor; ?>
        </div>
        <textarea name="comment" class="form-control mb-2" rows="3" placeholder="Share your experience..." required></textarea>
        <button type="submit" name="submit_review" class="btn btn-bloom">Submit Review</button>
      </form>
      <?php else: ?>
        <p class="text-muted">Please <a href="<?php echo BASE_URL; ?>login.php" class="text-pink">login</a> to write a review.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Related products -->
  <?php if ($related): ?>
  <div class="mt-5">
    <h4 class="mb-4">You May Also Like</h4>
    <div class="row g-4">
      <?php foreach ($related as $p): include __DIR__ . '/includes/product-card.php'; endforeach; ?>
    </div>
  </div>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
