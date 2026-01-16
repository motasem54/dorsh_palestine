<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdminLogin();

$id = $_GET['id'] ?? 0;

try {
    $product = $db->query("SELECT name_en FROM products WHERE id = ?", [$id])->fetch();
    $db->query("DELETE FROM products WHERE id = ?", [$id]);
    logAdminActivity($_SESSION['admin_id'], 'product_delete', "Deleted product: {$product['name_en']}");
    $_SESSION['success'] = 'Product deleted successfully!';
} catch (Exception $e) {
    $_SESSION['error'] = 'Failed to delete product.';
}

header('Location: index.php');
exit;
