<?php
/**
 * Admin Dashboard - Main Page
 * Inspired by Golden Gates Design
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/includes/auth.php';

// Check if admin is logged in
requireAdminLogin();

$page_title = 'Dashboard';
$current_page = 'dashboard';

include 'includes/header.php';

// Get dashboard statistics
$stats = getDashboardStats();
?>

<!-- Dashboard Content -->
<div class="dashboard-content">
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </h1>
        <div class="page-actions">
            <span class="last-update">Last updated: <?php echo date('M d, Y H:i'); ?></span>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <!-- Total Sales -->
        <div class="stat-card card-blue">
            <div class="stat-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-details">
                <div class="stat-number">$<?php echo number_format($stats['total_sales'], 2); ?></div>
                <div class="stat-label">Total Sales</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> <?php echo $stats['sales_change']; ?>% from last month
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="stat-card card-green">
            <div class="stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-details">
                <div class="stat-number"><?php echo number_format($stats['total_orders']); ?></div>
                <div class="stat-label">Total Orders</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> <?php echo $stats['orders_change']; ?>% from last month
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="stat-card card-purple">
            <div class="stat-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-details">
                <div class="stat-number"><?php echo number_format($stats['total_products']); ?></div>
                <div class="stat-label">Total Products</div>
                <div class="stat-info">
                    <span class="badge badge-warning"><?php echo $stats['low_stock_count']; ?></span> Low Stock
                </div>
            </div>
        </div>

        <!-- Total Customers -->
        <div class="stat-card card-orange">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-details">
                <div class="stat-number"><?php echo number_format($stats['total_customers']); ?></div>
                <div class="stat-label">Total Customers</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> <?php echo $stats['customers_new']; ?> new this month
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Activity -->
    <div class="dashboard-row">
        <!-- Sales Chart -->
        <div class="dashboard-col-8">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-line"></i> Sales Overview</h3>
                    <div class="card-actions">
                        <select class="form-control form-control-sm" id="salesPeriod">
                            <option value="7">Last 7 Days</option>
                            <option value="30" selected>Last 30 Days</option>
                            <option value="90">Last 3 Months</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="80"></canvas>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="dashboard-col-4">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-pie"></i> Quick Stats</h3>
                </div>
                <div class="card-body">
                    <div class="quick-stat-item">
                        <span class="quick-stat-label">Today's Sales</span>
                        <span class="quick-stat-value">$<?php echo number_format($stats['today_sales'], 2); ?></span>
                    </div>
                    <div class="quick-stat-item">
                        <span class="quick-stat-label">Pending Orders</span>
                        <span class="quick-stat-value badge-warning"><?php echo $stats['pending_orders']; ?></span>
                    </div>
                    <div class="quick-stat-item">
                        <span class="quick-stat-label">Processing Orders</span>
                        <span class="quick-stat-value badge-info"><?php echo $stats['processing_orders']; ?></span>
                    </div>
                    <div class="quick-stat-item">
                        <span class="quick-stat-label">Completed Today</span>
                        <span class="quick-stat-value badge-success"><?php echo $stats['completed_today']; ?></span>
                    </div>
                    <div class="quick-stat-item">
                        <span class="quick-stat-label">Average Order Value</span>
                        <span class="quick-stat-value">$<?php echo number_format($stats['avg_order_value'], 2); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders and Top Products -->
    <div class="dashboard-row">
        <!-- Recent Orders -->
        <div class="dashboard-col-6">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-shopping-bag"></i> Recent Orders</h3>
                    <a href="orders.php" class="btn btn-sm btn-outline">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stats['recent_orders'] as $order): ?>
                                <tr>
                                    <td><a href="orders/view.php?id=<?php echo $order['id']; ?>">#<?php echo $order['order_number']; ?></a></td>
                                    <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                    <td>$<?php echo number_format($order['total'], 2); ?></td>
                                    <td><span class="badge badge-<?php echo getStatusColor($order['status']); ?>"><?php echo ucfirst($order['status']); ?></span></td>
                                    <td><?php echo date('M d, H:i', strtotime($order['created_at'])); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="dashboard-col-6">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-trophy"></i> Top Selling Products</h3>
                    <a href="products/" class="btn btn-sm btn-outline">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Sales</th>
                                    <th>Revenue</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stats['top_products'] as $product): ?>
                                <tr>
                                    <td>
                                        <div class="product-mini">
                                            <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                            <span><?php echo htmlspecialchars($product['name']); ?></span>
                                        </div>
                                    </td>
                                    <td><?php echo $product['total_sold']; ?> units</td>
                                    <td>$<?php echo number_format($product['revenue'], 2); ?></td>
                                    <td>
                                        <span class="badge <?php echo $product['stock_quantity'] < 10 ? 'badge-danger' : 'badge-success'; ?>">
                                            <?php echo $product['stock_quantity']; ?>
                                        </span>
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

    <!-- Low Stock Alert -->
    <?php if ($stats['low_stock_count'] > 0): ?>
    <div class="dashboard-row">
        <div class="dashboard-col-12">
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Low Stock Alert!</strong> You have <?php echo $stats['low_stock_count']; ?> products with low stock levels.
                <a href="products/?filter=low_stock" class="alert-link">View Products</a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
