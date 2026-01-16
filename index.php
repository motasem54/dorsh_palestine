<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';
require_once 'includes/language.php';

$page_title = 'Home';

// Get featured products
$featured_products = $db->query(
    "SELECT * FROM products WHERE featured = 1 AND status = 'active' ORDER BY created_at DESC LIMIT 8"
)->fetchAll();

// Get new arrivals
$new_arrivals = $db->query(
    "SELECT * FROM products WHERE status = 'active' ORDER BY created_at DESC LIMIT 8"
)->fetchAll();

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-content">
        <div class="container">
            <div class="hero-text">
                <h1 class="hero-title"><?php echo t('welcome_to_dorsh'); ?></h1>
                <p class="hero-subtitle"><?php echo t('discover_authentic_products'); ?></p>
                <div class="hero-buttons">
                    <a href="shop.php" class="btn btn-primary btn-lg"><?php echo t('shop_now'); ?></a>
                    <a href="about.php" class="btn btn-outline btn-lg"><?php echo t('learn_more'); ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-image">
        <img src="images/hero-bg.jpg" alt="Hero">
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="features-grid">
            <div class="feature-item">
                <i class="fas fa-shipping-fast"></i>
                <h3><?php echo t('free_shipping'); ?></h3>
                <p><?php echo t('free_shipping_desc'); ?></p>
            </div>
            <div class="feature-item">
                <i class="fas fa-shield-alt"></i>
                <h3><?php echo t('secure_payment'); ?></h3>
                <p><?php echo t('secure_payment_desc'); ?></p>
            </div>
            <div class="feature-item">
                <i class="fas fa-undo-alt"></i>
                <h3><?php echo t('easy_returns'); ?></h3>
                <p><?php echo t('easy_returns_desc'); ?></p>
            </div>
            <div class="feature-item">
                <i class="fas fa-headset"></i>
                <h3><?php echo t('247_support'); ?></h3>
                <p><?php echo t('247_support_desc'); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<?php if (!empty($featured_products)): ?>
<section class="products-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><?php echo t('featured_products'); ?></h2>
            <a href="shop.php" class="view-all"><?php echo t('view_all'); ?> <i class="fas fa-arrow-<?php echo isRTL() ? 'left' : 'right'; ?>"></i></a>
        </div>
        <div class="products-grid">
            <?php foreach ($featured_products as $product): ?>
            <div class="product-card">
                <a href="product.php?id=<?php echo $product['id']; ?>" class="product-image">
                    <img src="<?php echo $product['main_image'] ?: 'images/products/default.jpg'; ?>" alt="<?php echo h(translate($product, 'name')); ?>">
                    <?php if ($product['compare_price'] && $product['compare_price'] > $product['price']): ?>
                    <span class="product-badge">-<?php echo round((($product['compare_price'] - $product['price']) / $product['compare_price']) * 100); ?>%</span>
                    <?php endif; ?>
                </a>
                <div class="product-info">
                    <h3 class="product-name">
                        <a href="product.php?id=<?php echo $product['id']; ?>"><?php echo h(translate($product, 'name')); ?></a>
                    </h3>
                    <div class="product-price">
                        <span class="price">$<?php echo number_format($product['price'], 2); ?></span>
                        <?php if ($product['compare_price'] && $product['compare_price'] > $product['price']): ?>
                        <span class="compare-price">$<?php echo number_format($product['compare_price'], 2); ?></span>
                        <?php endif; ?>
                    </div>
                    <button class="btn btn-primary btn-sm add-to-cart" data-product-id="<?php echo $product['id']; ?>">
                        <i class="fas fa-shopping-cart"></i> <?php echo t('add_to_cart'); ?>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- New Arrivals -->
<?php if (!empty($new_arrivals)): ?>
<section class="products-section" style="background: #f8f9fa;">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><?php echo t('new_arrivals'); ?></h2>
            <a href="shop.php?sort=newest" class="view-all"><?php echo t('view_all'); ?> <i class="fas fa-arrow-<?php echo isRTL() ? 'left' : 'right'; ?>"></i></a>
        </div>
        <div class="products-grid">
            <?php foreach ($new_arrivals as $product): ?>
            <div class="product-card">
                <a href="product.php?id=<?php echo $product['id']; ?>" class="product-image">
                    <img src="<?php echo $product['main_image'] ?: 'images/products/default.jpg'; ?>" alt="<?php echo h(translate($product, 'name')); ?>">
                </a>
                <div class="product-info">
                    <h3 class="product-name">
                        <a href="product.php?id=<?php echo $product['id']; ?>"><?php echo h(translate($product, 'name')); ?></a>
                    </h3>
                    <div class="product-price">
                        <span class="price">$<?php echo number_format($product['price'], 2); ?></span>
                    </div>
                    <button class="btn btn-primary btn-sm add-to-cart" data-product-id="<?php echo $product['id']; ?>">
                        <i class="fas fa-shopping-cart"></i> <?php echo t('add_to_cart'); ?>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<style>
.hero-section {
    position: relative;
    height: 600px;
    display: flex;
    align-items: center;
    overflow: hidden;
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
}

.hero-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0.2;
}

.hero-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.hero-content {
    position: relative;
    z-index: 2;
    width: 100%;
}

.hero-text {
    max-width: 600px;
    color: white;
}

.hero-title {
    font-size: 56px;
    font-weight: 700;
    margin-bottom: 20px;
    line-height: 1.2;
}

.hero-subtitle {
    font-size: 20px;
    margin-bottom: 30px;
    opacity: 0.9;
}

.hero-buttons {
    display: flex;
    gap: 15px;
}

.btn-lg {
    padding: 15px 35px;
    font-size: 16px;
}

.features-section {
    padding: 60px 0;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
}

.feature-item {
    text-align: center;
}

.feature-item i {
    font-size: 48px;
    color: #2563eb;
    margin-bottom: 15px;
}

.feature-item h3 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 10px;
}

.feature-item p {
    color: #666;
    font-size: 14px;
}

.products-section {
    padding: 60px 0;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
}

.section-title {
    font-size: 32px;
    font-weight: 700;
}

.view-all {
    color: #2563eb;
    font-weight: 600;
    transition: all 0.3s;
}

.view-all:hover {
    gap: 10px;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
}

.product-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: all 0.3s;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.product-image {
    position: relative;
    display: block;
    overflow: hidden;
    aspect-ratio: 1;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.product-card:hover .product-image img {
    transform: scale(1.1);
}

.product-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #ef4444;
    color: white;
    padding: 5px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
}

.product-info {
    padding: 20px;
}

.product-name {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 10px;
}

.product-name a {
    color: #333;
}

.product-price {
    margin-bottom: 15px;
}

.price {
    font-size: 20px;
    font-weight: 700;
    color: #2563eb;
}

.compare-price {
    font-size: 16px;
    color: #999;
    text-decoration: line-through;
    margin-left: 10px;
}

.btn-sm {
    padding: 8px 16px;
    font-size: 14px;
    width: 100%;
}

@media (max-width: 1024px) {
    .products-grid { grid-template-columns: repeat(3, 1fr); }
    .features-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 768px) {
    .products-grid { grid-template-columns: repeat(2, 1fr); }
    .features-grid { grid-template-columns: 1fr; }
    .hero-title { font-size: 36px; }
    .hero-buttons { flex-direction: column; }
}
</style>

<?php include 'includes/footer.php'; ?>
