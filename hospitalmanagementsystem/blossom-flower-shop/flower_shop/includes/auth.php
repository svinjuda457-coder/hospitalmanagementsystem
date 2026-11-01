<?php
/**
 * Bootstrap file: starts the session, loads DB connection and helper functions.
 * Every page in the project includes this file first.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/functions.php';
