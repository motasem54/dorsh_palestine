<?php
/**
 * Shopping Cart Functions
 */

function getCart() {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    return $_SESSION['cart'];
}

function addToCart($product_id, $quantity = 1) {
    $cart = getCart();
    
    if (isset($cart[$product_id])) {
        $cart[$product_id]['quantity'] += $quantity;
    } else {
        $cart[$product_id] = [
            'product_id' => $product_id,
            'quantity' => $quantity
        ];
    }
    
    $_SESSION['cart'] = $cart;
    return true;
}

function removeFromCart($product_id) {
    $cart = getCart();
    unset($cart[$product_id]);
    $_SESSION['cart'] = $cart;
    return true;
}

function updateCartQuantity($product_id, $quantity) {
    $cart = getCart();
    
    if ($quantity <= 0) {
        return removeFromCart($product_id);
    }
    
    if (isset($cart[$product_id])) {
        $cart[$product_id]['quantity'] = $quantity;
        $_SESSION['cart'] = $cart;
        return true;
    }
    
    return false;
}

function getCartItems() {
    global $db;
    $cart = getCart();
    
    if (empty($cart)) {
        return [];
    }
    
    $product_ids = array_keys($cart);
    $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
    
    $products = $db->query(
        "SELECT * FROM products WHERE id IN ({$placeholders}) AND status = 'active'",
        $product_ids
    )->fetchAll();
    
    $items = [];
    foreach ($products as $product) {
        $product['quantity'] = $cart[$product['id']]['quantity'];
        $items[] = $product;
    }
    
    return $items;
}

function getCartTotal() {
    $items = getCartItems();
    $total = 0;
    
    foreach ($items as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    
    return $total;
}

function getCartCount() {
    $cart = getCart();
    $count = 0;
    
    foreach ($cart as $item) {
        $count += $item['quantity'];
    }
    
    return $count;
}

function clearCart() {
    $_SESSION['cart'] = [];
    return true;
}
