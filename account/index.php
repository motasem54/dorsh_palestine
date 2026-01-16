<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';
require_once '../includes/language.php';

if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit;
}

$page_title = t('my_account');
$user = $_SESSION['user'];

// Get recent orders
$recent_orders = $db->query(
    "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT 5",
    [$user['id']]
)->fetchAll();

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
                    <a href="index.php" class="active"><i class="fas fa-home"></i> <?php echo t('dashboard'); ?></a>
                    <a href="orders.php"><i class="fas fa-shopping-bag"></i> <?php echo t('my_orders'); ?></a>
                    <a href="profile.php"><i class="fas fa-user"></i> <?php echo t('profile'); ?></a>
                    <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> <?php echo t('logout'); ?></a>
                </nav>
            </aside>
            
            <!-- Content -->
            <div class="account-content">
                <h1><?php echo t('welcome_back'); ?>, <?php echo h($user['first_name']); ?>!</h1>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <i class="fas fa-shopping-bag"></i>
                        <h3><?php echo count($recent_orders); ?></h3>
                        <p><?php echo t('total_orders'); ?></p>
                    </div>
                </div>
                
                <?php if (!empty($recent_orders)): ?>
                <div class="section">
                    <h2><?php echo t('recent_orders'); ?></h2>
                    <div class="orders-list">
                        <?php foreach ($recent_orders as $order): ?>
                        <div class="order-card">
                            <div class="order-header">
                                <strong>#<?php echo $order['order_number']; ?></strong>
                                <span class="badge badge-<?php echo getStatusColor($order['status']); ?>">
                                    <?php echo ucfirst($order['status']); ?>
                                </span>
                            </div>
                            <div class="order-info">
                                <p><?php echo date('M d, Y', strtotime($order['created_at'])); ?></p>
                                <strong>$<?php echo number_format($order['total'], 2); ?></strong>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.account-page { padding: 40px 0; }
.account-layout { display: grid; grid-template-columns: 280px 1fr; gap: 30px; }
.account-sidebar { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); height: fit-content; }
.user-info { text-align: center; margin-bottom: 30px; padding-bottom: 25px; border-bottom: 2px solid #eee; }
.user-avatar { width: 80px; height: 80px; margin: 0 auto 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 700; }
.user-info h3 { font-size: 18px; font-weight: 600; margin-bottom: 5px; }
.user-info p { font-size: 14px; color: #666; }
.account-nav a { display: flex; align-items: center; gap: 12px; padding: 12px 15px; margin-bottom: 5px; border-radius: 8px; color: #666; transition: all 0.3s; }
.account-nav a:hover, .account-nav a.active { background: #eff6ff; color: #2563eb; font-weight: 600; }
.account-content { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
.account-content h1 { font-size: 28px; font-weight: 700; margin-bottom: 25px; }
.stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
.stat-card { text-align: center; padding: 25px; background: #f8f9fa; border-radius: 10px; }
.stat-card i { font-size: 36px; color: #2563eb; margin-bottom: 10px; }
.stat-card h3 { font-size: 32px; font-weight: 700; margin-bottom: 5px; }
.section { margin-top: 30px; }
.section h2 { font-size: 20px; font-weight: 600; margin-bottom: 20px; }
.orders-list { display: flex; flex-direction: column; gap: 15px; }
.order-card { padding: 20px; background: #f8f9fa; border-radius: 8px; }
.order-header { display: flex; justify-content: space-between; margin-bottom: 10px; }
.order-info { display: flex; justify-content: space-between; color: #666; }
@media (max-width: 768px) { .account-layout { grid-template-columns: 1fr; } }
</style>

<?php include '../includes/footer.php'; ?>
