<?php
/**
 * Admin Dashboard - Main Page
 * Dorsh Palestine E-Commerce
 * Design inspired by Golden Gates
 */

session_start();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$database = new Database();
$db = $database->getConnection();

// Get dashboard statistics
$stats = getDashboardStats($db);
$recent_orders = getRecentOrders($db, 10);
$low_stock_products = getLowStockProducts($db, 10);
$top_products = getTopSellingProducts($db, 5);
$sales_chart_data = getSalesChartData($db, 30); // Last 30 days

include 'includes/header.php';
?>

<div class="dashboard-content">
    <!-- Stats Cards -->
    <div class="stats-row">
        <div class="stat-card blue">
            <div class="stat-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-info">
                <h3>$<?php echo number_format($stats['total_sales'], 2); ?></h3>
                <p>Total Sales</p>
                <span class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> <?php echo $stats['sales_change']; ?>%
                </span>
            </div>
        </div>

        <div class="stat-card green">
            <div class="stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo number_format($stats['total_orders']); ?></h3>
                <p>Total Orders</p>
                <span class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> <?php echo $stats['orders_change']; ?>%
                </span>
            </div>
        </div>

        <div class="stat-card orange">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo number_format($stats['total_customers']); ?></h3>
                <p>Total Customers</p>
                <span class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> <?php echo $stats['customers_change']; ?>%
                </span>
            </div>
        </div>

        <div class="stat-card purple">
            <div class="stat-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo number_format($stats['total_products']); ?></h3>
                <p>Total Products</p>
                <span class="stat-change">
                    <?php echo $stats['out_of_stock']; ?> out of stock
                </span>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="charts-row">
        <!-- Sales Chart -->
        <div class="chart-card wide">
            <div class="card-header">
                <h3>Sales Overview</h3>
                <div class="card-actions">
                    <select id="sales-period" class="form-select">
                        <option value="7">Last 7 Days</option>
                        <option value="30" selected>Last 30 Days</option>
                        <option value="90">Last 3 Months</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Top Products -->
        <div class="chart-card">
            <div class="card-header">
                <h3>Top Selling Products</h3>
            </div>
            <div class="card-body">
                <div class="top-products-list">
                    <?php foreach ($top_products as $index => $product): ?>
                    <div class="top-product-item">
                        <span class="rank">#<?php echo $index + 1; ?></span>
                        <img src="<?php echo htmlspecialchars($product['image_url'] ?? '/images/placeholder.jpg'); ?>" 
                             alt="<?php echo htmlspecialchars($product['name_en']); ?>">
                        <div class="product-info">
                            <p class="product-name"><?php echo htmlspecialchars($product['name_en']); ?></p>
                            <p class="product-sales"><?php echo $product['total_sold']; ?> sold</p>
                        </div>
                        <span class="product-revenue">$<?php echo number_format($product['revenue'], 2); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="tables-row">
        <!-- Recent Orders -->
        <div class="table-card wide">
            <div class="card-header">
                <h3>Recent Orders</h3>
                <a href="orders/" class="btn-link">View All <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card-body">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_orders as $order): ?>
                        <tr>
                            <td><strong>#<?php echo $order['id']; ?></strong></td>
                            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                            <td><strong>$<?php echo number_format($order['total_amount'], 2); ?></strong></td>
                            <td>
                                <span class="status-badge <?php echo strtolower($order['status']); ?>">
                                    <?php echo ucfirst($order['status']); ?>
                                </span>
                            </td>
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

        <!-- Low Stock Alert -->
        <div class="table-card">
            <div class="card-header">
                <h3>Low Stock Alert</h3>
                <span class="alert-badge"><?php echo count($low_stock_products); ?></span>
            </div>
            <div class="card-body">
                <div class="alert-list">
                    <?php foreach ($low_stock_products as $product): ?>
                    <div class="alert-item">
                        <img src="<?php echo htmlspecialchars($product['image_url'] ?? '/images/placeholder.jpg'); ?>" 
                             alt="<?php echo htmlspecialchars($product['name_en']); ?>">
                        <div class="alert-info">
                            <p class="product-name"><?php echo htmlspecialchars($product['name_en']); ?></p>
                            <p class="stock-level <?php echo $product['stock_quantity'] == 0 ? 'out' : 'low'; ?>">
                                <?php if ($product['stock_quantity'] == 0): ?>
                                    Out of stock
                                <?php else: ?>
                                    Only <?php echo $product['stock_quantity']; ?> left
                                <?php endif; ?>
                            </p>
                        </div>
                        <a href="products/edit.php?id=<?php echo $product['id']; ?>" 
                           class="btn-icon-small">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Sales Chart
