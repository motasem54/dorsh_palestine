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
$name_en = sanitize($_POST['name_en']);
$name_ar = sanitize($_POST['name_ar']);
$status = $_POST['status'];

try {
    if ($id) {
        // Update
        $db->query(
            "UPDATE categories SET name_en = ?, name_ar = ?, status = ?, updated_at = NOW() WHERE id = ?",
            [$name_en, $name_ar, $status, $id]
        );
        logAdminActivity($_SESSION['admin_id'], 'category_update', "Updated category: {$name_en}");
    } else {
        // Insert
        $db->query(
            "INSERT INTO categories (name_en, name_ar, status, created_at) VALUES (?, ?, ?, NOW())",
            [$name_en, $name_ar, $status]
        );
        logAdminActivity($_SESSION['admin_id'], 'category_create', "Created category: {$name_en}");
    }
    
    $_SESSION['success'] = 'Category saved successfully!';
} catch (Exception $e) {
    $_SESSION['error'] = 'Failed to save category.';
}

header('Location: index.php');
exit;
