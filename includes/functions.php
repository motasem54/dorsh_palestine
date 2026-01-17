<?php
/**
 * Helper Functions
 * Dorsh Palestine E-Commerce
 */

// ============================================================
// SECURITY & SANITIZATION
// ============================================================

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// ============================================================
// USER AUTHENTICATION
// ============================================================

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getCurrentUser() {
    return $_SESSION['user'] ?? null;
}

function getUserId() {
    return $_SESSION['user_id'] ?? null;
}

// ============================================================
// LANGUAGE & TRANSLATION
// ============================================================

/**
 * Translate text key
 * @param string $key
 * @return string
 */
function t($key) {
    global $translations, $current_lang;
    
    $lang = $current_lang ?? 'en';
    
    if (isset($translations[$lang][$key])) {
        return $translations[$lang][$key];
    }
    
    // Fallback to English
    if (isset($translations['en'][$key])) {
        return $translations['en'][$key];
    }
    
    // Return formatted key if translation not found
    return ucfirst(str_replace('_', ' ', $key));
}

/**
 * Translate database field based on current language
 * @param array $item
 * @param string $field
 * @return string
 */
function translate($item, $field) {
    global $current_lang;
    $key = $field . '_' . ($current_lang === 'ar' ? 'ar' : 'en');
    return $item[$key] ?? $item[$field . '_en'] ?? '';
}

/**
 * Check if current language is RTL
 * @return bool
 */
function isRTL() {
    global $current_lang;
    return isset($current_lang) && $current_lang === 'ar';
}

/**
 * Get current language
 * @return string
 */
function getCurrentLang() {
    global $current_lang;
    return $current_lang ?? 'en';
}

/**
 * Get text direction
 * @return string
 */
function getDir() {
    return isRTL() ? 'rtl' : 'ltr';
}

/**
 * Get language attribute
 * @return string
 */
function getLang() {
    return getCurrentLang();
}

// ============================================================
// CART FUNCTIONS
// ============================================================

/**
 * Get cart items count
 * @return int
 */
function getCartCount() {
    global $db;
    
    if (isLoggedIn()) {
        $result = $db->query(
            "SELECT COALESCE(SUM(quantity), 0) as count FROM cart WHERE user_id = ?",
            [getUserId()]
        )->fetch();
        return (int)($result['count'] ?? 0);
    } else {
        return isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
    }
}

/**
 * Get cart items
 * @return array
 */
function getCartItems() {
    global $db;
    
    if (isLoggedIn()) {
        return $db->query(
            "SELECT c.*, p.name_en, p.name_ar, p.price, p.image 
            FROM cart c 
            JOIN products p ON c.product_id = p.id 
            WHERE c.user_id = ?",
            [getUserId()]
        )->fetchAll();
    } else {
        return $_SESSION['cart'] ?? [];
    }
}

/**
 * Add product to cart
 * @param int $product_id
 * @param int $quantity
 * @return bool
 */
function addToCart($product_id, $quantity = 1) {
    global $db;
    
    if (isLoggedIn()) {
        // Check if already in cart
        $existing = $db->query(
            "SELECT * FROM cart WHERE user_id = ? AND product_id = ?",
            [getUserId(), $product_id]
        )->fetch();
        
        if ($existing) {
            // Update quantity
            $db->query(
                "UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?",
                [$quantity, getUserId(), $product_id]
            );
        } else {
            // Insert new
            $db->query(
                "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)",
                [getUserId(), $product_id, $quantity]
            );
        }
        return true;
    } else {
        // Session-based cart
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = ['quantity' => $quantity];
        }
        return true;
    }
}

/**
 * Remove product from cart
 * @param int $product_id
 * @return bool
 */
function removeFromCart($product_id) {
    global $db;
    
    if (isLoggedIn()) {
        $db->query(
            "DELETE FROM cart WHERE user_id = ? AND product_id = ?",
            [getUserId(), $product_id]
        );
        return true;
    } else {
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
        return true;
    }
}

/**
 * Clear cart
 * @return bool
 */
function clearCart() {
    global $db;
    
    if (isLoggedIn()) {
        $db->query("DELETE FROM cart WHERE user_id = ?", [getUserId()]);
        return true;
    } else {
        $_SESSION['cart'] = [];
        return true;
    }
}

// ============================================================
// ORDER FUNCTIONS
// ============================================================

/**
 * Generate unique order number
 * @return string
 */
function generateOrderNumber() {
    return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
}

/**
 * Get order status color
 * @param string $status
 * @return string
 */
function getStatusColor($status) {
    switch($status) {
        case 'pending':
            return 'warning';
        case 'processing':
            return 'info';
        case 'shipped':
            return 'primary';
        case 'delivered':
        case 'completed':
            return 'success';
        case 'cancelled':
            return 'danger';
        default:
            return 'secondary';
    }
}

// ============================================================
// PRICE & CURRENCY
// ============================================================

/**
 * Format price with currency
 * @param float $price
 * @return string
 */
function formatPrice($price) {
    return '$' . number_format($price, 2);
}

/**
 * Calculate discount percentage
 * @param float $original
 * @param float $sale
 * @return int
 */
function getDiscountPercent($original, $sale) {
    if ($original <= 0) return 0;
    return round((($original - $sale) / $original) * 100);
}

// ============================================================
// DATE & TIME
// ============================================================

/**
 * Format date for display
 * @param string $date
 * @return string
 */
function formatDate($date) {
    return date('M d, Y', strtotime($date));
}

/**
 * Format datetime for display
 * @param string $datetime
 * @return string
 */
function formatDateTime($datetime) {
    return date('M d, Y h:i A', strtotime($datetime));
}

/**
 * Get time ago
 * @param string $datetime
 * @return string
 */
function timeAgo($datetime) {
    $time = strtotime($datetime);
    $diff = time() - $time;
    
    if ($diff < 60) return 'Just now';
    if ($diff < 3600) return floor($diff / 60) . ' min ago';
    if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
    if ($diff < 604800) return floor($diff / 86400) . ' days ago';
    
    return formatDate($datetime);
}

// ============================================================
// URL & ROUTING
// ============================================================

/**
 * Redirect to URL
 * @param string $url
 */
function redirect($url) {
    header("Location: {$url}");
    exit;
}

/**
 * Get current page URL
 * @return string
 */
function getCurrentUrl() {
    return $_SERVER['REQUEST_URI'];
}

/**
 * Check if current page
 * @param string $page
 * @return bool
 */
function isCurrentPage($page) {
    return strpos($_SERVER['PHP_SELF'], $page) !== false;
}

// ============================================================
// ADMIN FUNCTIONS
// ============================================================

if (!function_exists('logAdminActivity')) {
    function logAdminActivity($admin_id, $action, $description) {
        global $db;
        try {
            $db->query(
                "INSERT INTO admin_activity_logs (admin_id, action, description, ip_address, user_agent, created_at) VALUES (?, ?, ?, ?, ?, NOW())",
                [$admin_id, $action, $description, $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '']
            );
        } catch (Exception $e) {
            error_log("Failed to log admin activity: " . $e->getMessage());
        }
    }
}

// ============================================================
// FLASH MESSAGES
// ============================================================

/**
 * Set flash message
 * @param string $type (success, error, warning, info)
 * @param string $message
 */
function setFlash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/**
 * Get and clear flash message
 * @return array|null
 */
function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

// ============================================================
// VALIDATION
// ============================================================

/**
 * Validate email
 * @param string $email
 * @return bool
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate phone number
 * @param string $phone
 * @return bool
 */
function isValidPhone($phone) {
    return preg_match('/^[0-9+\-\s()]{8,20}$/', $phone);
}
