<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/cart.php';
require_once __DIR__ . '/../includes/coupons.php';
require_once __DIR__ . '/../includes/email.php';

session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$cart = getCart();
if (empty($cart)) {
    echo json_encode(['success' => false, 'message' => 'Cart is empty']);
    exit;
}

// Get form data
$first_name = sanitize($_POST['first_name']);
$last_name = sanitize($_POST['last_name']);
$email = sanitize($_POST['email']);
$phone = sanitize($_POST['phone']);
$address = sanitize($_POST['address']);
$city = sanitize($_POST['city']);
$postal_code = sanitize($_POST['postal_code']);
$payment_method = $_POST['payment_method'];
$notes = sanitize($_POST['notes'] ?? '');

// Calculate totals
$subtotal = getCartTotal();
$shipping = 0; // Free shipping for now
$discount = 0;

// Apply coupon if exists
$coupon_code = $_SESSION['coupon_code'] ?? null;
if ($coupon_code) {
    $coupon_result = applyCoupon($coupon_code, $_SESSION['user_id'] ?? null, $subtotal);
    if ($coupon_result['valid']) {
        $discount = $coupon_result['discount'];
    }
}

$total = $subtotal + $shipping - $discount;

// Generate order number
$order_number = 'DP' . date('Ymd') . rand(1000, 9999);

try {
    // Create order
    $db->query(
        "INSERT INTO orders (user_id, order_number, first_name, last_name, email, phone, address, city, postal_code, 
        subtotal, shipping, discount, total, payment_method, coupon_code, notes, status, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())",
        [
            $_SESSION['user_id'] ?? null,
            $order_number,
            $first_name,
            $last_name,
            $email,
            $phone,
            $address,
            $city,
            $postal_code,
            $subtotal,
            $shipping,
            $discount,
            $total,
            $payment_method,
            $coupon_code,
            $notes
        ]
    );
    
    $order_id = $db->lastInsertId();
    
    // Add order items
    foreach ($cart as $product_id => $item) {
        $db->query(
            "INSERT INTO order_items (order_id, product_id, product_name, sku, price, quantity, total) 
            VALUES (?, ?, ?, ?, ?, ?, ?)",
            [
                $order_id,
                $product_id,
                $item['name_en'],
                $item['sku'],
                $item['price'],
                $item['quantity'],
                $item['price'] * $item['quantity']
            ]
        );
        
        // Update stock
        $db->query(
            "UPDATE products SET stock = stock - ? WHERE id = ?",
            [$item['quantity'], $product_id]
        );
    }
    
    // Increment coupon usage
    if ($coupon_code) {
        incrementCouponUsage($coupon_code);
    }
    
    // Get complete order data
    $order = $db->query("SELECT * FROM orders WHERE id = ?", [$order_id])->fetch();
    
    // Send order confirmation email
    $emailService = new EmailService();
    $emailService->sendOrderConfirmation($order);
    
    // Clear cart
    clearCart();
    unset($_SESSION['coupon_code']);
    unset($_SESSION['coupon_discount']);
    
    echo json_encode([
        'success' => true,
        'order_number' => $order_number,
        'order_id' => $order_id
    ]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Order failed: ' . $e->getMessage()]);
}
