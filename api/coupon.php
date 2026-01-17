<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/cart.php';
require_once __DIR__ . '/../includes/coupons.php';

session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$action = $_POST['action'] ?? '';

if ($action === 'apply') {
    $code = strtoupper(trim($_POST['code'] ?? ''));
    $user_id = $_SESSION['user_id'] ?? null;
    
    if (empty($code)) {
        echo json_encode(['success' => false, 'message' => 'Please enter a coupon code']);
        exit;
    }
    
    $cart = getCart();
    $cart_total = getCartTotal();
    
    if (empty($cart)) {
        echo json_encode(['success' => false, 'message' => 'Your cart is empty']);
        exit;
    }
    
    $result = applyCoupon($code, $user_id, $cart_total);
    
    if ($result['valid']) {
        $_SESSION['coupon_code'] = $code;
        $_SESSION['coupon_discount'] = $result['discount'];
        
        echo json_encode([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'discount' => $result['discount'],
            'new_total' => $result['new_total']
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => $result['message']]);
    }
    
} elseif ($action === 'remove') {
    unset($_SESSION['coupon_code']);
    unset($_SESSION['coupon_discount']);
    
    echo json_encode(['success' => true, 'message' => 'Coupon removed']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}
