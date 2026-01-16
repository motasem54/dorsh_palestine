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
        header('Location: /admin/login.php');
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
        'id' => $_SESSION['admin_id'],
        'name' => $_SESSION['admin_name'],
        'email' => $_SESSION['admin_email'],
        'role' => $_SESSION['admin_role']
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
    if ($_SESSION['admin_role'] === 'super_admin') {
        return true;
    }
    
    global $db;
    
    // Check permission in database
    $result = $db->query(
        "SELECT COUNT(*) as count FROM staff_permissions 
        WHERE staff_id = ? AND permission = ?",
        [$_SESSION['admin_id'], $permission]
    )->fetch();
    
    return $result['count'] > 0;
}

/**
 * Log admin activity
 * @param int $admin_id
 * @param string $action
 * @param string $description
 */
function logAdminActivity($admin_id, $action, $description) {
    global $db;
    
    try {
        $db->query(
            "INSERT INTO admin_activity_log (admin_id, action, description, ip_address, created_at) 
            VALUES (?, ?, ?, ?, NOW())",
            [$admin_id, $action, $description, $_SERVER['REMOTE_ADDR']]
        );
    } catch (Exception $e) {
        error_log('Failed to log admin activity: ' . $e->getMessage());
    }
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
            [$email, $_SERVER['REMOTE_ADDR']]
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
        "SELECT COALESCE(SUM(total), 0) as total FROM orders WHERE status IN ('completed', 'processing')"
    )->fetch()['total'];
    
    // Total orders
    $total_orders = $db->query(
        "SELECT COUNT(*) as count FROM orders"
    )->fetch()['count'];
    
    // Total products
    $total_products = $db->query(
        "SELECT COUNT(*) as count FROM products WHERE status = 'active'"
    )->fetch()['count'];
    
    // Total customers
    $total_customers = $db->query(
        "SELECT COUNT(*) as count FROM users WHERE role = 'customer'"
    )->fetch()['count'];
    
    // Low stock count
    $low_stock_count = $db->query(
        "SELECT COUNT(*) as count FROM products WHERE stock_quantity < 10 AND status = 'active'"
    )->fetch()['count'];
    
    // Today's sales
    $today_sales = $db->query(
        "SELECT COALESCE(SUM(total), 0) as total FROM orders 
        WHERE DATE(created_at) = CURDATE() AND status IN ('completed', 'processing')"
    )->fetch()['total'];
    
    // Pending orders
    $pending_orders = $db->query(
        "SELECT COUNT(*) as count FROM orders WHERE status = 'pending'"
    )->fetch()['count'];
    
    // Processing orders
    $processing_orders = $db->query(
        "SELECT COUNT(*) as count FROM orders WHERE status = 'processing'"
    )->fetch()['count'];
    
    // Completed today
    $completed_today = $db->query(
        "SELECT COUNT(*) as count FROM orders 
        WHERE DATE(created_at) = CURDATE() AND status = 'completed'"
    )->fetch()['count'];
    
    // Average order value
    $avg_order_value = $db->query(
        "SELECT COALESCE(AVG(total), 0) as avg FROM orders WHERE status IN ('completed', 'processing')"
    )->fetch()['avg'];
    
    // Recent orders
    $recent_orders = $db->query(
        "SELECT o.*, CONCAT(u.first_name, ' ', u.last_name) as customer_name 
        FROM orders o 
        LEFT JOIN users u ON o.user_id = u.id 
        ORDER BY o.created_at DESC 
        LIMIT 5"
    )->fetchAll();
    
    // Top products
    $top_products = $db->query(
        "SELECT p.*, 
        COALESCE(SUM(oi.quantity), 0) as total_sold,
        COALESCE(SUM(oi.quantity * oi.price), 0) as revenue
        FROM products p
        LEFT JOIN order_items oi ON p.id = oi.product_id
        WHERE p.status = 'active'
        GROUP BY p.id
        ORDER BY total_sold DESC
        LIMIT 5"
    )->fetchAll();
    
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
        'sales_change' => 15.5, // Calculate from previous month
        'orders_change' => 12.3,
        'customers_new' => 23
    ];
}

/**
 * Get status badge color
 * @param string $status
 * @return string
 */
function getStatusColor($status) {
    $colors = [
        'pending' => 'warning',
        'processing' => 'info',
        'completed' => 'success',
        'cancelled' => 'danger',
        'shipped' => 'primary',
        'delivered' => 'success'
    ];
    
    return $colors[$status] ?? 'secondary';
}
