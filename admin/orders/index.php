<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdminLogin();

$page_title = 'Orders';
$current_page = 'orders';

// Filters
$status_filter = $_GET['status'] ?? '';
$search = $_GET['search'] ?? '';

// Build query
$where = [];
$params = [];

if ($status_filter) {
    $where[] = "o.status = ?";
    $params[] = $status_filter;
}

if ($search) {
    $where[] = "(o.order_number LIKE ? OR CONCAT(u.first_name, ' ', u.last_name) LIKE ?)";
    $search_term = "%{$search}%";
    $params[] = $search_term;
    $params[] = $search_term;
}

$where_clause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Get orders
$orders = $db->query(
    "SELECT o.*, CONCAT(u.first_name, ' ', u.last_name) as customer_name, u.email
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.id
    {$where_clause}
    ORDER BY o.created_at DESC
    LIMIT 50",
    $params
)->fetchAll();

include __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
    <h1 class="page-title"><i class="fas fa-shopping-cart"></i> Orders</h1>
</div>

<!-- Filters -->
<div class="dashboard-card" style="margin-bottom: 20px;">
    <div class="card-body">
        <form method="GET" class="filters-form">
            <div class="filters-grid">
                <div class="filter-item">
                    <input type="text" name="search" class="form-control" placeholder="Search orders..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="filter-item">
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="pending" <?php echo $status_filter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="processing" <?php echo $status_filter === 'processing' ? 'selected' : ''; ?>>Processing</option>
                        <option value="shipped" <?php echo $status_filter === 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                        <option value="delivered" <?php echo $status_filter === 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                        <option value="completed" <?php echo $status_filter === 'completed' ? 'selected' : ''; ?>>Completed</option>
                        <option value="cancelled" <?php echo $status_filter === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                </div>
                <div class="filter-item">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                    <a href="index.php" class="btn btn-outline"><i class="fas fa-times"></i> Clear</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Orders Table -->
<div class="dashboard-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="6" class="text-center" style="padding: 40px;">
                            <i class="fas fa-shopping-cart" style="font-size: 48px; color: #ccc; margin-bottom: 10px;"></i>
                            <p style="color: #999;">No orders found</p>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><strong><a href="view.php?id=<?php echo $order['id']; ?>">#<?php echo $order['order_number']; ?></a></strong></td>
                        <td>
                            <?php echo htmlspecialchars($order['customer_name']); ?><br>
                            <small style="color: #999;"><?php echo htmlspecialchars($order['email']); ?></small>
                        </td>
                        <td><?php echo date('M d, Y H:i', strtotime($order['created_at'])); ?></td>
                        <td><strong>$<?php echo number_format($order['total'], 2); ?></strong></td>
                        <td><span class="badge badge-<?php echo getStatusColor($order['status']); ?>"><?php echo ucfirst($order['status']); ?></span></td>
                        <td>
                            <a href="view.php?id=<?php echo $order['id']; ?>" class="btn-icon" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="invoice.php?id=<?php echo $order['id']; ?>" class="btn-icon" title="Invoice" target="_blank">
                                <i class="fas fa-file-invoice"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
