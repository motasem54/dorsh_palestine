<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdminLogin();

$order_id = $_GET['id'] ?? 0;

// Get order details
$order = $db->query(
    "SELECT o.*, CONCAT(u.first_name, ' ', u.last_name) as customer_name, u.email, u.phone as user_phone
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.id
    WHERE o.id = ?",
    [$order_id]
)->fetch();

if (!$order) {
    header('Location: index.php');
    exit;
}

// Get order items
$items = $db->query(
    "SELECT oi.*, p.main_image
    FROM order_items oi
    LEFT JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?",
    [$order_id]
)->fetchAll();

$page_title = 'Order #' . $order['order_number'];
$current_page = 'orders';

include __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-shopping-cart"></i> Order #<?php echo $order['order_number']; ?>
    </h1>
    <div class="page-actions">
        <a href="index.php" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
        <a href="invoice.php?id=<?php echo $order['id']; ?>" class="btn btn-primary" target="_blank">
            <i class="fas fa-file-invoice"></i> Print Invoice
        </a>
    </div>
</div>

<div class="dashboard-row">
    <!-- Order Details -->
    <div class="dashboard-col-8">
        <!-- Status Timeline -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-clock"></i> Order Status</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="update-status.php" style="display: flex; gap: 15px; align-items: center;">
                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                    <select name="status" class="form-control" style="max-width: 200px;">
                        <option value="pending" <?php echo $order['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="processing" <?php echo $order['status'] === 'processing' ? 'selected' : ''; ?>>Processing</option>
                        <option value="shipped" <?php echo $order['status'] === 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                        <option value="delivered" <?php echo $order['status'] === 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                        <option value="completed" <?php echo $order['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                        <option value="cancelled" <?php echo $order['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                    <span class="badge badge-<?php echo getStatusColor($order['status']); ?>" style="font-size: 14px; padding: 8px 15px;">
                        Current: <?php echo ucfirst($order['status']); ?>
                    </span>
                </form>
            </div>
        </div>
        
        <!-- Order Items -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-box"></i> Order Items</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                            <tr>
                                <td>
                                    <div class="product-mini">
                                        <img src="<?php echo $item['main_image'] ?: '/images/products/default.jpg'; ?>" alt="<?php echo h($item['product_name']); ?>">
                                        <strong><?php echo h($item['product_name']); ?></strong>
                                    </div>
                                </td>
                                <td><code><?php echo h($item['sku']); ?></code></td>
                                <td>$<?php echo number_format($item['price'], 2); ?></td>
                                <td><span class="badge badge-info"><?php echo $item['quantity']; ?></span></td>
                                <td><strong>$<?php echo number_format($item['total'], 2); ?></strong></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Order Summary Sidebar -->
    <div class="dashboard-col-4">
        <!-- Customer Info -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user"></i> Customer</h3>
            </div>
            <div class="card-body">
                <div class="info-group">
                    <strong><?php echo h($order['customer_name']); ?></strong>
                    <p><?php echo h($order['email']); ?></p>
                    <p><?php echo h($order['phone']); ?></p>
                </div>
                <a href="../customers/view.php?id=<?php echo $order['user_id']; ?>" class="btn btn-outline btn-sm" style="width: 100%;">
                    View Customer Details
                </a>
            </div>
        </div>
        
        <!-- Shipping Address -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-map-marker-alt"></i> Shipping</h3>
            </div>
            <div class="card-body">
                <div class="info-group">
                    <p><?php echo h($order['address']); ?></p>
                    <p><?php echo h($order['city']); ?> <?php echo h($order['postal_code']); ?></p>
                </div>
            </div>
        </div>
        
        <!-- Order Summary -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-calculator"></i> Summary</h3>
            </div>
            <div class="card-body">
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <strong>$<?php echo number_format($order['subtotal'], 2); ?></strong>
                </div>
                <div class="summary-row">
                    <span>Shipping:</span>
                    <strong>$<?php echo number_format($order['shipping'], 2); ?></strong>
                </div>
                <div class="summary-row" style="border-top: 2px solid #eee; padding-top: 10px; margin-top: 10px; font-size: 18px;">
                    <span>Total:</span>
                    <strong style="color: var(--primary-blue);">$<?php echo number_format($order['total'], 2); ?></strong>
                </div>
                <div class="summary-row" style="margin-top: 15px;">
                    <span>Payment Method:</span>
                    <span class="badge badge-info"><?php echo strtoupper($order['payment_method']); ?></span>
                </div>
            </div>
        </div>
        
        <!-- Order Info -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle"></i> Details</h3>
            </div>
            <div class="card-body">
                <div class="info-item">
                    <small>Order Date:</small>
                    <strong><?php echo date('M d, Y H:i', strtotime($order['created_at'])); ?></strong>
                </div>
                <?php if ($order['notes']): ?>
                <div class="info-item" style="margin-top: 15px;">
                    <small>Order Notes:</small>
                    <p style="background: #f5f5f5; padding: 10px; border-radius: 6px; margin-top: 5px;">
                        <?php echo nl2br(h($order['notes'])); ?>
                    </p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.summary-row { display: flex; justify-content: space-between; margin-bottom: 10px; }
.info-group { margin-bottom: 15px; }
.info-group p { margin: 5px 0; color: #666; }
.info-item { margin-bottom: 10px; }
.info-item small { color: #999; font-size: 12px; text-transform: uppercase; }
</style>

<?php include __DIR__ . '/../includes/footer.php'; ?>
