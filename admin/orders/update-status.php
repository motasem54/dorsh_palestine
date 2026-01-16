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

$order_id = (int)$_POST['order_id'];
$status = $_POST['status'];

try {
    $order = $db->query("SELECT order_number FROM orders WHERE id = ?", [$order_id])->fetch();
    
    $db->query(
        "UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?",
        [$status, $order_id]
    );
    
    logAdminActivity($_SESSION['admin_id'], 'order_status_update', "Updated order #{$order['order_number']} to {$status}");
    
    $_SESSION['success'] = 'Order status updated successfully!';
} catch (Exception $e) {
    $_SESSION['error'] = 'Failed to update order status.';
}

header('Location: view.php?id=' . $order_id);
exit;
