<?php
require_once __DIR__ . '/includes/auth.php';
$page_title = 'About Us';
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>
<div class="page-banner">
  <div class="container">
    <h1>About Blossom Flower Shop</h1>
    <p class="text-muted">Our story, our passion, our promise</p>
  </div>
</div>

<section class="py-5">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <img src="https://images.unsplash.com/photo-1526397751294-331021109fbd?w=800&q=80" class="img-fluid rounded-bfs" alt="Florist arranging flowers">
      </div>
      <div class="col-lg-6">
        <span class="text-pink fw-semibold text-uppercase" style="letter-spacing:2px;">Our Story</span>
        <h2 class="mt-2 mb-3">Blooming With Passion Since Day One</h2>
        <p>Blossom Flower Shop began with a simple idea — that fresh, beautiful flowers should be easy to send and a joy to receive. What started as a small neighbourhood flower stall has grown into a trusted online destination for fresh blooms, thoughtful bouquets, and same-day delivery.</p>
        <p>Every stem we sell is hand-selected by our florists, and every arrangement is crafted with care before it reaches your doorstep.</p>
        <div class="row mt-4 g-3">
          <div class="col-4 text-center">
            <h3 class="text-pink mb-0">10+</h3><small class="text-muted">Years of Service</small>
          </div>
          <div class="col-4 text-center">
            <h3 class="text-pink mb-0">50k+</h3><small class="text-muted">Happy Customers</small>
          </div>
          <div class="col-4 text-center">
            <h3 class="text-pink mb-0">200+</h3><small class="text-muted">Flower Varieties</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5 bg-pink-light">
  <div class="container">
    <div class="section-title">
      <span>Our Values</span>
      <h2>What We Stand For</h2>
      <div class="divider"></div>
    </div>
    <div class="row g-4">
      <div class="col-md-4"><div class="feature-box"><div class="icon-circle"><i class="fa-solid fa-seedling"></i></div><h6>Sustainability</h6><p class="small text-muted">Ethically sourced from local growers and farms.</p></div></div>
      <div class="col-md-4"><div class="feature-box"><div class="icon-circle"><i class="fa-solid fa-hand-holding-heart"></i></div><h6>Craftsmanship</h6><p class="small text-muted">Every arrangement is handcrafted with care.</p></div></div>
      <div class="col-md-4"><div class="feature-box"><div class="icon-circle"><i class="fa-solid fa-award"></i></div><h6>Quality</h6><p class="small text-muted">Freshness guaranteed on every single order.</p></div></div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
