<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdminLogin();

$id = $_GET['id'] ?? 0;

try {
    $coupon = $db->query("SELECT code FROM coupons WHERE id = ?", [$id])->fetch();
    $db->query("DELETE FROM coupons WHERE id = ?", [$id]);
    logAdminActivity($_SESSION['admin_id'], 'coupon_delete', "Deleted coupon: {$coupon['code']}");
    $_SESSION['success'] = 'Coupon deleted successfully!';
} catch (Exception $e) {
    $_SESSION['error'] = 'Failed to delete coupon.';
}

header('Location: index.php');
exit;
