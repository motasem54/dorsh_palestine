<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';
require_once 'includes/language.php';

$page_title = t('shop');

// Filters
$category = $_GET['category'] ?? '';
$search = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? 'newest';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$page_num = $_GET['page'] ?? 1;
$per_page = 12;
$offset = ($page_num - 1) * $per_page;

// Build query
$where = ["p.status = 'active'"];
$params = [];

if ($category) {
    $where[] = "p.category_id = ?";
    $params[] = $category;
}

if ($search) {
    $where[] = "(p.name_en LIKE ? OR p.name_ar LIKE ?)";
    $search_term = "%{$search}%";
    $params[] = $search_term;
    $params[] = $search_term;
}

if ($min_price) {
    $where[] = "p.price >= ?";
    $params[] = $min_price;
}

if ($max_price) {
    $where[] = "p.price <= ?";
    $params[] = $max_price;
}

$where_clause = 'WHERE ' . implode(' AND ', $where);

// Sort
$order = match($sort) {
    'price_low' => 'p.price ASC',
    'price_high' => 'p.price DESC',
    'name' => 'p.name_en ASC',
    default => 'p.created_at DESC'
};

// Get products
$products = $db->query(
    "SELECT p.*, c.name_en as category_name 
    FROM products p 
    LEFT JOIN categories c ON p.category_id = c.id 
    {$where_clause}
    ORDER BY {$order}
    LIMIT {$per_page} OFFSET {$offset}",
    $params
)->fetchAll();

// Get total
$total = $db->query("SELECT COUNT(*) as count FROM products p {$where_clause}", $params)->fetch()['count'];
$total_pages = ceil($total / $per_page);

// Get categories
$categories = $db->query("SELECT * FROM categories WHERE status = 'active' ORDER BY name_en")->fetchAll();

include 'includes/header.php';
?>

<div class="shop-page">
    <div class="container">
        <div class="page-header">
            <h1><?php echo t('shop'); ?></h1>
            <p><?php echo $total; ?> <?php echo t('products_found'); ?></p>
        </div>
        
        <div class="shop-layout">
            <!-- Sidebar Filters -->
            <aside class="shop-sidebar">
                <div class="filter-section">
                    <h3><?php echo t('categories'); ?></h3>
                    <ul class="category-list">
                        <li><a href="shop.php" class="<?php echo !$category ? 'active' : ''; ?>"><?php echo t('all_categories'); ?></a></li>
                        <?php foreach ($categories as $cat): ?>
                        <li>
                            <a href="?category=<?php echo $cat['id']; ?>" class="<?php echo $category == $cat['id'] ? 'active' : ''; ?>">
                                <?php echo h(translate($cat, 'name')); ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="filter-section">
                    <h3><?php echo t('price_range'); ?></h3>
                    <form method="GET" class="price-filter">
                        <?php if ($category): ?><input type="hidden" name="category" value="<?php echo $category; ?>"><?php endif; ?>
                        <input type="number" name="min_price" placeholder="<?php echo t('min'); ?>" value="<?php echo $min_price; ?>" class="form-control">
                        <input type="number" name="max_price" placeholder="<?php echo t('max'); ?>" value="<?php echo $max_price; ?>" class="form-control">
                        <button type="submit" class="btn btn-primary"><?php echo t('filter'); ?></button>
                    </form>
                </div>
            </aside>
            
            <!-- Products Grid -->
            <div class="shop-content">
                <!-- Toolbar -->
                <div class="shop-toolbar">
                    <div class="results-count">
                        <?php echo t('showing'); ?> <?php echo min($offset + 1, $total); ?>-<?php echo min($offset + $per_page, $total); ?> <?php echo t('of'); ?> <?php echo $total; ?>
                    </div>
                    <div class="sort-by">
                        <label><?php echo t('sort_by'); ?>:</label>
                        <select onchange="window.location.href='?sort=' + this.value + '<?php echo $category ? '&category='.$category : ''; ?>'" class="form-control">
                            <option value="newest" <?php echo $sort === 'newest' ? 'selected' : ''; ?>><?php echo t('newest'); ?></option>
                            <option value="price_low" <?php echo $sort === 'price_low' ? 'selected' : ''; ?>><?php echo t('price_low_high'); ?></option>
                            <option value="price_high" <?php echo $sort === 'price_high' ? 'selected' : ''; ?>><?php echo t('price_high_low'); ?></option>
                            <option value="name" <?php echo $sort === 'name' ? 'selected' : ''; ?>><?php echo t('name'); ?></option>
                        </select>
                    </div>
                </div>
                
                <!-- Products -->
                <?php if (empty($products)): ?>
                <div class="no-products">
                    <i class="fas fa-box-open"></i>
                    <p><?php echo t('no_products_found'); ?></p>
                </div>
                <?php else: ?>
                <div class="products-grid">
                    <?php foreach ($products as $product): ?>
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
                
                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>&category=<?php echo $category; ?>&sort=<?php echo $sort; ?>" 
                       class="page-link <?php echo $page_num == $i ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                    <?php endfor; ?>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.shop-page { padding: 40px 0; }
.page-header { margin-bottom: 30px; text-align: center; }
.page-header h1 { font-size: 36px; font-weight: 700; margin-bottom: 10px; }
.shop-layout { display: grid; grid-template-columns: 280px 1fr; gap: 30px; }
.shop-sidebar { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); height: fit-content; }
.filter-section { margin-bottom: 30px; }
.filter-section:last-child { margin-bottom: 0; }
.filter-section h3 { font-size: 18px; font-weight: 600; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #2563eb; }
.category-list { list-style: none; }
.category-list li { margin-bottom: 10px; }
.category-list a { display: block; padding: 8px 12px; border-radius: 6px; transition: all 0.3s; color: #666; }
.category-list a:hover, .category-list a.active { background: #eff6ff; color: #2563eb; font-weight: 600; }
.price-filter { display: flex; flex-direction: column; gap: 10px; }
.shop-toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; padding: 15px; background: white; border-radius: 8px; }
.sort-by { display: flex; align-items: center; gap: 10px; }
.sort-by select { width: 200px; }
.no-products { text-align: center; padding: 80px 20px; }
.no-products i { font-size: 64px; color: #ddd; margin-bottom: 15px; }
.pagination { display: flex; justify-content: center; gap: 5px; margin-top: 30px; }
.page-link { padding: 10px 15px; border-radius: 6px; background: white; color: #666; transition: all 0.3s; }
.page-link:hover, .page-link.active { background: #2563eb; color: white; }
@media (max-width: 768px) {
    .shop-layout { grid-template-columns: 1fr; }
    .shop-sidebar { margin-bottom: 20px; }
}
</style>

<?php include 'includes/footer.php'; ?>
