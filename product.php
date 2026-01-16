<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';
require_once 'includes/language.php';

$product_id = $_GET['id'] ?? 0;

// Get product
$product = $db->query(
    "SELECT p.*, c.name_en as category_name 
    FROM products p 
    LEFT JOIN categories c ON p.category_id = c.id 
    WHERE p.id = ? AND p.status = 'active'",
    [$product_id]
)->fetch();

if (!$product) {
    header('Location: shop.php');
    exit;
}

$page_title = translate($product, 'name');

// Get related products
$related = $db->query(
    "SELECT * FROM products WHERE category_id = ? AND id != ? AND status = 'active' LIMIT 4",
    [$product['category_id'], $product_id]
)->fetchAll();

include 'includes/header.php';
?>

<div class="product-page">
    <div class="container">
        <div class="product-layout">
            <!-- Product Images -->
            <div class="product-images">
                <div class="main-image">
                    <?php if ($product['model_3d']): ?>
                    <div id="3d-viewer" class="viewer-3d" data-model="<?php echo $product['model_3d']; ?>">
                        <canvas id="canvas3d"></canvas>
                        <div class="viewer-controls">
                            <button onclick="toggle3DView()" class="btn btn-sm">
                                <i class="fas fa-cube"></i> <?php echo t('view_3d'); ?>
                            </button>
                        </div>
                    </div>
                    <?php endif; ?>
                    <img src="<?php echo $product['main_image'] ?: 'images/products/default.jpg'; ?>" alt="<?php echo h(translate($product, 'name')); ?>" id="mainImage">
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="product-details">
                <h1 class="product-title"><?php echo h(translate($product, 'name')); ?></h1>
                
                <div class="product-meta">
                    <span class="sku">SKU: <?php echo $product['sku']; ?></span>
                    <span class="category"><?php echo t('category'); ?>: <a href="shop.php?category=<?php echo $product['category_id']; ?>"><?php echo h($product['category_name']); ?></a></span>
                </div>
                
                <div class="product-price-section">
                    <div class="price-wrapper">
                        <span class="current-price">$<?php echo number_format($product['price'], 2); ?></span>
                        <?php if ($product['compare_price'] && $product['compare_price'] > $product['price']): ?>
                        <span class="old-price">$<?php echo number_format($product['compare_price'], 2); ?></span>
                        <span class="discount-badge">-<?php echo round((($product['compare_price'] - $product['price']) / $product['compare_price']) * 100); ?>%</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="stock-info">
                        <?php if ($product['stock_quantity'] > 0): ?>
                        <span class="in-stock"><i class="fas fa-check-circle"></i> <?php echo t('in_stock'); ?> (<?php echo $product['stock_quantity']; ?>)</span>
                        <?php else: ?>
                        <span class="out-of-stock"><i class="fas fa-times-circle"></i> <?php echo t('out_of_stock'); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="product-description">
                    <h3><?php echo t('description'); ?></h3>
                    <p><?php echo nl2br(h(translate($product, 'description'))); ?></p>
                </div>
                
                <?php if ($product['stock_quantity'] > 0): ?>
                <div class="product-actions">
                    <div class="quantity-selector">
                        <button onclick="decreaseQty()" class="qty-btn">-</button>
                        <input type="number" id="quantity" value="1" min="1" max="<?php echo $product['stock_quantity']; ?>" readonly>
                        <button onclick="increaseQty()" class="qty-btn">+</button>
                    </div>
                    <button class="btn btn-primary btn-lg add-to-cart" data-product-id="<?php echo $product['id']; ?>">
                        <i class="fas fa-shopping-cart"></i> <?php echo t('add_to_cart'); ?>
                    </button>
                </div>
                <?php endif; ?>
                
                <div class="product-features">
                    <div class="feature"><i class="fas fa-shipping-fast"></i> <?php echo t('free_shipping'); ?></div>
                    <div class="feature"><i class="fas fa-undo-alt"></i> <?php echo t('30_day_return'); ?></div>
                    <div class="feature"><i class="fas fa-shield-alt"></i> <?php echo t('secure_checkout'); ?></div>
                </div>
            </div>
        </div>
        
        <!-- Related Products -->
        <?php if (!empty($related)): ?>
        <section class="related-products">
            <h2><?php echo t('related_products'); ?></h2>
            <div class="products-grid">
                <?php foreach ($related as $rel): ?>
                <div class="product-card">
                    <a href="product.php?id=<?php echo $rel['id']; ?>" class="product-image">
                        <img src="<?php echo $rel['main_image'] ?: 'images/products/default.jpg'; ?>" alt="<?php echo h(translate($rel, 'name')); ?>">
                    </a>
                    <div class="product-info">
                        <h3 class="product-name"><a href="product.php?id=<?php echo $rel['id']; ?>"><?php echo h(translate($rel, 'name')); ?></a></h3>
                        <div class="product-price"><span class="price">$<?php echo number_format($rel['price'], 2); ?></span></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </div>
