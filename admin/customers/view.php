<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdminLogin();

$customer_id = $_GET['id'] ?? 0;

// Get customer details
$customer = $db->query(
    "SELECT u.*, 
    COUNT(DISTINCT o.id) as total_orders,
    COALESCE(SUM(o.total), 0) as total_spent,
    MAX(o.created_at) as last_order_date
    FROM users u
    LEFT JOIN orders o ON u.id = o.user_id
    WHERE u.id = ? AND u.role = 'customer'
    GROUP BY u.id",
    [$customer_id]
)->fetch();

if (!$customer) {
    header('Location: index.php');
    exit;
}

// Get customer orders
$orders = $db->query(
    "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT 20",
    [$customer_id]
)->fetchAll();

$page_title = 'Customer: ' . $customer['first_name'] . ' ' . $customer['last_name'];
$current_page = 'customers';

include __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-user"></i> <?php echo h($customer['first_name'] . ' ' . $customer['last_name']); ?>
    </h1>
    <div class="page-actions">
        <a href="index.php" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Back to Customers
        </a>
    </div>
</div>

<div class="dashboard-row">
    <!-- Customer Stats -->
    <div class="dashboard-col-12">
        <div class="stats-grid">
            <div class="stat-card card-blue">
                <div class="stat-icon"><i class="fas fa-shopping-bag"></i></div>
                <div class="stat-details">
                    <div class="stat-number"><?php echo $customer['total_orders']; ?></div>
                    <div class="stat-label">Total Orders</div>
                </div>
            </div>
            <div class="stat-card card-green">
                <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
                <div class="stat-details">
                    <div class="stat-number">$<?php echo number_format($customer['total_spent'], 2); ?></div>
                    <div class="stat-label">Total Spent</div>
                </div>
            </div>
            <div class="stat-card card-purple">
                <div class="stat-icon"><i class="fas fa-calendar"></i></div>
                <div class="stat-details">
                    <div class="stat-number" style="font-size: 18px;">
                        <?php echo $customer['last_order_date'] ? date('M d, Y', strtotime($customer['last_order_date'])) : 'No orders'; ?>
                    </div>
                    <div class="stat-label">Last Order</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Customer Info -->
    <div class="dashboard-col-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle"></i> Customer Information</h3>
            </div>
            <div class="card-body">
                <div class="info-item">
                    <small>Full Name:</small>
                    <strong><?php echo h($customer['first_name'] . ' ' . $customer['last_name']); ?></strong>
                </div>
                <div class="info-item">
                    <small>Email:</small>
                    <strong><?php echo h($customer['email']); ?></strong>
                </div>
                <?php if ($customer['phone']): ?>
                <div class="info-item">
                    <small>Phone:</small>
                    <strong><?php echo h($customer['phone']); ?></strong>
                </div>
                <?php endif; ?>
                <div class="info-item">
                    <small>Member Since:</small>
                    <strong><?php echo date('M d, Y', strtotime($customer['created_at'])); ?></strong>
                </div>
                <div class="info-item">
                    <small>Status:</small>
                    <span class="badge badge-<?php echo $customer['status'] === 'active' ? 'success' : 'secondary'; ?>">
                        <?php echo ucfirst($customer['status']); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Order History -->
    <div class="dashboard-col-8">
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-history"></i> Order History</h3>
            </div>
            <div class="card-body">
                <?php if (empty($orders)): ?>
                <p style="text-align: center; padding: 40px; color: #999;">No orders yet</p>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><strong>#<?php echo $order['order_number']; ?></strong></td>
                                <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                <td><strong>$<?php echo number_format($order['total'], 2); ?></strong></td>
                                <td><span class="badge badge-<?php echo getStatusColor($order['status']); ?>"><?php echo ucfirst($order['status']); ?></span></td>
                                <td>
                                    <a href="../orders/view.php?id=<?php echo $order['id']; ?>" class="btn-icon">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.info-item { margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #eee; }
.info-item:last-child { border-bottom: none; }
.info-item small { display: block; color: #999; font-size: 12px; text-transform: uppercase; margin-bottom: 5px; }
</style>

<?php include __DIR__ . '/../includes/footer.php'; ?>
