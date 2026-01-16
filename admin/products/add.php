<?php
/**
 * Add/Edit Product Page
 */

require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdminLogin();

$product_id = $_GET['id'] ?? null;
$is_edit = $product_id !== null;

$page_title = $is_edit ? 'Edit Product' : 'Add Product';
$current_page = 'products';

// Get product data if editing
$product = null;
if ($is_edit) {
    $product = $db->query("SELECT * FROM products WHERE id = ?", [$product_id])->fetch();
    if (!$product) {
        header('Location: index.php');
        exit;
    }
}

// Get categories
$categories = $db->query("SELECT * FROM categories WHERE status = 'active' ORDER BY name_en")->fetchAll();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'sku' => sanitize($_POST['sku']),
        'name_en' => sanitize($_POST['name_en']),
        'name_ar' => sanitize($_POST['name_ar']),
        'description_en' => sanitize($_POST['description_en']),
        'description_ar' => sanitize($_POST['description_ar']),
        'category_id' => (int)$_POST['category_id'],
        'price' => (float)$_POST['price'],
        'compare_price' => $_POST['compare_price'] ? (float)$_POST['compare_price'] : null,
        'cost' => $_POST['cost'] ? (float)$_POST['cost'] : null,
        'stock_quantity' => (int)$_POST['stock_quantity'],
        'low_stock_threshold' => (int)($_POST['low_stock_threshold'] ?? 10),
        'weight' => $_POST['weight'] ? (float)$_POST['weight'] : null,
        'status' => $_POST['status'],
        'featured' => isset($_POST['featured']) ? 1 : 0,
        'meta_title' => sanitize($_POST['meta_title'] ?? ''),
        'meta_description' => sanitize($_POST['meta_description'] ?? '')
    ];
    
    try {
        if ($is_edit) {
            // Update product
            $data['updated_at'] = date('Y-m-d H:i:s');
            $set = [];
            foreach ($data as $key => $value) {
                $set[] = "{$key} = ?";
            }
            $db->query(
                "UPDATE products SET " . implode(', ', $set) . " WHERE id = ?",
                array_merge(array_values($data), [$product_id])
            );
            
            logAdminActivity($_SESSION['admin_id'], 'product_update', "Updated product: {$data['name_en']}");
            $_SESSION['success'] = 'Product updated successfully!';
        } else {
            // Insert product
            $data['created_at'] = date('Y-m-d H:i:s');
            $placeholders = array_fill(0, count($data), '?');
            $db->query(
                "INSERT INTO products (" . implode(', ', array_keys($data)) . ") VALUES (" . implode(', ', $placeholders) . ")",
                array_values($data)
            );
            
            logAdminActivity($_SESSION['admin_id'], 'product_create', "Created product: {$data['name_en']}");
            $_SESSION['success'] = 'Product added successfully!';
        }
        
        header('Location: index.php');
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

include __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-<?php echo $is_edit ? 'edit' : 'plus'; ?>"></i> 
        <?php echo $is_edit ? 'Edit Product' : 'Add Product'; ?>
    </h1>
    <div class="page-actions">
        <a href="index.php" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Back to Products
        </a>
    </div>
</div>

<?php if (isset($error)): ?>
<div class="alert alert-danger">
    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
</div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="product-form">
    <div class="form-layout">
        <!-- Main Content -->
        <div class="form-main">
            <!-- Basic Info -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> Basic Information</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Product Name (English) *</label>
                        <input type="text" name="name_en" class="form-control" required 
                               value="<?php echo htmlspecialchars($product['name_en'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Product Name (Arabic) *</label>
                        <input type="text" name="name_ar" class="form-control" required dir="rtl"
                               value="<?php echo htmlspecialchars($product['name_ar'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-col-6">
                            <div class="form-group">
                                <label class="form-label">SKU *</label>
                                <input type="text" name="sku" class="form-control" required
                                       value="<?php echo htmlspecialchars($product['sku'] ?? 'SKU-' . rand(1000, 9999)); ?>">
                            </div>
                        </div>
                        <div class="form-col-6">
                            <div class="form-group">
                                <label class="form-label">Category *</label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>" 
                                            <?php echo ($product['category_id'] ?? '') == $cat['id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($cat['name_en']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Description (English)</label>
                        <textarea name="description_en" class="form-control" rows="5"><?php echo htmlspecialchars($product['description_en'] ?? ''); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Description (Arabic)</label>
                        <textarea name="description_ar" class="form-control" rows="5" dir="rtl"><?php echo htmlspecialchars($product['description_ar'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Pricing -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-dollar-sign"></i> Pricing</h3>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-col-4">
                            <div class="form-group">
                                <label class="form-label">Price *</label>
                                <input type="number" name="price" class="form-control" step="0.01" required
                                       value="<?php echo $product['price'] ?? ''; ?>">
                            </div>
                        </div>
                        <div class="form-col-4">
                            <div class="form-group">
                                <label class="form-label">Compare at Price</label>
                                <input type="number" name="compare_price" class="form-control" step="0.01"
                                       value="<?php echo $product['compare_price'] ?? ''; ?>">
                            </div>
                        </div>
                        <div class="form-col-4">
                            <div class="form-group">
                                <label class="form-label">Cost per Item</label>
                                <input type="number" name="cost" class="form-control" step="0.01"
                                       value="<?php echo $product['cost'] ?? ''; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Inventory -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-warehouse"></i> Inventory</h3>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-col-6">
                            <div class="form-group">
                                <label class="form-label">Stock Quantity *</label>
                                <input type="number" name="stock_quantity" class="form-control" required
                                       value="<?php echo $product['stock_quantity'] ?? 0; ?>">
                            </div>
                        </div>
                        <div class="form-col-6">
                            <div class="form-group">
                                <label class="form-label">Low Stock Threshold</label>
                                <input type="number" name="low_stock_threshold" class="form-control"
                                       value="<?php echo $product['low_stock_threshold'] ?? 10; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- SEO -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-search"></i> SEO</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control"
                               value="<?php echo htmlspecialchars($product['meta_title'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="3"><?php echo htmlspecialchars($product['meta_description'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="form-sidebar">
            <!-- Status -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-toggle-on"></i> Status</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Product Status</label>
                        <select name="status" class="form-control">
                            <option value="active" <?php echo ($product['status'] ?? '') === 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo ($product['status'] ?? '') === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="featured" id="featured" 
                               <?php echo ($product['featured'] ?? 0) ? 'checked' : ''; ?>>
                        <label for="featured">Featured Product</label>
                    </div>
                </div>
            </div>
            
            <!-- Product Image -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-image"></i> Product Image</h3>
                </div>
                <div class="card-body">
                    <div class="image-upload">
                        <div class="image-preview" id="imagePreview">
                            <?php if (isset($product['main_image']) && $product['main_image']): ?>
                            <img src="<?php echo $product['main_image']; ?>" alt="Product">
                            <?php else: ?>
                            <i class="fas fa-image"></i>
                            <p>Click to upload image</p>
                            <?php endif; ?>
                        </div>
                        <input type="file" name="main_image" id="mainImage" accept="image/*" style="display: none;">
                        <button type="button" class="btn btn-outline" onclick="document.getElementById('mainImage').click()">
                            <i class="fas fa-upload"></i> Upload Image
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Quick Info -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info"></i> Additional Info</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Weight (kg)</label>
                        <input type="number" name="weight" class="form-control" step="0.01"
                               value="<?php echo $product['weight'] ?? ''; ?>">
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="dashboard-card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">
                        <i class="fas fa-save"></i> <?php echo $is_edit ? 'Update Product' : 'Create Product'; ?>
                    </button>
                    <a href="index.php" class="btn btn-outline" style="width: 100%;">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
.form-layout {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 20px;
}

.form-main {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-sidebar {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group:last-child {
    margin-bottom: 0;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: var(--gray-700);
}

.form-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}

.form-col-4 {
    grid-column: span 1;
}

.form-col-6 {
    grid-column: span 1;
}

.form-check {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 10px;
}

.image-upload {
    text-align: center;
}

.image-preview {
    width: 100%;
    height: 200px;
    border: 2px dashed var(--gray-300);
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
    cursor: pointer;
    overflow: hidden;
}

.image-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-preview i {
    font-size: 48px;
    color: var(--gray-300);
    margin-bottom: 10px;
}

.image-preview p {
    color: var(--gray-500);
}

@media (max-width: 1024px) {
    .form-layout {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.getElementById('mainImage')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
        };
        reader.readAsDataURL(file);
    }
});
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
