<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$page_title = 'My Cart';
$uid = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT c.id AS cart_id, c.quantity, p.id AS product_id, p.name, p.image, p.price, p.discount_price, p.stock
    FROM cart c JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ? ORDER BY c.id DESC
");
$stmt->execute([$uid]);
$items = $stmt->fetchAll();

$subtotal = 0;
foreach ($items as $it) {
    $price = $it['discount_price'] ?? $it['price'];
    $subtotal += $price * $it['quantity'];
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>
<div class="page-banner">
  <div class="container">
    <h1>My Cart</h1>
    <p class="text-muted"><?php echo count($items); ?> item(s) in your cart</p>
  </div>
</div>

<section class="py-5">
  <div class="container">
    <?php if (!$items): ?>
      <div class="text-center py-5">
        <i class="fa-solid fa-cart-shopping fa-3x text-pink mb-3"></i>
        <h5>Your cart is empty</h5>
        <p class="text-muted">Looks like you haven't added any flowers yet.</p>
        <a href="<?php echo BASE_URL; ?>products.php" class="btn btn-bloom mt-2">Browse Flowers</a>
      </div>
    <?php else: ?>
    <div class="row g-4">
      <div class="col-lg-8">
        <div class="dash-card">
          <div class="table-responsive">
            <table class="table table-bfs align-middle">
              <thead><tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th><th></th></tr></thead>
              <tbody>
              <?php foreach ($items as $it):
                  $price = $it['discount_price'] ?? $it['price'];
                  $line_total = $price * $it['quantity'];
              ?>
                <tr id="cart-row-<?php echo $it['cart_id']; ?>">
                  <td>
                    <div class="d-flex align-items-center gap-3">
                      <img src="<?php echo product_image_url($it['image']); ?>" style="width:60px;height:60px;object-fit:cover;border-radius:10px;">
                      <a href="<?php echo BASE_URL; ?>product-details.php?id=<?php echo $it['product_id']; ?>" class="text-dark fw-semibold"><?php echo e($it['name']); ?></a>
                    </div>
                  </td>
                  <td><?php echo format_price($price); ?></td>
                  <td style="width:130px;">
                    <input type="number" class="form-control form-control-sm js-cart-qty" data-cart-id="<?php echo $it['cart_id']; ?>" value="<?php echo $it['quantity']; ?>" min="1" max="<?php echo $it['stock']; ?>">
                  </td>
                  <td id="line-total-<?php echo $it['cart_id']; ?>"><?php echo format_price($line_total); ?></td>
                  <td><button class="btn btn-sm btn-outline-danger js-remove-cart-item" data-cart-id="<?php echo $it['cart_id']; ?>"><i class="fa-solid fa-trash"></i></button></td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="dash-card">
          <h5 class="mb-3">Order Summary</h5>
          <div class="d-flex justify-content-between mb-2"><span>Subtotal</span><strong id="cart-subtotal"><?php echo format_price($subtotal); ?></strong></div>
          <div class="d-flex justify-content-between mb-2 text-muted small"><span>Delivery Fee</span><span>Calculated at checkout</span></div>
          <hr>
          <a href="<?php echo BASE_URL; ?>user/checkout.php" class="btn btn-bloom w-100">Proceed to Checkout <i class="fa-solid fa-arrow-right ms-1"></i></a>
          <a href="<?php echo BASE_URL; ?>products.php" class="btn btn-bloom-outline w-100 mt-2">Continue Shopping</a>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
