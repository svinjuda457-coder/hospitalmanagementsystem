<?php
/**
 * Reusable product card partial.
 * Expects $p (product row, optionally joined with cat_name) in scope.
 * Used inside a `.row.g-4` wrapper — prints one `.col-*` per include.
 */
$in_wishlist = false;
if (is_logged_in() && isset($pdo)) {
    $wstmt = $pdo->prepare("SELECT id FROM wishlist WHERE user_id=? AND product_id=?");
    $wstmt->execute([$_SESSION['user_id'], $p['id']]);
    $in_wishlist = (bool)$wstmt->fetch();
}
?>
<div class="col-6 col-md-4 col-lg-3">
  <div class="product-card">
    <div class="product-img-wrap">
      <a href="<?php echo BASE_URL; ?>product-details.php?id=<?php echo $p['id']; ?>">
        <img src="<?php echo product_image_url($p['image']); ?>" alt="<?php echo e($p['name']); ?>">
      </a>
      <?php if (!empty($p['discount_price'])): ?>
        <span class="badge-discount">-<?php echo round((($p['price']-$p['discount_price'])/$p['price'])*100); ?>%</span>
      <?php elseif (!empty($p['is_bestseller'])): ?>
        <span class="badge-bestseller">Bestseller</span>
      <?php endif; ?>
      <button class="wishlist-btn js-toggle-wishlist <?php echo $in_wishlist?'active':''; ?>" data-product-id="<?php echo $p['id']; ?>" title="Add to wishlist">
        <i class="fa-<?php echo $in_wishlist?'solid':'regular'; ?> fa-heart"></i>
      </button>
    </div>
    <div class="product-body">
      <div class="product-cat"><?php echo e($p['cat_name'] ?? ''); ?></div>
      <a href="<?php echo BASE_URL; ?>product-details.php?id=<?php echo $p['id']; ?>" class="product-name d-block"><?php echo e($p['name']); ?></a>
      <div class="rating mb-2">
        <?php for($i=0;$i<5;$i++) echo $i < round($p['rating']) ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>'; ?>
        <span class="text-muted small">(<?php echo $p['rating']; ?>)</span>
      </div>
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <?php if (!empty($p['discount_price'])): ?>
            <span class="price-old"><?php echo format_price($p['price']); ?></span>
            <span class="price-new"><?php echo format_price($p['discount_price']); ?></span>
          <?php else: ?>
            <span class="price-new"><?php echo format_price($p['price']); ?></span>
          <?php endif; ?>
        </div>
        <button class="btn btn-bloom btn-sm js-add-to-cart" data-product-id="<?php echo $p['id']; ?>" title="Add to cart">
          <i class="fa-solid fa-cart-plus"></i>
        </button>
      </div>
    </div>
  </div>
</div>
