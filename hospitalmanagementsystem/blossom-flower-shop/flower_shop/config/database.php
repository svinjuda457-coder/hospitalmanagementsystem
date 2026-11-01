<?php
/**
 * Database connection (PDO)
 * Update these credentials if your XAMPP MySQL setup is different.
 */
define('DB_HOST', 'localhost');
define('DB_NAME', 'flower_shop');
define('DB_USER', 'root');
define('DB_PASS', '');

// Base URL of the project - change if your folder name is different
define('BASE_URL', 'http://localhost/blossom-flower-shop/flower_shop/');
define('UPLOAD_PATH', __DIR__ . '/../assets/uploads/');
define('UPLOAD_URL', BASE_URL . 'assets/uploads/');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
