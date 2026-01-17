<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdminLogin();

header('Content-Type: application/json');

$id = $_GET['id'] ?? 0;
$coupon = $db->query("SELECT * FROM coupons WHERE id = ?", [$id])->fetch();

echo json_encode($coupon ?: []);
