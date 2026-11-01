<?php
require_once __DIR__ . '/../includes/auth.php';
header('Content-Type: application/json');

if (!is_logged_in()) {
    echo json_encode(['status' => 'login_required']);
    exit;
}

$uid = $_SESSION['user_id'];
$action = $_POST['action'] ?? '';

function cart_subtotal($pdo, $uid) {
    $stmt = $pdo->prepare("SELECT SUM(c.quantity * COALESCE(p.discount_price, p.price)) AS subtotal
                            FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
    $stmt->execute([$uid]);
    return (float)($stmt->fetch()['subtotal'] ?? 0);
}

if ($action === 'add') {
    $product_id = (int)$_POST['product_id'];
    $quantity = max(1, (int)($_POST['quantity'] ?? 1));

    $p = $pdo->prepare("SELECT stock FROM products WHERE id=? AND status='active'");
    $p->execute([$product_id]);
    $product = $p->fetch();
    if (!$product) {
        echo json_encode(['status' => 'error', 'message' => 'Product not found.']);
        exit;
    }
    if ($product['stock'] < 1) {
        echo json_encode(['status' => 'error', 'message' => 'This product is out of stock.']);
        exit;
    }

    $check = $pdo->prepare("SELECT id, quantity FROM cart WHERE user_id=? AND product_id=?");
    $check->execute([$uid, $product_id]);
    $existing = $check->fetch();

    if ($existing) {
        $new_qty = min($existing['quantity'] + $quantity, $product['stock']);
        $upd = $pdo->prepare("UPDATE cart SET quantity=? WHERE id=?");
        $upd->execute([$new_qty, $existing['id']]);
    } else {
        $ins = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?,?,?)");
        $ins->execute([$uid, $product_id, min($quantity, $product['stock'])]);
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Added to cart!',
        'cart_count' => get_cart_count($pdo, $uid),
    ]);
    exit;
}

if ($action === 'update') {
    $cart_id = (int)$_POST['cart_id'];
    $quantity = max(1, (int)$_POST['quantity']);

    $own = $pdo->prepare("SELECT c.*, p.stock FROM cart c JOIN products p ON c.product_id=p.id WHERE c.id=? AND c.user_id=?");
    $own->execute([$cart_id, $uid]);
    $row = $own->fetch();
    if (!$row) { echo json_encode(['status' => 'error', 'message' => 'Item not found.']); exit; }

    $quantity = min($quantity, $row['stock']);
    $upd = $pdo->prepare("UPDATE cart SET quantity=? WHERE id=?");
    $upd->execute([$quantity, $cart_id]);

    $line = $pdo->prepare("SELECT c.quantity, COALESCE(p.discount_price,p.price) AS price FROM cart c JOIN products p ON c.product_id=p.id WHERE c.id=?");
    $line->execute([$cart_id]);
    $lrow = $line->fetch();
    $line_total = $lrow['quantity'] * $lrow['price'];

    echo json_encode([
        'status' => 'success',
        'line_total' => format_price($line_total),
        'subtotal' => format_price(cart_subtotal($pdo, $uid)),
        'cart_count' => get_cart_count($pdo, $uid),
    ]);
    exit;
}

if ($action === 'remove') {
    $cart_id = (int)$_POST['cart_id'];
    $del = $pdo->prepare("DELETE FROM cart WHERE id=? AND user_id=?");
    $del->execute([$cart_id, $uid]);
    echo json_encode(['status' => 'success', 'cart_count' => get_cart_count($pdo, $uid)]);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Unknown action.']);