</div>

<style>
.product-page { padding: 40px 0; }
.product-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; margin-bottom: 60px; }
.product-images { position: sticky; top: 100px; }
.main-image { position: relative; border-radius: 12px; overflow: hidden; background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
.main-image img { width: 100%; display: block; }
.viewer-3d { position: relative; width: 100%; aspect-ratio: 1; }
#canvas3d { width: 100%; height: 100%; }
.viewer-controls { position: absolute; bottom: 20px; left: 20px; }
.product-title { font-size: 32px; font-weight: 700; margin-bottom: 15px; }
.product-meta { display: flex; gap: 20px; margin-bottom: 20px; color: #666; font-size: 14px; }
.product-price-section { padding: 25px 0; border-top: 1px solid #eee; border-bottom: 1px solid #eee; margin-bottom: 25px; }
.price-wrapper { display: flex; align-items: center; gap: 15px; margin-bottom: 15px; }
.current-price { font-size: 36px; font-weight: 700; color: #2563eb; }
.old-price { font-size: 24px; color: #999; text-decoration: line-through; }
.discount-badge { background: #ef4444; color: white; padding: 5px 12px; border-radius: 6px; font-size: 14px; font-weight: 600; }
.stock-info { font-size: 16px; }
.in-stock { color: #10b981; font-weight: 600; }
.out-of-stock { color: #ef4444; font-weight: 600; }
.product-description { margin-bottom: 30px; }
.product-description h3 { font-size: 18px; font-weight: 600; margin-bottom: 10px; }
.product-actions { display: flex; gap: 15px; margin-bottom: 30px; }
.quantity-selector { display: flex; border: 2px solid #ddd; border-radius: 8px; overflow: hidden; }
.qty-btn { width: 45px; height: 50px; border: none; background: #f5f5f5; cursor: pointer; font-size: 18px; transition: all 0.3s; }
.qty-btn:hover { background: #2563eb; color: white; }
#quantity { width: 70px; text-align: center; border: none; font-size: 16px; font-weight: 600; }
.btn-lg { padding: 15px 40px; font-size: 16px; flex: 1; }
.product-features { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; padding: 20px; background: #f8f9fa; border-radius: 8px; }
.feature { display: flex; align-items: center; gap: 10px; font-size: 14px; }
.feature i { color: #2563eb; font-size: 18px; }
.related-products { margin-top: 60px; }
.related-products h2 { font-size: 28px; font-weight: 700; margin-bottom: 30px; }
@media (max-width: 768px) {
    .product-layout { grid-template-columns: 1fr; gap: 30px; }
    .product-images { position: static; }
    .product-features { grid-template-columns: 1fr; }
}
</style>

<script>
let quantity = 1;
function increaseQty() {
    const max = parseInt(document.getElementById('quantity').max);
    if (quantity < max) {
        quantity++;
        document.getElementById('quantity').value = quantity;
    }
}
function decreaseQty() {
    if (quantity > 1) {
        quantity--;
        document.getElementById('quantity').value = quantity;
    }
}
</script>

<?php include 'includes/footer.php'; ?>
