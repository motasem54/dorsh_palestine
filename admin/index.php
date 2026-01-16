<?php
/**
 * Admin Dashboard - Main Page
 * Dorsh Palestine E-Commerce
 */

require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

// Check if admin is logged in
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$pageTitle = 'Dashboard';
include 'includes/header.php';

// Get dashboard statistics
$stats = getDashboardStats();
$recentOrders = getRecentOrders(10);
$lowStockProducts = getLowStockProducts(10);
$salesData = getSalesData(30); // Last 30 days

?>

<div class="dashboard-container">
    <!-- Statistics Cards -->
    <div class="stats-grid">
        <!-- Total Sales -->
        <div class="stat-card blue">
            <div class="stat-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo formatCurrency($stats['total_sales']); ?></h3>
                <p>Total Sales</p>
                <span class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 
                    <?php echo $stats['sales_growth']; ?>% vs last month
                </span>
            </div>
        </div>
        
        <!-- Total Orders -->
        <div class="stat-card green">
            <div class="stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo number_format($stats['total_orders']); ?></h3>
                <p>Total Orders</p>
                <span class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 
                    <?php echo $stats['orders_growth']; ?>% vs last month
                </span>
            </div>
        </div>
        
        <!-- Total Products -->
        <div class="stat-card orange">
            <div class="stat-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo number_format($stats['total_products']); ?></h3>
                <p>Total Products</p>
                <span class="stat-info">
                    <?php echo $stats['active_products']; ?> active
                </span>
            </div>
        </div>
        
        <!-- Total Customers -->
        <div class="stat-card purple">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo number_format($stats['total_customers']); ?></h3>
                <p>Total Customers</p>
                <span class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 
                    <?php echo $stats['new_customers']; ?> new this month
                </span>
            </div>
        </div>
    </div>
    
    <!-- Charts Row -->
    <div class="charts-row">
        <!-- Sales Chart -->
        <div class="chart-card">
            <div class="card-header">
                <h3><i class="fas fa-chart-line"></i> Sales Overview</h3>
                <div class="card-actions">
                    <select id="sales-period" class="form-control">
                        <option value="7">Last 7 Days</option>
                        <option value="30" selected>Last 30 Days</option>
                        <option value="90">Last 90 Days</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
        
        <!-- Orders Chart -->
        <div class="chart-card">
            <div class="card-header">
                <h3><i class="fas fa-chart-pie"></i> Order Status</h3>
            </div>
            <div class="card-body">
                <canvas id="ordersChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Recent Orders & Low Stock -->
    <div class="info-row">
        <!-- Recent Orders -->
        <div class="info-card">
            <div class="card-header">
                <h3><i class="fas fa-receipt"></i> Recent Orders</h3>
                <a href="orders/" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentOrders as $order): ?>
                            <tr>
                                <td><a href="orders/view.php?id=<?php echo $order['id']; ?>">
                                    #<?php echo $order['order_number']; ?>
                                </a></td>
                                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                <td><?php echo formatCurrency($order['total']); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo $order['status']; ?>">
                                        <?php echo ucfirst($order['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo formatDate($order['created_at']); ?></td>
                                <td>
                                    <a href="orders/view.php?id=<?php echo $order['id']; ?>" 
                                       class="btn-icon" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Low Stock Products -->
        <div class="info-card">
            <div class="card-header">
                <h3><i class="fas fa-exclamation-triangle"></i> Low Stock Alert</h3>
                <a href="products/?filter=low_stock" class="btn btn-sm btn-warning">View All</a>
            </div>
            <div class="card-body">
                <?php if (empty($lowStockProducts)): ?>
                    <div class="empty-state">
                        <i class="fas fa-check-circle"></i>
                        <p>All products are well stocked!</p>
                    </div>
                <?php else: ?>
                    <div class="low-stock-list">
                        <?php foreach ($lowStockProducts as $product): ?>
                        <div class="low-stock-item">
                            <div class="product-info">
                                <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name_en']); ?>">
                                <div>
                                    <h4><?php echo htmlspecialchars($product['name_en']); ?></h4>
                                    <p class="sku">SKU: <?php echo $product['sku']; ?></p>
                                </div>
                            </div>
                            <div class="stock-info">
                                <span class="stock-count <?php echo $product['stock_quantity'] == 0 ? 'out-of-stock' : 'low-stock'; ?>">
                                    <?php echo $product['stock_quantity']; ?> left
                                </span>
                                <a href="products/edit.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-primary">
                                    Update Stock
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Sales Chart
const salesCtx = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode(array_column($salesData, 'date')); ?>,
        datasets: [{
            label: 'Sales (ILS)',
            data: <?php echo json_encode(array_column($salesData, 'total')); ?>,
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Orders Status Chart
const ordersCtx = document.getElementById('ordersChart').getContext('2d');
const ordersChart = new Chart(ordersCtx, {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'],
        datasets: [{
            data: [
                <?php echo $stats['orders_pending']; ?>,
                <?php echo $stats['orders_processing']; ?>,
                <?php echo $stats['orders_shipped']; ?>,
                <?php echo $stats['orders_delivered']; ?>,
                <?php echo $stats['orders_cancelled']; ?>
            ],
            backgroundColor: [
                '#fbbf24',
                '#3b82f6',
                '#8b5cf6',
                '#10b981',
                '#ef4444'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>

<?php include 'includes/footer.php'; ?>
