<?php
/**
 * Admin Logout
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/includes/auth.php';

// Log activity
if (isset($_SESSION['admin_id'])) {
    logAdminActivity($_SESSION['admin_id'], 'logout', 'Admin logged out');
}

// Clear session
session_destroy();

// Clear remember me cookie
if (isset($_COOKIE['admin_token'])) {
    setcookie('admin_token', '', time() - 3600, '/');
}

// Redirect to login
header('Location: login.php');
exit;
