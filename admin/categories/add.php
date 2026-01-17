<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/language.php';

requireAdminLogin();

$page_title = at('add_category');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_en = sanitize($_POST['name_en']);
    $name_ar = sanitize($_POST['name_ar']);
    $slug = sanitize($_POST['slug']);
    $parent_id = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;
    $display_order = (int)$_POST['display_order'];
    $status = $_POST['status'];
    
    // Handle image upload
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = __DIR__ . '/../../images/categories/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        $file_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image = uniqid() . '.' . $file_ext;
        move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image);
    }
    
    try {
        $db->query(
            "INSERT INTO categories (name_en, name_ar, slug, parent_id, image, display_order, status, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())",
            [$name_en, $name_ar, $slug, $parent_id, $image, $display_order, $status]
        );
        
        logAdminActivity($_SESSION['admin_id'], 'category_create', "Created category: {$name_en}");
        
        $_SESSION['success'] = at('saved_successfully');
        header('Location: index.php');
        exit;
    } catch (Exception $e) {
        $error = at('error') . ': ' . $e->getMessage();
    }
}

// Get parent categories
$parent_categories = $db->query(
    "SELECT * FROM categories WHERE parent_id IS NULL AND status = 'active' ORDER BY display_order"
)->fetchAll();

include '../includes/header.php';
?>

<div class="content-header">
    <h2><?php echo at('add_category'); ?></h2>
    <a href="index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        <?php echo at('back'); ?>
    </a>
</div>

<?php if (isset($error)): ?>
<div class="alert alert-error"><?php echo $error; ?></div>
<?php endif; ?>

<div class="card">
    <form method="POST" enctype="multipart/form-data" class="form">
        <div class="form-row">
            <div class="form-group">
                <label class="form-label"><?php echo at('category_name_en'); ?> *</label>
                <input type="text" name="name_en" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label"><?php echo at('category_name_ar'); ?> *</label>
                <input type="text" name="name_ar" class="form-control" required dir="rtl">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label"><?php echo at('slug'); ?> *</label>
                <input type="text" name="slug" class="form-control" required>
                <small style="color: #999;"><?php echo at('slug'); ?>: coffee-equipment</small>
            </div>
            <div class="form-group">
                <label class="form-label"><?php echo at('category'); ?> (<?php echo at('parent'); ?>)</label>
                <select name="parent_id" class="form-control">
                    <option value=""><?php echo at('none'); ?> - <?php echo at('main_category'); ?></option>
                    <?php foreach ($parent_categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>">
                        <?php echo getAdminLang() == 'ar' ? $cat['name_ar'] : $cat['name_en']; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label"><?php echo at('image'); ?></label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <small style="color: #999;"><?php echo at('recommended'); ?>: 800x600px</small>
            </div>
            <div class="form-group">
                <label class="form-label"><?php echo at('display_order'); ?></label>
                <input type="number" name="display_order" class="form-control" value="0" min="0">
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label"><?php echo at('status'); ?> *</label>
            <select name="status" class="form-control" required>
                <option value="active"><?php echo at('active'); ?></option>
                <option value="inactive"><?php echo at('inactive'); ?></option>
            </select>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                <?php echo at('save'); ?>
            </button>
            <a href="index.php" class="btn btn-secondary"><?php echo at('cancel'); ?></a>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
