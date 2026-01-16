<?php
/**
 * Products List Page
 */

require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdminLogin();

$page_title = 'Products';
$current_page = 'products';

// Pagination
$page = $_GET['page'] ?? 1;
$per_page = 20;
$offset = ($page - 1) * $per_page;

// Filters
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$status = $_GET['status'] ?? '';
$filter = $_GET['filter'] ?? ''; // low_stock, out_of_stock

// Build query
$where = [];
$params = [];

if ($search) {
    $where[] = "(p.name_en LIKE ? OR p.name_ar LIKE ? OR p.sku LIKE ?)";
    $search_term = "%{$search}%";
    $params[] = $search_term;
    $params[] = $search_term;
    $params[] = $search_term;
}

if ($category) {
    $where[] = "p.category_id = ?";
    $params[] = $category;
}

if ($status) {
    $where[] = "p.status = ?";
    $params[] = $status;
}

if ($filter === 'low_stock') {
    $where[] = "p.stock_quantity < 10 AND p.stock_quantity > 0";
} elseif ($filter === 'out_of_stock') {
    $where[] = "p.stock_quantity = 0";
}

$where_clause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Get products
$products = $db->query(
    "SELECT p.*, c.name_en as category_name 
    FROM products p 
    LEFT JOIN categories c ON p.category_id = c.id 
    {$where_clause}
    ORDER BY p.created_at DESC 
    LIMIT {$per_page} OFFSET {$offset}",
    $params
)->fetchAll();

// Get total count
$total = $db->query(
    "SELECT COUNT(*) as count FROM products p {$where_clause}",
    $params
)->fetch()['count'];

$total_pages = ceil($total / $per_page);

// Get categories for filter
$categories = $db->query("SELECT * FROM categories WHERE status = 'active' ORDER BY name_en")->fetchAll();

include __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-box"></i> Products
    </h1>
    <div class="page-actions">
        <a href="add.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Product
        </a>
    </div>
</div>

<!-- Filters -->
<div class="dashboard-card" style="margin-bottom: 20px;">
    <div class="card-body">
        <form method="GET" class="filters-form">
            <div class="filters-grid">
                <div class="filter-item">
                    <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="filter-item">
                    <select name="category" class="form-control">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo $category == $cat['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['name_en']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-item">
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="active" <?php echo $status === 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo $status === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
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

<!-- Products Table -->
<div class="dashboard-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table products-table">
                <thead>
                    <tr>
                        <th width="60">Image</th>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="8" class="text-center" style="padding: 40px;">
                            <i class="fas fa-box-open" style="font-size: 48px; color: #ccc; margin-bottom: 10px;"></i>
                            <p style="color: #999;">No products found</p>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td>
                            <img src="<?php echo $product['main_image'] ?: '/images/products/default.jpg'; ?>" 
                                 alt="<?php echo htmlspecialchars($product['name_en']); ?>" 
                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                        </td>
                        <td>
                            <strong><?php echo htmlspecialchars($product['name_en']); ?></strong><br>
                            <small style="color: #999;"><?php echo htmlspecialchars($product['name_ar'] ?? ''); ?></small>
                        </td>
                        <td><code><?php echo htmlspecialchars($product['sku']); ?></code></td>
                        <td><?php echo htmlspecialchars($product['category_name'] ?? 'N/A'); ?></td>
                        <td><strong>$<?php echo number_format($product['price'], 2); ?></strong></td>
                        <td>
                            <span class="badge <?php echo $product['stock_quantity'] < 10 ? 'badge-danger' : 'badge-success'; ?>">
                                <?php echo $product['stock_quantity']; ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-<?php echo $product['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                <?php echo ucfirst($product['status']); ?>
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="edit.php?id=<?php echo $product['id']; ?>" class="btn-icon" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="view.php?id=<?php echo $product['id']; ?>" class="btn-icon" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="delete.php?id=<?php echo $product['id']; ?>" class="btn-icon text-danger" 
                                   onclick="return confirm('Are you sure you want to delete this product?')" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&category=<?php echo $category; ?>&status=<?php echo $status; ?>" 
               class="page-link <?php echo $page == $i ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.filters-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr auto;
    gap: 10px;
}

.filter-item {
    display: flex;
    gap: 10px;
}

.action-buttons {
    display: flex;
    gap: 8px;
}

.btn-icon {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    background: var(--gray-100);
    color: var(--gray-600);
    transition: all 0.3s;
}

.btn-icon:hover {
    background: var(--primary-blue);
    color: white;
}

.btn-icon.text-danger:hover {
    background: var(--danger);
    color: white;
}

.pagination {
    display: flex;
    justify-content: center;
    gap: 5px;
    margin-top: 20px;
}

.page-link {
    padding: 8px 12px;
    border-radius: 6px;
    background: var(--gray-100);
    color: var(--gray-700);
    transition: all 0.3s;
}

.page-link:hover, .page-link.active {
    background: var(--primary-blue);
    color: white;
}
</style>

<?php include __DIR__ . '/../includes/footer.php'; ?>
