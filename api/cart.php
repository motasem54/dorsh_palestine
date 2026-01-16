<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/cart.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $product_id = (int)($_POST['product_id'] ?? 0);
    $quantity = (int)($_POST['quantity'] ?? 1);
    
    switch ($action) {
        case 'add':
            addToCart($product_id, $quantity);
            echo json_encode([
                'success' => true,
                'message' => 'Product added to cart',
                'cart_count' => getCartCount()
            ]);
            break;
            
        case 'remove':
            removeFromCart($product_id);
            echo json_encode([
                'success' => true,
                'message' => 'Product removed from cart',
                'cart_count' => getCartCount()
            ]);
            break;
            
        case 'update':
            updateCartQuantity($product_id, $quantity);
            echo json_encode([
                'success' => true,
                'cart_total' => getCartTotal(),
                'cart_count' => getCartCount()
            ]);
            break;
            
        case 'clear':
            clearCart();
            echo json_encode(['success' => true]);
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} else {
    // Get cart
    echo json_encode([
        'items' => getCartItems(),
        'total' => getCartTotal(),
        'count' => getCartCount()
    ]);
}
