<?php
/**
 * Shared helper functions used across guest, user, admin and delivery panels.
 */

function e($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

function redirect($path) {
    header("Location: " . BASE_URL . ltrim($path, '/'));
    exit;
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['admin_id']);
}

function is_delivery() {
    return isset($_SESSION['delivery_id']);
}

function require_login() {
    if (!is_logged_in()) {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        redirect('login.php');
    }
}

function require_admin() {
    if (!is_admin()) {
        redirect('admin/login.php');
    }
}

function require_delivery() {
    if (!is_delivery()) {
        redirect('delivery/login.php');
    }
}

function flash($key, $message = null) {
    if ($message !== null) {
        $_SESSION['flash'][$key] = $message;
        return;
    }
    if (!empty($_SESSION['flash'][$key])) {
        $msg = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $msg;
    }
    return null;
}

function format_price($price) {
    return '₹' . number_format((float)$price, 2);
}

function product_image_url($image) {
    if (!empty($image) && file_exists(UPLOAD_PATH . $image)) {
        return UPLOAD_URL . $image;
    }
    // Fallback placeholder image (Unsplash floral placeholder)
    return 'https://images.unsplash.com/photo-1490750967868-88aa4486c946?w=600&q=80';
}

function generate_order_number() {
    return 'BFS' . date('Ymd') . rand(1000, 9999);
}

function get_cart_count($pdo, $user_id) {
    $stmt = $pdo->prepare("SELECT COALESCE(SUM(quantity),0) AS cnt FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);
    return (int)$stmt->fetch()['cnt'];
}

function get_wishlist_count($pdo, $user_id) {
    $stmt = $pdo->prepare("SELECT COUNT(*) AS cnt FROM wishlist WHERE user_id = ?");
    $stmt->execute([$user_id]);
    return (int)$stmt->fetch()['cnt'];
}

function order_status_badge($status) {
    $map = [
        'pending'          => 'secondary',
        'processing'       => 'info',
        'shipped'          => 'primary',
        'out_for_delivery' => 'warning',
        'delivered'        => 'success',
        'cancelled'        => 'danger',
    ];
    $color = $map[$status] ?? 'secondary';
    $label = ucwords(str_replace('_', ' ', $status));
    return "<span class=\"badge bg-$color status-badge\">$label</span>";
}

function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

function verify_csrf() {
    if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('Invalid request (CSRF check failed). Please go back and try again.');
    }
}

function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = trim($text, '-');
    $text = strtolower($text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    return $text ?: 'n-a';
}
