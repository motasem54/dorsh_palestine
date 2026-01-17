<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdminLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = $_POST['id'] ?? null;
$code = strtoupper(sanitize($_POST['code']));
$type = $_POST['type'];
$value = floatval($_POST['value']);
$min_order_amount = $_POST['min_order_amount'] ? floatval($_POST['min_order_amount']) : null;
$max_discount = $_POST['max_discount'] ? floatval($_POST['max_discount']) : null;
$usage_limit = $_POST['usage_limit'] ? intval($_POST['usage_limit']) : null;
$expires_at = $_POST['expires_at'] ?: null;
$status = $_POST['status'];

try {
    if ($id) {
        // Update
        $db->query(
            "UPDATE coupons SET code = ?, type = ?, value = ?, min_order_amount = ?, max_discount = ?, usage_limit = ?, expires_at = ?, status = ? WHERE id = ?",
            [$code, $type, $value, $min_order_amount, $max_discount, $usage_limit, $expires_at, $status, $id]
        );
        logAdminActivity($_SESSION['admin_id'], 'coupon_update', "Updated coupon: {$code}");
    } else {
        // Insert
        $db->query(
            "INSERT INTO coupons (code, type, value, min_order_amount, max_discount, usage_limit, expires_at, status, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())",
            [$code, $type, $value, $min_order_amount, $max_discount, $usage_limit, $expires_at, $status]
        );
        logAdminActivity($_SESSION['admin_id'], 'coupon_create', "Created coupon: {$code}");
    }
    
    $_SESSION['success'] = 'Coupon saved successfully!';
} catch (Exception $e) {
    $_SESSION['error'] = 'Failed to save coupon.';
}

header('Location: index.php');
exit;
