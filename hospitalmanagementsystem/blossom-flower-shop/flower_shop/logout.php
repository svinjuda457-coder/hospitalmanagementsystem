<?php
require_once __DIR__ . '/includes/auth.php';
unset($_SESSION['user_id'], $_SESSION['user_name']);
session_regenerate_id(true);
redirect('index.php');
