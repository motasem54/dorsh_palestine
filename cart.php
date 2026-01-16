<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';
require_once 'includes/language.php';
require_once 'includes/cart.php';

$page_title = t('shopping_cart');
$cart_items = getCartItems();
$cart_total = getCartTotal();

include 'includes/header.php';
?>

<div class="cart-page">
    <div class="container">
        <h1 class="page-title"><?php echo t('shopping_cart'); ?></h1>
        
        <?php if (empty($cart_items)): ?>
        <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <h3><?php echo t('cart_empty'); ?></h3>
            <p><?php echo t('cart_empty_message'); ?></p>
            <a href="shop.php" class="btn btn-primary"><?php echo t('continue_shopping'); ?></a>
        </div>
        <?php else: ?>
        <div class="cart-layout">
            <div class="cart-items">
                <?php foreach ($cart_items as $item): ?>
                <div class="cart-item" data-id="<?php echo $item['id']; ?>">
                    <div class="item-image">
                        <img src="<?php echo $item['main_image'] ?: 'images/products/default.jpg'; ?>" alt="<?php echo h(translate($item, 'name')); ?>">
                    </div>
                    <div class="item-details">
                        <h3><a href="product.php?id=<?php echo $item['product_id']; ?>"><?php echo h(translate($item, 'name')); ?></a></h3>
                        <p class="item-sku">SKU: <?php echo $item['sku']; ?></p>
                    </div>
                    <div class="item-price">$<?php echo number_format($item['price'], 2); ?></div>
                    <div class="item-quantity">
                        <button onclick="updateCartQty(<?php echo $item['id']; ?>, -1)" class="qty-btn">-</button>
                        <input type="number" value="<?php echo $item['quantity']; ?>" min="1" readonly>
                        <button onclick="updateCartQty(<?php echo $item['id']; ?>, 1)" class="qty-btn">+</button>
                    </div>
                    <div class="item-total">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></div>
                    <button onclick="removeFromCart(<?php echo $item['id']; ?>)" class="remove-btn">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="cart-summary">
                <h3><?php echo t('order_summary'); ?></h3>
                <div class="summary-row">
                    <span><?php echo t('subtotal'); ?></span>
                    <strong>$<?php echo number_format($cart_total, 2); ?></strong>
                </div>
                <div class="summary-row">
                    <span><?php echo t('shipping'); ?></span>
                    <strong><?php echo t('free'); ?></strong>
                </div>
                <div class="summary-total">
                    <span><?php echo t('total'); ?></span>
                    <strong>$<?php echo number_format($cart_total, 2); ?></strong>
                </div>
                <a href="checkout.php" class="btn btn-primary btn-lg"><?php echo t('proceed_checkout'); ?></a>
                <a href="shop.php" class="btn btn-outline"><?php echo t('continue_shopping'); ?></a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.cart-page { padding: 40px 0; }
.page-title { font-size: 36px; font-weight: 700; margin-bottom: 30px; text-align: center; }
.empty-cart { text-align: center; padding: 80px 20px; }
.empty-cart i { font-size: 80px; color: #ddd; margin-bottom: 20px; }
.empty-cart h3 { font-size: 24px; margin-bottom: 10px; }
.empty-cart p { color: #666; margin-bottom: 20px; }
.cart-layout { display: grid; grid-template-columns: 1fr 400px; gap: 30px; }
.cart-items { display: flex; flex-direction: column; gap: 15px; }
.cart-item { display: grid; grid-template-columns: 100px 1fr 100px 150px 100px 50px; gap: 20px; align-items: center; padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
.item-image img { width: 100%; border-radius: 8px; }
.item-details h3 { font-size: 16px; font-weight: 600; margin-bottom: 5px; }
.item-sku { font-size: 13px; color: #999; }
.item-price, .item-total { font-size: 18px; font-weight: 600; color: #2563eb; }
.item-quantity { display: flex; border: 1px solid #ddd; border-radius: 6px; overflow: hidden; }
.item-quantity .qty-btn { width: 35px; height: 40px; border: none; background: #f5f5f5; cursor: pointer; }
.item-quantity input { width: 60px; text-align: center; border: none; font-weight: 600; }
.remove-btn { background: none; border: none; color: #ef4444; font-size: 18px; cursor: pointer; transition: all 0.3s; }
.remove-btn:hover { color: #dc2626; }
.cart-summary { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); height: fit-content; position: sticky; top: 100px; }
.cart-summary h3 { font-size: 20px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #eee; }
.summary-row { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 16px; }
.summary-total { display: flex; justify-content: space-between; padding-top: 15px; margin-top: 15px; border-top: 2px solid #eee; font-size: 20px; margin-bottom: 20px; }
.cart-summary .btn { width: 100%; margin-bottom: 10px; }
@media (max-width: 768px) {
    .cart-layout { grid-template-columns: 1fr; }
    .cart-item { grid-template-columns: 1fr; text-align: center; }
}
</style>

<?php include 'includes/footer.php'; ?>
