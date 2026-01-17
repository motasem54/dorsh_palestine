<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';
require_once '../includes/language.php';

if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit;
}

$page_title = t('my_orders');
$user = $_SESSION['user'];

// Get user orders
$orders = $db->query(
    "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC",
    [$user['id']]
)->fetchAll();

// Get specific order if requested
$selected_order = null;
$order_items = [];
if (isset($_GET['order'])) {
    $order_id = (int)$_GET['order'];
    $selected_order = $db->query(
        "SELECT * FROM orders WHERE id = ? AND user_id = ?",
        [$order_id, $user['id']]
    )->fetch();
    
    if ($selected_order) {
        $order_items = $db->query(
            "SELECT oi.*, p.main_image
            FROM order_items oi
            LEFT JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = ?",
            [$order_id]
        )->fetchAll();
    }
}

include '../includes/header.php';
?>

<div class="account-page">
    <div class="container">
        <div class="account-layout">
            <!-- Sidebar -->
            <aside class="account-sidebar">
                <div class="user-info">
                    <div class="user-avatar">
                        <?php echo strtoupper(substr($user['first_name'], 0, 1)); ?>
                    </div>
                    <h3><?php echo h($user['first_name'] . ' ' . $user['last_name']); ?></h3>
                    <p><?php echo h($user['email']); ?></p>
                </div>
                <nav class="account-nav">
                    <a href="index.php"><i class="fas fa-home"></i> <?php echo t('dashboard'); ?></a>
                    <a href="orders.php" class="active"><i class="fas fa-shopping-bag"></i> <?php echo t('my_orders'); ?></a>
                    <a href="profile.php"><i class="fas fa-user"></i> <?php echo t('profile'); ?></a>
                    <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> <?php echo t('logout'); ?></a>
                </nav>
            </aside>
            
            <!-- Content -->
            <div class="account-content">
                <?php if ($selected_order): ?>
                <!-- Order Details View -->
                <div class="order-details-view">
                    <div class="order-header">
                        <div>
                            <h1><?php echo t('order'); ?> #<?php echo $selected_order['order_number']; ?></h1>
                            <p><?php echo date('F d, Y H:i', strtotime($selected_order['created_at'])); ?></p>
                        </div>
                        <div>
                            <a href="orders.php" class="btn btn-outline">
                                <i class="fas fa-arrow-left"></i> <?php echo t('back_to_orders'); ?>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Order Status -->
                    <div class="order-status-card">
                        <div class="status-timeline">
                            <div class="status-step <?php echo in_array($selected_order['status'], ['pending', 'processing', 'shipped', 'delivered', 'completed']) ? 'active' : ''; ?>">
                                <div class="step-icon"><i class="fas fa-check"></i></div>
                                <div class="step-label"><?php echo t('order_placed'); ?></div>
                            </div>
                            <div class="status-step <?php echo in_array($selected_order['status'], ['processing', 'shipped', 'delivered', 'completed']) ? 'active' : ''; ?>">
                                <div class="step-icon"><i class="fas fa-box"></i></div>
                                <div class="step-label"><?php echo t('processing'); ?></div>
                            </div>
                            <div class="status-step <?php echo in_array($selected_order['status'], ['shipped', 'delivered', 'completed']) ? 'active' : ''; ?>">
                                <div class="step-icon"><i class="fas fa-truck"></i></div>
                                <div class="step-label"><?php echo t('shipped'); ?></div>
                            </div>
                            <div class="status-step <?php echo in_array($selected_order['status'], ['delivered', 'completed']) ? 'active' : ''; ?>">
                                <div class="step-icon"><i class="fas fa-check-circle"></i></div>
                                <div class="step-label"><?php echo t('delivered'); ?></div>
                            </div>
                        </div>
                        <div class="current-status">
                            <span class="badge badge-<?php echo getStatusColor($selected_order['status']); ?>" style="font-size: 16px; padding: 10px 20px;">
                                <?php echo ucfirst($selected_order['status']); ?>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Order Items -->
                    <div class="order-items-section">
                        <h3><?php echo t('order_items'); ?></h3>
                        <?php foreach ($order_items as $item): ?>
                        <div class="order-item-card">
                            <img src="<?php echo $item['main_image'] ?: '/images/products/default.jpg'; ?>" alt="<?php echo h($item['product_name']); ?>">
                            <div class="item-details">
                                <h4><?php echo h($item['product_name']); ?></h4>
                                <p>SKU: <?php echo h($item['sku']); ?></p>
                                <p><?php echo t('quantity'); ?>: <?php echo $item['quantity']; ?></p>
                            </div>
                            <div class="item-price">
                                <strong>$<?php echo number_format($item['total'], 2); ?></strong>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Order Summary -->
                    <div class="order-summary-box">
                        <h3><?php echo t('order_summary'); ?></h3>
                        <div class="summary-row">
                            <span><?php echo t('subtotal'); ?>:</span>
                            <strong>$<?php echo number_format($selected_order['subtotal'], 2); ?></strong>
                        </div>
                        <div class="summary-row">
                            <span><?php echo t('shipping'); ?>:</span>
                            <strong>$<?php echo number_format($selected_order['shipping'], 2); ?></strong>
                        </div>
                        <div class="summary-row total">
                            <span><?php echo t('total'); ?>:</span>
                            <strong>$<?php echo number_format($selected_order['total'], 2); ?></strong>
                        </div>
                    </div>
                    
                    <!-- Shipping Address -->
                    <div class="shipping-info">
                        <h3><?php echo t('shipping_address'); ?></h3>
                        <p><?php echo h($selected_order['address']); ?></p>
                        <p><?php echo h($selected_order['city']); ?> <?php echo h($selected_order['postal_code']); ?></p>
                    </div>
                </div>
                <?php else: ?>
                <!-- Orders List -->
                <h1><?php echo t('my_orders'); ?></h1>
                
                <?php if (empty($orders)): ?>
                <div class="empty-state">
                    <i class="fas fa-shopping-bag"></i>
                    <h3><?php echo t('no_orders_yet'); ?></h3>
                    <p><?php echo t('start_shopping_message'); ?></p>
                    <a href="../shop.php" class="btn btn-primary"><?php echo t('shop_now'); ?></a>
                </div>
                <?php else: ?>
                <div class="orders-list">
                    <?php foreach ($orders as $order): ?>
                    <div class="order-card" onclick="window.location.href='orders.php?order=<?php echo $order['id']; ?>'" style="cursor: pointer;">
                        <div class="order-card-header">
                            <div>
                                <strong>#<?php echo $order['order_number']; ?></strong>
                                <span class="badge badge-<?php echo getStatusColor($order['status']); ?>">
                                    <?php echo ucfirst($order['status']); ?>
                                </span>
                            </div>
                            <div class="order-date">
                                <?php echo date('M d, Y', strtotime($order['created_at'])); ?>
                            </div>
                        </div>
                        <div class="order-card-body">
                            <div class="order-info">
                                <span><?php echo t('total'); ?>:</span>
                                <strong style="font-size: 18px; color: #2563eb;">$<?php echo number_format($order['total'], 2); ?></strong>
                            </div>
                            <div class="order-info">
                                <span><?php echo t('payment'); ?>:</span>
                                <span><?php echo strtoupper($order['payment_method']); ?></span>
                            </div>
                        </div>
                        <div class="order-card-footer">
                            <a href="orders.php?order=<?php echo $order['id']; ?>" class="btn btn-outline btn-sm">
                                <?php echo t('view_details'); ?>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.order-details-view { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
.order-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #eee; }
.order-status-card { background: #f8f9fa; padding: 30px; border-radius: 12px; margin-bottom: 30px; }
.status-timeline { display: flex; justify-content: space-between; margin-bottom: 20px; }
.status-step { flex: 1; text-align: center; position: relative; }
.status-step::after { content: ''; position: absolute; top: 20px; left: 50%; width: 100%; height: 2px; background: #ddd; z-index: 0; }
.status-step:last-child::after { display: none; }
.status-step.active .step-icon { background: #2563eb; color: white; }
.status-step.active::after { background: #2563eb; }
.step-icon { width: 40px; height: 40px; border-radius: 50%; background: #ddd; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; position: relative; z-index: 1; }
.step-label { font-size: 12px; color: #666; }
.current-status { text-align: center; margin-top: 20px; }
.order-items-section { margin-bottom: 30px; }
.order-items-section h3 { margin-bottom: 20px; }
.order-item-card { display: grid; grid-template-columns: 80px 1fr auto; gap: 20px; padding: 20px; background: #f8f9fa; border-radius: 8px; margin-bottom: 15px; }
.order-item-card img { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; }
.item-details h4 { font-size: 16px; margin-bottom: 5px; }
.item-details p { font-size: 13px; color: #666; margin: 2px 0; }
.item-price { text-align: right; font-size: 18px; color: #2563eb; }
.order-summary-box { background: #f8f9fa; padding: 25px; border-radius: 8px; margin-bottom: 20px; }
.order-summary-box h3 { margin-bottom: 20px; }
.summary-row { display: flex; justify-content: space-between; margin-bottom: 12px; }
.summary-row.total { border-top: 2px solid #ddd; padding-top: 15px; margin-top: 15px; font-size: 20px; color: #2563eb; }
.shipping-info { background: #f8f9fa; padding: 20px; border-radius: 8px; }
.shipping-info h3 { margin-bottom: 10px; }
.empty-state { text-align: center; padding: 80px 20px; }
.empty-state i { font-size: 64px; color: #ddd; margin-bottom: 20px; }
.empty-state h3 { font-size: 24px; margin-bottom: 10px; }
.orders-list { display: grid; gap: 20px; }
.order-card { background: white; border: 1px solid #eee; border-radius: 12px; padding: 20px; transition: all 0.3s; }
.order-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-color: #2563eb; }
.order-card-header { display: flex; justify-content: space-between; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #eee; }
.order-card-body { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px; }
.order-info { display: flex; flex-direction: column; gap: 5px; }
.order-info span:first-child { color: #999; font-size: 13px; }
</style>

<?php include '../includes/footer.php'; ?>
