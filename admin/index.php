<?php
/**
 * Admin Dashboard
 * Main dashboard page
 */

require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';
require_once '../includes/language.php';

// Check if admin is logged in
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Get dashboard statistics
$stats = [
    'total_orders' => 0,
    'total_revenue' => 0,
    'total_products' => 0,
    'total_customers' => 0,
    'pending_orders' => 0,
    'low_stock' => 0
];

// Get total orders
$stmt = $db->query("SELECT COUNT(*) as count FROM orders");
$stats['total_orders'] = $stmt->fetch()['count'];

// Get total revenue
$stmt = $db->query("SELECT SUM(total_amount) as total FROM orders WHERE status != 'cancelled'");
$stats['total_revenue'] = $stmt->fetch()['total'] ?? 0;

// Get total products
$stmt = $db->query("SELECT COUNT(*) as count FROM products WHERE status = 'active'");
$stats['total_products'] = $stmt->fetch()['count'];

// Get total customers
$stmt = $db->query("SELECT COUNT(*) as count FROM users WHERE role = 'customer'");
$stats['total_customers'] = $stmt->fetch()['count'];

// Get pending orders
$stmt = $db->query("SELECT COUNT(*) as count FROM orders WHERE status = 'pending'");
$stats['pending_orders'] = $stmt->fetch()['count'];

// Get low stock products
$stmt = $db->query("SELECT COUNT(*) as count FROM products WHERE stock_quantity <= low_stock_alert AND status = 'active'");
$stats['low_stock'] = $stmt->fetch()['count'];

// Get recent orders
$recent_orders = $db->query("
    SELECT o.*, u.first_name, u.last_name 
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.id
    ORDER BY o.created_at DESC
    LIMIT 10
")->fetchAll();

?>
<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>" dir="<?php echo getTextDirection(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo t('dashboard'); ?> - Dorsh Palestine Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="admin-main">
            <!-- Top Bar -->
            <?php include 'includes/topbar.php'; ?>
            
            <!-- Content -->
            <div class="admin-content">
                <!-- Page Header -->
                <div class="page-header">
                    <h1 class="page-title"><?php echo t('dashboard'); ?></h1>
                    <p class="page-subtitle"><?php echo t('welcome_back'); ?></p>
                </div>
                
                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-info">
                            <h3><?php echo formatNumber($stats['total_orders']); ?></h3>
                            <p><?php echo t('total_orders'); ?></p>
                            <span class="stat-change positive">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                </svg>
                                +12% <?php echo t('from_last_month'); ?>
                            </span>
                        </div>
                        <div class="stat-icon primary">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-info">
                            <h3><?php echo formatPrice($stats['total_revenue'], 'ILS'); ?></h3>
                            <p><?php echo t('total_revenue'); ?></p>
                            <span class="stat-change positive">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                </svg>
                                +8.5% <?php echo t('from_last_month'); ?>
                            </span>
                        </div>
                        <div class="stat-icon success">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-info">
                            <h3><?php echo formatNumber($stats['total_products']); ?></h3>
                            <p><?php echo t('total_products'); ?></p>
                            <?php if ($stats['low_stock'] > 0): ?>
                            <span class="stat-change negative">
                                <?php echo $stats['low_stock']; ?> <?php echo t('low_stock'); ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        <div class="stat-icon warning">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-info">
                            <h3><?php echo formatNumber($stats['total_customers']); ?></h3>
                            <p><?php echo t('total_customers'); ?></p>
                            <span class="stat-change positive">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                </svg>
                                +5% <?php echo t('from_last_month'); ?>
                            </span>
                        </div>
                        <div class="stat-icon info">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Orders -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo t('recent_orders'); ?></h3>
                        <a href="orders.php" class="btn btn-outline btn-sm"><?php echo t('view_all'); ?></a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><?php echo t('order_number'); ?></th>
                                        <th><?php echo t('customer'); ?></th>
                                        <th><?php echo t('date'); ?></th>
                                        <th><?php echo t('total'); ?></th>
                                        <th><?php echo t('status'); ?></th>
                                        <th><?php echo t('actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_orders as $order): ?>
                                    <tr>
                                        <td>#<?php echo $order['order_number']; ?></td>
                                        <td><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></td>
                                        <td><?php echo formatDate($order['created_at']); ?></td>
                                        <td><?php echo formatPrice($order['total_amount'], 'ILS'); ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo $order['status']; ?>">
                                                <?php echo t('order_status_' . $order['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="orders/view.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-outline">
                                                <?php echo t('view'); ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../assets/js/admin.js"></script>
</body>
</html>