const salesCtx = document.getElementById('salesChart').getContext('2d');
const salesData = <?php echo json_encode($sales_chart_data); ?>;

new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: salesData.labels,
        datasets: [{
            label: 'Sales',
            data: salesData.values,
            borderColor: '#2196F3',
            backgroundColor: 'rgba(33, 150, 243, 0.1)',
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
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value;
                    }
                }
            }
        }
    }
});

// Update sales period
document.getElementById('sales-period').addEventListener('change', function() {
    const period = this.value;
    window.location.href = '?period=' + period;
});
</script>

<?php
include 'includes/footer.php';

/**
 * Get dashboard statistics
 */
function getDashboardStats($db) {
    $stats = [];
    
    // Total sales (last 30 days)
    $stmt = $db->query("
        SELECT COALESCE(SUM(total_amount), 0) as total
        FROM orders
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
        AND status != 'cancelled'
    ");
    $stats['total_sales'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Sales change
    $stmt = $db->query("
        SELECT COALESCE(SUM(total_amount), 0) as total
        FROM orders
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 60 DAY)
        AND created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)
        AND status != 'cancelled'
    ");
    $prev_sales = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    $stats['sales_change'] = $prev_sales > 0 ? 
        round((($stats['total_sales'] - $prev_sales) / $prev_sales) * 100, 1) : 0;
    
    // Total orders
    $stmt = $db->query("
        SELECT COUNT(*) as total
        FROM orders
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
    ");
    $stats['total_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Orders change
    $stmt = $db->query("
        SELECT COUNT(*) as total
        FROM orders
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 60 DAY)
        AND created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)
    ");
    $prev_orders = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    $stats['orders_change'] = $prev_orders > 0 ? 
        round((($stats['total_orders'] - $prev_orders) / $prev_orders) * 100, 1) : 0;
    
    // Total customers
    $stmt = $db->query("SELECT COUNT(*) as total FROM users WHERE role = 'customer'");
    $stats['total_customers'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Customers change
    $stmt = $db->query("
        SELECT COUNT(*) as total
        FROM users
        WHERE role = 'customer'
        AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
    ");
    $new_customers = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    $stats['customers_change'] = $stats['total_customers'] > 0 ? 
        round(($new_customers / $stats['total_customers']) * 100, 1) : 0;
    
    // Total products
    $stmt = $db->query("SELECT COUNT(*) as total FROM products WHERE status = 'active'");
    $stats['total_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Out of stock
    $stmt = $db->query("
        SELECT COUNT(*) as total
        FROM products
        WHERE status = 'active' AND stock_quantity = 0
    ");
    $stats['out_of_stock'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    return $stats;
}

/**
 * Get recent orders
 */
function getRecentOrders($db, $limit = 10) {
    $stmt = $db->prepare("
        SELECT o.*, 
               CONCAT(u.first_name, ' ', u.last_name) as customer_name
        FROM orders o
        LEFT JOIN users u ON o.user_id = u.id
        ORDER BY o.created_at DESC
        LIMIT :limit
    ");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get low stock products
 */
function getLowStockProducts($db, $limit = 10) {
    $stmt = $db->prepare("
        SELECT p.*, pi.image_url
        FROM products p
        LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
        WHERE p.status = 'active'
        AND p.stock_quantity <= p.low_stock_threshold
        ORDER BY p.stock_quantity ASC
        LIMIT :limit
    ");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get top selling products
 */
function getTopSellingProducts($db, $limit = 5) {
    $stmt = $db->prepare("
        SELECT p.*, pi.image_url,
               COUNT(oi.id) as total_sold,
               SUM(oi.subtotal) as revenue
        FROM products p
        LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
        LEFT JOIN order_items oi ON p.id = oi.product_id
        LEFT JOIN orders o ON oi.order_id = o.id
        WHERE o.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
        AND o.status != 'cancelled'
        GROUP BY p.id
        ORDER BY total_sold DESC
        LIMIT :limit
    ");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get sales chart data
 */
function getSalesChartData($db, $days = 30) {
    $stmt = $db->prepare("
        SELECT DATE(created_at) as date,
               SUM(total_amount) as total
        FROM orders
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL :days DAY)
        AND status != 'cancelled'
        GROUP BY DATE(created_at)
        ORDER BY date ASC
    ");
    $stmt->bindParam(':days', $days, PDO::PARAM_INT);
    $stmt->execute();
    
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $labels = [];
    $values = [];
    
    foreach ($data as $row) {
        $labels[] = date('M d', strtotime($row['date']));
        $values[] = (float)$row['total'];
    }
    
    return [
        'labels' => $labels,
        'values' => $values
    ];
}
?>
