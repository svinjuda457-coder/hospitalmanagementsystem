<?php
require_once __DIR__ . '/../includes/auth.php';
header('Content-Type: application/json');

if (!is_logged_in()) {
    echo json_encode(['status' => 'login_required']);
    exit;
}

$uid = $_SESSION['user_id'];
$product_id = (int)($_POST['product_id'] ?? 0);

$check = $pdo->prepare("SELECT id FROM wishlist WHERE user_id=? AND product_id=?");
$check->execute([$uid, $product_id]);
$existing = $check->fetch();

if ($existing) {
    $del = $pdo->prepare("DELETE FROM wishlist WHERE id=?");
    $del->execute([$existing['id']]);
    $in_wishlist = false;
    $message = 'Removed from wishlist.';
} else {
    $ins = $pdo->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?,?)");
    $ins->execute([$uid, $product_id]);
    $in_wishlist = true;
    $message = 'Added to wishlist!';
}

echo json_encode([
    'status' => 'success',
    'message' => $message,
    'in_wishlist' => $in_wishlist,
    'wishlist_count' => get_wishlist_count($pdo, $uid),
]);
