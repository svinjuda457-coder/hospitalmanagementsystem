<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$page_title = 'My Orders';
$uid = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_order_id'])) {
    verify_csrf();
    $oid = (int)$_POST['cancel_order_id'];
    $check = $pdo->prepare("SELECT * FROM orders WHERE id=? AND user_id=?");
    $check->execute([$oid, $uid]);
    $order = $check->fetch();
    if ($order && !in_array($order['order_status'], ['delivered', 'cancelled', 'shipped', 'out_for_delivery'])) {
        $pdo->prepare("UPDATE orders SET order_status='cancelled' WHERE id=?")->execute([$oid]);
        flash('success', 'Your order has been cancelled.');
    } else {
        flash('error', 'This order can no longer be cancelled.');
    }
    redirect('user/orders.php');
}

$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY created_at DESC");
$stmt->execute([$uid]);
$orders = $stmt->fetchAll();

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>
<div class="page-banner"><div class="container"><h1>My Orders</h1><p class="text-muted">View and track all your orders</p></div></div>

<section class="py-5">
  <div class="container">
    <?php if ($msg = flash('success')): ?><div class="alert alert-success"><?php echo e($msg); ?></div><?php endif; ?>
    <?php if ($msg = flash('error')): ?><div class="alert alert-danger"><?php echo e($msg); ?></div><?php endif; ?>

    <?php if (!$orders): ?>
      <div class="text-center py-5">
        <i class="fa-solid fa-box-open fa-3x text-pink mb-3"></i>
        <h5>No orders yet</h5>
        <a href="<?php echo BASE_URL; ?>products.php" class="btn btn-bloom mt-2">Start Shopping</a>
      </div>
    <?php else: ?>
      <div class="dash-card">
        <div class="table-responsive">
          <table class="table table-bfs align-middle">
            <thead><tr><th>Order #</th><th>Date</th><th>Items</th><th>Total</th><th>Payment</th><th>Status</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($orders as $o):
                $cnt = $pdo->prepare("SELECT COUNT(*) c FROM order_items WHERE order_id=?");
                $cnt->execute([$o['id']]); $cnt = $cnt->fetch()['c'];
            ?>
              <tr>
                <td><?php echo e($o['order_number']); ?></td>
                <td><?php echo date('d M Y', strtotime($o['created_at'])); ?></td>
                <td><?php echo $cnt; ?> item(s)</td>
                <td><?php echo format_price($o['total']); ?></td>
                <td><?php echo e($o['payment_method']); ?></td>
                <td><?php echo order_status_badge($o['order_status']); ?></td>
                <td class="d-flex gap-2">
                  <a href="<?php echo BASE_URL; ?>user/order-track.php?id=<?php echo $o['id']; ?>" class="btn btn-sm btn-bloom-outline">Track</a>
                  <?php if (!in_array($o['order_status'], ['delivered','cancelled','shipped','out_for_delivery'])): ?>
                  <form method="POST" onsubmit="return confirm('Cancel this order?');">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="cancel_order_id" value="<?php echo $o['id']; ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger">Cancel</button>
                  </form>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
