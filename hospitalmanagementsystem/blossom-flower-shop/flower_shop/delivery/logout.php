<?php
require_once __DIR__ . '/../includes/auth.php';
unset($_SESSION['delivery_id'], $_SESSION['delivery_name']);
redirect('delivery/login.php');
