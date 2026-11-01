<?php
require_once __DIR__ . '/includes/auth.php';

$page_title = 'Home';

$categories = $pdo->query("SELECT * FROM categories WHERE status='active' ORDER BY id LIMIT 8")->fetchAll();
$bestsellers = $pdo->query("SELECT p.*, c.name AS cat_name FROM products p JOIN categories c ON p.category_id=c.id WHERE p.is_bestseller=1 AND p.status='active' ORDER BY p.id DESC LIMIT 8")->fetchAll();
$featured = $pdo->query("SELECT p.*, c.name AS cat_name FROM products p JOIN categories c ON p.category_id=c.id WHERE p.is_featured=1 AND p.status='active' ORDER BY p.id DESC LIMIT 8")->fetchAll();
$reviews = $pdo->query("SELECT r.*, u.full_name FROM reviews r JOIN users u ON r.user_id=u.id WHERE r.status='visible' ORDER BY r.id DESC LIMIT 3")->fetchAll();

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<!-- HERO -->
<section class="bfs-hero">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <span class="text-pink fw-semibold text-uppercase" style="letter-spacing:2px;">Fresh &amp; Handpicked</span>
        <h1 class="mt-2 mb-3">Fresh Flowers, <br>For Every Emotion</h1>
        <p class="lead">From birthdays to anniversaries, say it beautifully with Blossom's handcrafted floral arrangements delivered fresh to your door.</p>
        <a href="<?php echo BASE_URL; ?>products.php" class="btn btn-bloom btn-lg mt-2">
          <i class="fa-solid fa-basket-shopping me-2"></i>Shop Now
        </a>
      </div>
      <div class="col-lg-6">
        <img src="https://images.unsplash.com/photo-1490750967868-88aa4486c946?w=900&q=80" class="img-fluid w-100" alt="Fresh flower bouquet" style="max-height:420px;object-fit:cover;">
      </div>
    </div>
  </div>
</section>

<!-- CATEGORIES -->
<section class="py-5">
  <div class="container">
    <div class="section-title">
      <span>Browse By</span>
      <h2>Flower Categories</h2>
      <div class="divider"></div>
    </div>
    <div class="row g-4">
      <?php foreach ($categories as $cat): ?>
      <div class="col-6 col-md-3">
        <a href="<?php echo BASE_URL; ?>products.php?category=<?php echo $cat['id']; ?>" class="category-card d-block">
          <img src="https://images.unsplash.com/photo-1487070183336-b863922373d4?w=400&q=70&sig=<?php echo $cat['id']; ?>" alt="<?php echo e($cat['name']); ?>">
          <div class="overlay"><span><?php echo e($cat['name']); ?></span></div>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- BEST SELLING -->
<section class="py-5 bg-pink-light">
  <div class="container">
    <div class="section-title">
      <span>Customer Favourites</span>
      <h2>Best Selling Flowers</h2>
      <div class="divider"></div>
    </div>
    <div class="row g-4">
      <?php foreach ($bestsellers as $p): include __DIR__ . '/includes/product-card.php'; endforeach; ?>
    </div>
  </div>
</section>

<!-- FEATURED -->
<section class="py-5">
  <div class="container">
    <div class="section-title">
      <span>Handpicked For You</span>
      <h2>Featured Products</h2>
      <div class="divider"></div>
    </div>
    <div class="row g-4">
      <?php foreach ($featured as $p): include __DIR__ . '/includes/product-card.php'; endforeach; ?>
    </div>
  </div>
</section>

<!-- WHY CHOOSE US -->
<section class="py-5 bg-pink-light">
  <div class="container">
    <div class="section-title">
      <span>Our Promise</span>
      <h2>Why Choose Blossom?</h2>
      <div class="divider"></div>
    </div>
    <div class="row g-4">
      <div class="col-md-3 col-6">
        <div class="feature-box"><div class="icon-circle"><i class="fa-solid fa-leaf"></i></div><h6>Farm Fresh Flowers</h6><p class="small text-muted">Sourced daily from local growers</p></div>
      </div>
      <div class="col-md-3 col-6">
        <div class="feature-box"><div class="icon-circle"><i class="fa-solid fa-truck-fast"></i></div><h6>Same-Day Delivery</h6><p class="small text-muted">Order before 3 PM for same day dispatch</p></div>
      </div>
      <div class="col-md-3 col-6">
        <div class="feature-box"><div class="icon-circle"><i class="fa-solid fa-shield-heart"></i></div><h6>Freshness Guarantee</h6><p class="small text-muted">7-day freshness or your money back</p></div>
      </div>
      <div class="col-md-3 col-6">
        <div class="feature-box"><div class="icon-circle"><i class="fa-solid fa-headset"></i></div><h6>24/7 Support</h6><p class="small text-muted">We're here whenever you need us</p></div>
      </div>
    </div>
  </div>
</section>

<!-- REVIEWS -->
<section class="py-5">
  <div class="container">
    <div class="section-title">
      <span>Testimonials</span>
      <h2>What Our Customers Say</h2>
      <div class="divider"></div>
    </div>
    <div class="row g-4">
      <?php if ($reviews): foreach ($reviews as $r): ?>
      <div class="col-md-4">
        <div class="review-card">
          <div class="stars">
            <?php for ($i=0;$i<5;$i++) echo $i < $r['rating'] ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>'; ?>
          </div>
          <p class="mt-3">"<?php echo e($r['comment']); ?>"</p>
          <div class="reviewer">
            <div class="avatar"><?php echo strtoupper(substr($r['full_name'],0,1)); ?></div>
            <div><strong><?php echo e($r['full_name']); ?></strong><div class="small text-muted">Verified Buyer</div></div>
          </div>
        </div>
      </div>
      <?php endforeach; else: ?>
        <div class="col-12 text-center text-muted">No reviews yet. Be the first to review a product!</div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- NEWSLETTER -->
<section class="py-5">
  <div class="container">
    <div class="newsletter-section text-center">
      <h3 class="text-white mb-2">Join Our Blossom Family</h3>
      <p class="mb-4">Subscribe for exclusive offers, floral tips and seasonal collections.</p>
      <form class="d-flex justify-content-center flex-wrap gap-2" onsubmit="showToast('Thanks for subscribing!'); this.reset(); return false;">
        <input type="email" required placeholder="Enter your email" class="form-control" style="max-width:320px;">
        <button type="submit">Subscribe</button>
      </form>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
