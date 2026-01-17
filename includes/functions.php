<?php
/**
 * Dorsch Palestine - Helper Functions
 * All utility functions for the website
 */

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Translation function
 * @param string $key Translation key
 * @param string $default Default text if translation not found
 * @return string Translated text
 */
function t($key, $default = '') {
    $lang = $_SESSION['lang'] ?? 'en';
    
    // Translation arrays
    $translations = [
        'en' => [
            'home' => 'HOME',
            'products' => 'PRODUCTS',
            'collections' => 'COLLECTIONS',
            'about' => 'ABOUT',
            'contact' => 'CONTACT',
            'search_products' => 'Search for products...',
            'wishlist' => 'My Wishlist',
            'compare' => 'Compare',
            'cart' => 'Shopping Cart',
            'chat_whatsapp' => 'Chat on WhatsApp',
            'ai_assistant' => 'AI Assistant',
            'dorsch_assistant' => 'Dorsch Assistant',
            'ask_about_products' => 'Ask me about our products!',
            'chatbot_welcome' => 'Hello! 👋 I\'m Dorsch Assistant. How can I help you today?',
            'premium_cookware' => 'Premium Cookware',
            'lfgb_certified' => 'LFGB Certified',
            'pressure_cookers' => 'Pressure Cookers',
            'warranty_info' => 'Warranty Info',
            'type_message' => 'Type your message...'
        ],
        'ar' => [
            'home' => 'الرئيسية',
            'products' => 'المنتجات',
            'collections' => 'المجموعات',
            'about' => 'من نحن',
            'contact' => 'اتصل بنا',
            'search_products' => 'ابحث عن المنتجات...',
            'wishlist' => 'قائمة الأمنيات',
            'compare' => 'مقارنة',
            'cart' => 'سلة التسوق',
            'chat_whatsapp' => 'تحدث على واتساب',
            'ai_assistant' => 'المساعد الذكي',
            'dorsch_assistant' => 'مساعد دورش',
            'ask_about_products' => 'اسألني عن منتجاتنا!',
            'chatbot_welcome' => 'مرحباً! 👋 أنا مساعد دورش. كيف يمكنني مساعدتك اليوم؟',
            'premium_cookware' => 'أدوات طبخ فاخرة',
            'lfgb_certified' => 'معتمد LFGB',
            'pressure_cookers' => 'قدور ضغط',
            'warranty_info' => 'معلومات الضمان',
            'type_message' => 'اكتب رسالتك...'
        ]
    ];
    
    // Return translation or default
    if (isset($translations[$lang][$key])) {
        return $translations[$lang][$key];
    }
    
    return $default ?: $key;
}

/**
 * Check if current language is RTL
 * @return bool
 */
function isRTL() {
    $lang = $_SESSION['lang'] ?? 'en';
    $rtlLanguages = ['ar', 'he', 'ur', 'fa'];
    return in_array($lang, $rtlLanguages);
}

/**
 * Get wishlist count from session
 * @return int
 */
function getWishlistCount() {
    if (!isset($_SESSION['wishlist'])) {
        $_SESSION['wishlist'] = [];
    }
    return count($_SESSION['wishlist']);
}

/**
 * Get compare count from session
 * @return int
 */
function getCompareCount() {
    if (!isset($_SESSION['compare'])) {
        $_SESSION['compare'] = [];
    }
    return count($_SESSION['compare']);
}

/**
 * Get cart count from session
 * @return int
 */
function getCartCount() {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    $count = 0;
    foreach ($_SESSION['cart'] as $item) {
        $count += isset($item['quantity']) ? $item['quantity'] : 1;
    }
    return $count;
}

/**
 * Get cart total price
 * @return float
 */
function getCartTotal() {
    if (!isset($_SESSION['cart'])) {
        return 0;
    }
    
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $quantity = isset($item['quantity']) ? $item['quantity'] : 1;
        $price = isset($item['price']) ? $item['price'] : 0;
        $total += $quantity * $price;
    }
    return $total;
}

/**
 * Add item to wishlist
 * @param int $productId
 * @return bool
 */
function addToWishlist($productId) {
    if (!isset($_SESSION['wishlist'])) {
        $_SESSION['wishlist'] = [];
    }
    
    if (!in_array($productId, $_SESSION['wishlist'])) {
        $_SESSION['wishlist'][] = $productId;
        return true;
    }
    return false;
}

/**
 * Remove item from wishlist
 * @param int $productId
 * @return bool
 */
function removeFromWishlist($productId) {
    if (isset($_SESSION['wishlist'])) {
        $key = array_search($productId, $_SESSION['wishlist']);
        if ($key !== false) {
            unset($_SESSION['wishlist'][$key]);
            $_SESSION['wishlist'] = array_values($_SESSION['wishlist']);
            return true;
        }
    }
    return false;
}

/**
 * Check if product is in wishlist
 * @param int $productId
 * @return bool
 */
function isInWishlist($productId) {
    if (!isset($_SESSION['wishlist'])) {
        return false;
    }
    return in_array($productId, $_SESSION['wishlist']);
}

