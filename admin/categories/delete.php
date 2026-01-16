<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdminLogin();

$id = $_GET['id'] ?? 0;

try {
    $category = $db->query("SELECT name_en FROM categories WHERE id = ?", [$id])->fetch();
    $db->query("DELETE FROM categories WHERE id = ?", [$id]);
    logAdminActivity($_SESSION['admin_id'], 'category_delete', "Deleted category: {$category['name_en']}");
    $_SESSION['success'] = 'Category deleted successfully!';
} catch (Exception $e) {
    $_SESSION['error'] = 'Cannot delete category. It may have associated products.';
}

header('Location: index.php');
exit;
