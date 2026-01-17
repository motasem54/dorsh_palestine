<?php
/**
 * Admin Authentication Functions
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if admin is logged in
 * @return bool
 */
function isAdminLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

/**
 * Require admin login - redirect to login if not logged in
 */
function requireAdminLogin() {
    if (!isAdminLoggedIn()) {
        $redirect = $_SERVER['PHP_SELF'];
        header('Location: ' . (strpos($redirect, '/admin/') !== false ? '/admin/login.php' : 'login.php'));
        exit;
    }
}

/**
 * Get current admin info
 * @return array
 */
function getCurrentAdmin() {
    if (!isAdminLoggedIn()) {
        return null;
    }
    
    return [
        'id' => $_SESSION['admin_id'] ?? null,
        'username' => $_SESSION['admin']['username'] ?? '',
        'email' => $_SESSION['admin']['email'] ?? '',
        'role' => $_SESSION['admin']['role'] ?? 'staff'
    ];
}

/**
 * Check if admin has permission
 * @param string $permission
 * @return bool
 */
function hasPermission($permission) {
    if (!isAdminLoggedIn()) {
        return false;
    }
    
    // Super admin has all permissions
    if (isset($_SESSION['admin']['role']) && $_SESSION['admin']['role'] === 'super_admin') {
        return true;
    }
    
    return false;
}

/**
 * Log failed login attempt
 * @param string $email
 */
function logFailedLogin($email) {
    global $db;
    
    try {
        $db->query(
            "INSERT INTO login_attempts (email, ip_address, attempt_time) 
            VALUES (?, ?, NOW())",
            [$email, $_SERVER['REMOTE_ADDR'] ?? '']
        );
    } catch (Exception $e) {
        error_log('Failed to log login attempt: ' . $e->getMessage());
    }
}

/**
 * Get dashboard statistics
 * @return array
 */
function getDashboardStats() {
    global $db;
    
    // Total sales
    $total_sales = $db->query(
        "SELECT COALESCE(SUM(total), 0) as total FROM orders WHERE status IN ('delivered', 'processing')"
    )->fetch()['total'] ?? 0;
    
    // Total orders
    $total_orders = $db->query(
        "SELECT COUNT(*) as count FROM orders"
    )->fetch()['count'] ?? 0;
    
    // Total products
    $total_products = $db->query(
        "SELECT COUNT(*) as count FROM products WHERE status = 'active'"
    )->fetch()['count'] ?? 0;
    
    // Total customers
    $total_customers = $db->query(
        "SELECT COUNT(*) as count FROM users WHERE role = 'customer'"
    )->fetch()['count'] ?? 0;
    
    // Low stock count
    $low_stock_count = $db->query(
        "SELECT COUNT(*) as count FROM products WHERE stock < 10 AND status = 'active'"
    )->fetch()['count'] ?? 0;
    
    // Today's sales
    $today_sales = $db->query(
        "SELECT COALESCE(SUM(total), 0) as total FROM orders 
        WHERE DATE(created_at) = CURDATE() AND status IN ('delivered', 'processing')"
    )->fetch()['total'] ?? 0;
    
    // Pending orders
    $pending_orders = $db->query(
        "SELECT COUNT(*) as count FROM orders WHERE status = 'pending'"
    )->fetch()['count'] ?? 0;
    
    // Processing orders
    $processing_orders = $db->query(
        "SELECT COUNT(*) as count FROM orders WHERE status = 'processing'"
    )->fetch()['count'] ?? 0;
    
    // Completed today
    $completed_today = $db->query(
        "SELECT COUNT(*) as count FROM orders 
        WHERE DATE(created_at) = CURDATE() AND status = 'delivered'"
    )->fetch()['count'] ?? 0;
    
    // Average order value
    $avg_order_value = $db->query(
        "SELECT COALESCE(AVG(total), 0) as avg FROM orders WHERE status IN ('delivered', 'processing')"
    )->fetch()['avg'] ?? 0;
    
    // Recent orders
    $recent_orders = $db->query(
        "SELECT o.*, CONCAT(o.first_name, ' ', o.last_name) as customer_name 
        FROM orders o 
        ORDER BY o.created_at DESC 
        LIMIT 5"
    )->fetchAll() ?? [];
    
    // Top products
    $top_products = $db->query(
        "SELECT p.*, 
        COALESCE(SUM(oi.quantity), 0) as total_sold,
        COALESCE(SUM(oi.total), 0) as revenue
        FROM products p
        LEFT JOIN order_items oi ON p.id = oi.product_id
        WHERE p.status = 'active'
        GROUP BY p.id
        ORDER BY total_sold DESC
        LIMIT 5"
    )->fetchAll() ?? [];
    
    return [
        'total_sales' => $total_sales,
        'total_orders' => $total_orders,
        'total_products' => $total_products,
        'total_customers' => $total_customers,
        'low_stock_count' => $low_stock_count,
        'today_sales' => $today_sales,
        'pending_orders' => $pending_orders,
        'processing_orders' => $processing_orders,
        'completed_today' => $completed_today,
        'avg_order_value' => $avg_order_value,
        'recent_orders' => $recent_orders,
        'top_products' => $top_products,
        'sales_change' => 0,
        'orders_change' => 0,
        'customers_new' => 0
    ];
}
