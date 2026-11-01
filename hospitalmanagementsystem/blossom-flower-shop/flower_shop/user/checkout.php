<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$page_title = 'Checkout';
$uid = $_SESSION['user_id'];

// Determine checkout items: either "Buy Now" single product or full cart
$buy_now_id = isset($_GET['buy_now']) ? (int)$_GET['buy_now'] : (isset($_POST['buy_now']) ? (int)$_POST['buy_now'] : 0);

if ($buy_now_id) {
    $stmt = $pdo->prepare("SELECT id AS product_id, name, image, price, discount_price, stock, 1 AS quantity FROM products WHERE id=? AND status='active'");
    $stmt->execute([$buy_now_id]);
    $row = $stmt->fetch();
    $items = $row ? [$row] : [];
} else {
    $stmt = $pdo->prepare("
        SELECT c.id AS cart_id, c.quantity, p.id AS product_id, p.name, p.image, p.price, p.discount_price, p.stock
        FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?
    ");
    $stmt->execute([$uid]);
    $items = $stmt->fetchAll();
}

if (!$items) {
    redirect('user/cart.php');
}

$subtotal = 0;
foreach ($items as $it) {
    $price = $it['discount_price'] ?? $it['price'];
    $subtotal += $price * $it['quantity'];
}
$delivery_fee = $subtotal >= 999 ? 0 : 60;

// Fetch user for pre-filled address
$u = $pdo->prepare("SELECT * FROM users WHERE id=?");
$u->execute([$uid]);
$user = $u->fetch();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    verify_csrf();
    $full_name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $pincode = trim($_POST['pincode'] ?? '');
    $payment_method = $_POST['payment_method'] ?? 'COD';
    $promo_code = trim($_POST['promo_code'] ?? '');

    if ($full_name === '') $errors[] = 'Full name is required.';
    if ($phone === '') $errors[] = 'Phone number is required.';
    if ($address === '') $errors[] = 'Delivery address is required.';
    if ($city === '') $errors[] = 'City is required.';
    if (!in_array($payment_method, ['COD','UPI','CARD'])) $errors[] = 'Invalid payment method.';

    $discount = 0;
    if ($promo_code !== '') {
        $offer_stmt = $pdo->prepare("SELECT * FROM offers WHERE code=? AND status='active' AND (valid_to IS NULL OR valid_to >= CURDATE())");
        $offer_stmt->execute([$promo_code]);
        $offer = $offer_stmt->fetch();
        if ($offer) {
            $discount = round($subtotal * ($offer['discount_percent'] / 100), 2);
        } else {
            $errors[] = 'Invalid or expired promo code.';
        }
    }

    if (!$errors) {
        $total = $subtotal - $discount + $delivery_fee;
        $order_number = generate_order_number();

        $pdo->beginTransaction();
        try {
            $ins = $pdo->prepare("INSERT INTO orders (order_number, user_id, full_name, phone, address, city, pincode, payment_method, subtotal, discount, delivery_fee, total)
                                   VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
            $ins->execute([$order_number, $uid, $full_name, $phone, $address, $city, $pincode, $payment_method, $subtotal, $discount, $delivery_fee, $total]);
            $order_id = $pdo->lastInsertId();

            foreach ($items as $it) {
                $price = $it['discount_price'] ?? $it['price'];
                $line_total = $price * $it['quantity'];
                $oi = $pdo->prepare("INSERT INTO order_items (order_id, product_id, product_name, price, quantity, total) VALUES (?,?,?,?,?,?)");
                $oi->execute([$order_id, $it['product_id'], $it['name'], $price, $it['quantity'], $line_total]);

                $upd_stock = $pdo->prepare("UPDATE products SET stock = GREATEST(stock - ?, 0) WHERE id = ?");
                $upd_stock->execute([$it['quantity'], $it['product_id']]);
            }

            // Simulated payment record
            $pay_status = $payment_method === 'COD' ? 'pending' : 'success';
            $txn_id = $payment_method === 'COD' ? null : 'TXN' . strtoupper(bin2hex(random_bytes(5)));
            $pay = $pdo->prepare("INSERT INTO payments (order_id, user_id, method, amount, transaction_id, status) VALUES (?,?,?,?,?,?)");
            $pay->execute([$order_id, $uid, $payment_method, $total, $txn_id, $pay_status]);
            if ($pay_status === 'success') {
                $pdo->prepare("UPDATE orders SET payment_status='paid' WHERE id=?")->execute([$order_id]);
            }

            // Clear cart items if this was a cart checkout (not buy-now)
            if (!$buy_now_id) {
                $pdo->prepare("DELETE FROM cart WHERE user_id=?")->execute([$uid]);
            }

            $notif = $pdo->prepare("INSERT INTO notifications (user_id, title, message) VALUES (?,?,?)");
            $notif->execute([$uid, 'Order Placed', "Your order $order_number has been placed successfully."]);

            $pdo->commit();
            redirect('user/order-confirmation.php?id=' . $order_id);
        } catch (Exception $e) {
            $pdo->rollBack();
            $errors[] = 'Something went wrong while placing your order. Please try again.';
        }
    }
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>
<div class="page-banner">
  <div class="container">
    <h1>Checkout</h1>
    <p class="text-muted">Complete your order in a few simple steps</p>
  </div>
</div>

<section class="py-5">
  <div class="container">
    <?php if ($errors): ?><div class="alert alert-danger"><?php foreach($errors as $err) echo e($err) . '<br>'; ?></div><?php endif; ?>
    <form method="POST">
      <?php echo csrf_field(); ?>
      <?php if ($buy_now_id): ?><input type="hidden" name="buy_now" value="<?php echo $buy_now_id; ?>"><?php endif; ?>
      <div class="row g-4">
        <div class="col-lg-7">
          <div class="dash-card mb-4">
            <h5 class="mb-3"><i class="fa-solid fa-location-dot text-pink me-2"></i>Delivery Address</h5>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" required value="<?php echo e($user['full_name']); ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone" class="form-control" required value="<?php echo e($user['phone']); ?>">
              </div>
              <div class="col-12">
                <label class="form-label">Delivery Address</label>
                <textarea name="address" class="form-control" rows="3" required><?php echo e($user['address']); ?></textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label">City</label>
                <input type="text" name="city" class="form-control" required value="<?php echo e($user['city']); ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Pincode</label>
                <input type="text" name="pincode" class="form-control">
              </div>
            </div>
          </div>

          <div class="dash-card">
            <h5 class="mb-3"><i class="fa-solid fa-credit-card text-pink me-2"></i>Payment Method</h5>
            <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="payment_method" value="COD" id="pmCOD" checked>
              <label class="form-check-label" for="pmCOD"><i class="fa-solid fa-money-bill-wave me-1"></i> Cash on Delivery</label>
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="payment_method" value="UPI" id="pmUPI">
              <label class="form-check-label" for="pmUPI"><i class="fa-solid fa-mobile-screen me-1"></i> UPI</label>
            </div>
            <div class="payment-fields d-none ps-4 mb-2" id="fields-UPI">
              <input type="text" class="form-control form-control-sm" placeholder="yourname@upi" style="max-width:260px;">
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="payment_method" value="CARD" id="pmCARD">
              <label class="form-check-label" for="pmCARD"><i class="fa-solid fa-credit-card me-1"></i> Credit / Debit Card</label>
            </div>
            <div class="payment-fields d-none ps-4" id="fields-CARD">
              <div class="row g-2" style="max-width:400px;">
                <div class="col-12"><input type="text" class="form-control form-control-sm" placeholder="Card Number"></div>
                <div class="col-6"><input type="text" class="form-control form-control-sm" placeholder="MM/YY"></div>
                <div class="col-6"><input type="text" class="form-control form-control-sm" placeholder="CVV"></div>
              </div>
            </div>
            <p class="small text-muted mt-2 mb-0"><i class="fa-solid fa-circle-info me-1"></i> This is a demo payment gateway — no real charges will be made.</p>
          </div>
        </div>

        <div class="col-lg-5">
          <div class="dash-card">
            <h5 class="mb-3">Order Summary</h5>
            <?php foreach ($items as $it): $price = $it['discount_price'] ?? $it['price']; ?>
              <div class="d-flex justify-content-between mb-2">
                <span class="small"><?php echo e($it['name']); ?> &times; <?php echo $it['quantity']; ?></span>
                <span class="small"><?php echo format_price($price * $it['quantity']); ?></span>
              </div>
            <?php endforeach; ?>
            <hr>
            <div class="mb-2">
              <label class="form-label small">Promo Code</label>
              <input type="text" name="promo_code" class="form-control form-control-sm" placeholder="e.g. BLOOM10" value="<?php echo e($_POST['promo_code'] ?? ''); ?>">
            </div>
            <div class="d-flex justify-content-between mb-1"><span>Subtotal</span><span><?php echo format_price($subtotal); ?></span></div>
            <div class="d-flex justify-content-between mb-1"><span>Delivery Fee</span><span><?php echo $delivery_fee > 0 ? format_price($delivery_fee) : 'FREE'; ?></span></div>
            <hr>
            <div class="d-flex justify-content-between mb-3"><strong>Total</strong><strong class="text-pink fs-5"><?php echo format_price($subtotal + $delivery_fee); ?></strong></div>
            <button type="submit" name="place_order" class="btn btn-bloom w-100">Place Order <i class="fa-solid fa-check ms-1"></i></button>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
