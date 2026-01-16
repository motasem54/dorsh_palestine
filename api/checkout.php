<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';
require_once '../includes/cart.php';

if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../checkout.php');
    exit;
}

$cart_items = getCartItems();

if (empty($cart_items)) {
    header('Location: ../cart.php');
    exit;
}

// Get form data
$user_id = $_SESSION['user_id'];
$first_name = sanitize($_POST['first_name']);
$last_name = sanitize($_POST['last_name']);
$email = sanitize($_POST['email']);
$phone = sanitize($_POST['phone']);
$address = sanitize($_POST['address']);
$city = sanitize($_POST['city']);
$postal_code = sanitize($_POST['postal_code'] ?? '');
$payment_method = $_POST['payment_method'];
$notes = sanitize($_POST['notes'] ?? '');

// Calculate totals
$subtotal = getCartTotal();
$shipping = 0; // Free shipping
$total = $subtotal + $shipping;

// Generate order number
$order_number = 'ORD-' . date('Ymd') . '-' . rand(1000, 9999);

try {
    // Start transaction
    $db->query('START TRANSACTION');
    
    // Create order
    $db->query(
        "INSERT INTO orders (user_id, order_number, first_name, last_name, email, phone, address, city, postal_code, 
        subtotal, shipping, total, payment_method, notes, status, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())",
        [$user_id, $order_number, $first_name, $last_name, $email, $phone, $address, $city, $postal_code,
         $subtotal, $shipping, $total, $payment_method, $notes]
    );
    
    $order_id = $db->lastInsertId();
    
    // Add order items
    foreach ($cart_items as $item) {
        $db->query(
            "INSERT INTO order_items (order_id, product_id, product_name, sku, price, quantity, total) 
            VALUES (?, ?, ?, ?, ?, ?, ?)",
            [$order_id, $item['id'], $item['name_en'], $item['sku'], $item['price'], $item['quantity'], 
             $item['price'] * $item['quantity']]
        );
        
        // Update product stock
        $db->query(
            "UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?",
            [$item['quantity'], $item['id']]
        );
    }
    
    // Commit transaction
    $db->query('COMMIT');
    
    // Clear cart
    clearCart();
    
    // Redirect to success page
    $_SESSION['success'] = 'Order placed successfully!';
    header('Location: ../account/orders.php?order=' . $order_id);
    exit;
    
} catch (Exception $e) {
    $db->query('ROLLBACK');
    $_SESSION['error'] = 'Failed to place order. Please try again.';
    header('Location: ../checkout.php');
    exit;
}