/**
 * Add item to compare
 * @param int $productId
 * @return bool
 */
function addToCompare($productId) {
    if (!isset($_SESSION['compare'])) {
        $_SESSION['compare'] = [];
    }
    
    if (count($_SESSION['compare']) >= 4) {
        return false; // Max 4 items for comparison
    }
    
    if (!in_array($productId, $_SESSION['compare'])) {
        $_SESSION['compare'][] = $productId;
        return true;
    }
    return false;
}

/**
 * Remove item from compare
 * @param int $productId
 * @return bool
 */
function removeFromCompare($productId) {
    if (isset($_SESSION['compare'])) {
        $key = array_search($productId, $_SESSION['compare']);
        if ($key !== false) {
            unset($_SESSION['compare'][$key]);
            $_SESSION['compare'] = array_values($_SESSION['compare']);
            return true;
        }
    }
    return false;
}

/**
 * Check if product is in compare
 * @param int $productId
 * @return bool
 */
function isInCompare($productId) {
    if (!isset($_SESSION['compare'])) {
        return false;
    }
    return in_array($productId, $_SESSION['compare']);
}

/**
 * Add item to cart
 * @param int $productId
 * @param int $quantity
 * @param float $price
 * @param array $options
 * @return bool
 */
function addToCart($productId, $quantity = 1, $price = 0, $options = []) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Check if product already in cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $productId) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }
    
    // Add new item if not found
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $productId,
            'quantity' => $quantity,
            'price' => $price,
            'options' => $options,
            'added_at' => time()
        ];
    }
    
    return true;
}

/**
 * Remove item from cart
 * @param int $productId
 * @return bool
 */
function removeFromCart($productId) {
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $productId) {
                unset($_SESSION['cart'][$key]);
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                return true;
            }
        }
    }
    return false;
}

/**
 * Update cart item quantity
 * @param int $productId
 * @param int $quantity
 * @return bool
 */
function updateCartQuantity($productId, $quantity) {
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $productId) {
                if ($quantity <= 0) {
                    return removeFromCart($productId);
                }
                $item['quantity'] = $quantity;
                return true;
            }
        }
    }
    return false;
}

/**
 * Clear entire cart
 * @return void
 */
function clearCart() {
    $_SESSION['cart'] = [];
}

/**
 * Format price with currency
 * @param float $price
 * @param string $currency
 * @return string
 */
function formatPrice($price, $currency = 'ILS') {
    $symbols = [
        'ILS' => '₪',
        'USD' => '$',
        'EUR' => '€',
        'GBP' => '£'
    ];
    
    $symbol = isset($symbols[$currency]) ? $symbols[$currency] : $currency;
    $formatted = number_format($price, 2);
    
    // RTL languages put symbol after
    if (isRTL()) {
        return $formatted . ' ' . $symbol;
    }
    
    return $symbol . ' ' . $formatted;
}

/**
 * Sanitize input
 * @param string $data
 * @return string
 */
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Check if user is logged in
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Get current user ID
 * @return int|null
 */
function getCurrentUserId() {
    return isLoggedIn() ? $_SESSION['user_id'] : null;
}

/**
 * Redirect to URL
 * @param string $url
 * @return void
 */
function redirect($url) {
    header("Location: " . $url);
    exit();
}

/**
 * Show alert message
 * @param string $message
 * @param string $type (success, error, warning, info)
 * @return string
 */
function showAlert($message, $type = 'info') {
    $icons = [
        'success' => 'fa-check-circle',
        'error' => 'fa-exclamation-circle',
        'warning' => 'fa-exclamation-triangle',
        'info' => 'fa-info-circle'
    ];
    
    $icon = isset($icons[$type]) ? $icons[$type] : $icons['info'];
    
    return '
    <div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">
        <i class="fas ' . $icon . '"></i> ' . htmlspecialchars($message) . '
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    ';
}

/**
 * Generate random string
 * @param int $length
 * @return string
 */
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

/**
 * Get current page name
 * @return string
 */
function getCurrentPage() {
    return basename($_SERVER['PHP_SELF']);
}

/**
 * Check if current page is active
 * @param string $page
 * @return bool
 */
function isActivePage($page) {
    return getCurrentPage() === $page;
}

/**
 * Time ago function
 * @param string $datetime
 * @return string
 */
function timeAgo($datetime) {
    $timestamp = strtotime($datetime);
    $difference = time() - $timestamp;
    
    $periods = [
        'year' => 31536000,
        'month' => 2592000,
        'week' => 604800,
        'day' => 86400,
        'hour' => 3600,
        'minute' => 60,
        'second' => 1
    ];
    
    foreach ($periods as $key => $value) {
        if ($difference >= $value) {
            $time = floor($difference / $value);
            return $time . ' ' . $key . ($time > 1 ? 's' : '') . ' ago';
        }
    }
    
    return 'Just now';
}

// Initialize default session values
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

if (!isset($_SESSION['currency'])) {
    $_SESSION['currency'] = 'ILS';
}
?>