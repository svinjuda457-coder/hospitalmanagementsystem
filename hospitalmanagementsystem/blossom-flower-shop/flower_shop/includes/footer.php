  <footer class="bfs-footer mt-5">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-4">
          <h5><i class="fa-solid fa-spa text-pink"></i> Blossom Flower Shop</h5>
          <p>Handpicked fresh flowers, delivered with love. Making every emotion bloom since day one.</p>
          <div class="social-icons mt-3">
            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-twitter"></i></a>
            <a href="#"><i class="fa-brands fa-pinterest-p"></i></a>
          </div>
        </div>
        <div class="col-lg-2 col-6">
          <h5>Shop</h5>
          <ul class="list-unstyled">
            <li><a href="<?php echo BASE_URL; ?>products.php">All Flowers</a></li>
            <li><a href="<?php echo BASE_URL; ?>categories.php">Categories</a></li>
            <li><a href="<?php echo BASE_URL; ?>products.php?featured=1">Best Sellers</a></li>
          </ul>
        </div>
        <div class="col-lg-2 col-6">
          <h5>Company</h5>
          <ul class="list-unstyled">
            <li><a href="<?php echo BASE_URL; ?>about.php">About Us</a></li>
            <li><a href="<?php echo BASE_URL; ?>contact.php">Contact Us</a></li>
            <li><a href="<?php echo BASE_URL; ?>user/orders.php">Track Order</a></li>
          </ul>
        </div>
        <div class="col-lg-4">
          <h5>Contact Info</h5>
          <ul class="list-unstyled">
            <li><i class="fa-solid fa-location-dot me-2"></i> 12 Garden Street, Rajkot, Gujarat</li>
            <li><i class="fa-solid fa-phone me-2"></i> +91 98765 43210</li>
            <li><i class="fa-solid fa-envelope me-2"></i> hello@blossomflowers.com</li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom text-center">
        &copy; <?php echo date('Y'); ?> Blossom Flower Shop. All rights reserved.
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/js/script.js"></script>
</body>
</html>
