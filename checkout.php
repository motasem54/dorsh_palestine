<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';
require_once 'includes/language.php';
require_once 'includes/cart.php';

if (!isLoggedIn()) {
    $_SESSION['redirect_after_login'] = 'checkout.php';
    header('Location: login.php');
    exit;
}

$page_title = t('checkout');
$cart_items = getCartItems();
$cart_total = getCartTotal();

if (empty($cart_items)) {
    header('Location: cart.php');
    exit;
}

include 'includes/header.php';
?>

<div class="checkout-page">
    <div class="container">
        <h1 class="page-title"><?php echo t('checkout'); ?></h1>
        
        <form method="POST" action="api/checkout.php" class="checkout-form">
            <div class="checkout-layout">
                <div class="checkout-main">
                    <!-- Shipping Info -->
                    <div class="checkout-section">
                        <h2><?php echo t('shipping_information'); ?></h2>
                        <div class="form-grid">
                            <div class="form-group">
                                <label><?php echo t('first_name'); ?> *</label>
                                <input type="text" name="first_name" required class="form-control" value="<?php echo h($_SESSION['user']['first_name'] ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label><?php echo t('last_name'); ?> *</label>
                                <input type="text" name="last_name" required class="form-control" value="<?php echo h($_SESSION['user']['last_name'] ?? ''); ?>">
                            </div>
                            <div class="form-group full-width">
                                <label><?php echo t('email'); ?> *</label>
                                <input type="email" name="email" required class="form-control" value="<?php echo h($_SESSION['user']['email'] ?? ''); ?>">
                            </div>
                            <div class="form-group full-width">
                                <label><?php echo t('phone'); ?> *</label>
                                <input type="tel" name="phone" required class="form-control">
                            </div>
                            <div class="form-group full-width">
                                <label><?php echo t('address'); ?> *</label>
                                <input type="text" name="address" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label><?php echo t('city'); ?> *</label>
                                <input type="text" name="city" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label><?php echo t('postal_code'); ?></label>
                                <input type="text" name="postal_code" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Method -->
                    <div class="checkout-section">
                        <h2><?php echo t('payment_method'); ?></h2>
                        <div class="payment-methods">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cod" checked>
                                <div class="option-content">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <span><?php echo t('cash_on_delivery'); ?></span>
                                </div>
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="card">
                                <div class="option-content">
                                    <i class="fas fa-credit-card"></i>
                                    <span><?php echo t('credit_card'); ?></span>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Notes -->
                    <div class="checkout-section">
                        <h2><?php echo t('order_notes'); ?> (<?php echo t('optional'); ?>)</h2>
                        <textarea name="notes" rows="4" class="form-control" placeholder="<?php echo t('special_instructions'); ?>"></textarea>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="checkout-sidebar">
                    <div class="order-summary">
                        <h3><?php echo t('order_summary'); ?></h3>
                        <div class="order-items">
                            <?php foreach ($cart_items as $item): ?>
                            <div class="order-item">
                                <img src="<?php echo $item['main_image'] ?: 'images/products/default.jpg'; ?>" alt="<?php echo h(translate($item, 'name')); ?>">
                                <div class="item-info">
                                    <h4><?php echo h(translate($item, 'name')); ?></h4>
                                    <p>Qty: <?php echo $item['quantity']; ?></p>
                                </div>
                                <span class="item-price">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="summary-totals">
                            <div class="total-row">
                                <span><?php echo t('subtotal'); ?></span>
                                <strong>$<?php echo number_format($cart_total, 2); ?></strong>
                            </div>
                            <div class="total-row">
                                <span><?php echo t('shipping'); ?></span>
                                <strong><?php echo t('free'); ?></strong>
                            </div>
                            <div class="total-row final">
                                <span><?php echo t('total'); ?></span>
                                <strong>$<?php echo number_format($cart_total, 2); ?></strong>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg"><?php echo t('place_order'); ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.checkout-page { padding: 40px 0; }
.checkout-layout { display: grid; grid-template-columns: 1fr 400px; gap: 30px; }
.checkout-section { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 20px; }
.checkout-section h2 { font-size: 20px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #eee; }
.form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; }
.full-width { grid-column: span 2; }
.payment-methods { display: flex; flex-direction: column; gap: 15px; }
.payment-option { display: block; padding: 15px; border: 2px solid #ddd; border-radius: 8px; cursor: pointer; transition: all 0.3s; }
.payment-option:has(input:checked) { border-color: #2563eb; background: #eff6ff; }
.payment-option input { display: none; }
.option-content { display: flex; align-items: center; gap: 15px; font-weight: 600; }
.option-content i { font-size: 24px; color: #2563eb; }
.order-summary { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); position: sticky; top: 100px; }
.order-summary h3 { font-size: 20px; font-weight: 600; margin-bottom: 20px; }
.order-items { max-height: 300px; overflow-y: auto; margin-bottom: 20px; }
.order-item { display: grid; grid-template-columns: 60px 1fr auto; gap: 15px; padding: 15px 0; border-bottom: 1px solid #eee; }
.order-item img { width: 60px; height: 60px; object-fit: cover; border-radius: 6px; }
.item-info h4 { font-size: 14px; font-weight: 600; margin-bottom: 5px; }
.item-info p { font-size: 13px; color: #999; }
.item-price { font-weight: 600; color: #2563eb; }
.summary-totals { padding-top: 15px; margin-bottom: 20px; }
.total-row { display: flex; justify-content: space-between; margin-bottom: 10px; }
.total-row.final { padding-top: 15px; margin-top: 15px; border-top: 2px solid #eee; font-size: 20px; }
.order-summary .btn { width: 100%; }
@media (max-width: 768px) { .checkout-layout { grid-template-columns: 1fr; } .form-grid { grid-template-columns: 1fr; } .full-width { grid-column: span 1; } }
</style>

<?php include 'includes/footer.php'; ?>
