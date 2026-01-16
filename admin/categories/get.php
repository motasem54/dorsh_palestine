<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdminLogin();

header('Content-Type: application/json');

$id = $_GET['id'] ?? 0;
$category = $db->query("SELECT * FROM categories WHERE id = ?", [$id])->fetch();

echo json_encode($category ?: []);
