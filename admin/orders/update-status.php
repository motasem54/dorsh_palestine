<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/email.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdminLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$order_id = (int)$_POST['order_id'];
$new_status = $_POST['status'];

try {
    // Get current order
    $order = $db->query("SELECT * FROM orders WHERE id = ?", [$order_id])->fetch();
    $old_status = $order['status'];
    
    // Update status
    $db->query(
        "UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?",
        [$new_status, $order_id]
    );
    
    // Log activity
    logAdminActivity($_SESSION['admin_id'], 'order_status_update', "Updated order #{$order['order_number']} from {$old_status} to {$new_status}");
    
    // Send email notification if status changed
    if ($old_status !== $new_status) {
        $updated_order = $db->query("SELECT * FROM orders WHERE id = ?", [$order_id])->fetch();
        $emailService = new EmailService();
        $emailService->sendOrderStatusUpdate($updated_order, $old_status, $new_status);
    }
    
    $_SESSION['success'] = 'Order status updated and customer notified via email!';
} catch (Exception $e) {
    $_SESSION['error'] = 'Failed to update order status.';
}

header('Location: view.php?id=' . $order_id);
exit;
