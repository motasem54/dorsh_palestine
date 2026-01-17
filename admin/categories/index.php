<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/language.php';

requireAdminLogin();

$page_title = at('categories');

// Get all categories with parent info
$categories = $db->query(
    "SELECT c.*, p.name_en as parent_name_en, p.name_ar as parent_name_ar 
    FROM categories c 
    LEFT JOIN categories p ON c.parent_id = p.id 
    ORDER BY c.parent_id IS NULL DESC, c.display_order, c.name_en"
)->fetchAll();

// Organize into tree structure
$tree = [];
foreach ($categories as $cat) {
    if ($cat['parent_id'] === null) {
        $tree[$cat['id']] = $cat;
        $tree[$cat['id']]['children'] = [];
    }
}
foreach ($categories as $cat) {
    if ($cat['parent_id'] !== null && isset($tree[$cat['parent_id']])) {
        $tree[$cat['parent_id']]['children'][] = $cat;
    }
}

include '../includes/header.php';
?>

<div class="content-header">
    <h2><?php echo at('categories'); ?></h2>
    <a href="add.php" class="btn btn-primary">
        <i class="fas fa-plus"></i>
        <?php echo at('add_category'); ?>
    </a>
</div>

<div class="card">
    <table class="data-table">
        <thead>
            <tr>
                <th><?php echo at('image'); ?></th>
                <th><?php echo at('category_name'); ?></th>
                <th><?php echo at('slug'); ?></th>
                <th><?php echo at('type'); ?></th>
                <th><?php echo at('order'); ?></th>
                <th><?php echo at('status'); ?></th>
                <th><?php echo at('actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tree as $parent): ?>
            <tr style="background: #f8f9fa; font-weight: 600;">
                <td>
                    <?php if ($parent['image']): ?>
                    <img src="../../images/categories/<?php echo $parent['image']; ?>" 
                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                    <?php else: ?>
                    <div style="width: 50px; height: 50px; background: #ddd; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-image" style="color: #999;"></i>
                    </div>
                    <?php endif; ?>
                </td>
                <td>
                    <i class="fas fa-folder" style="color: #2563eb;"></i>
                    <?php echo getAdminLang() == 'ar' ? $parent['name_ar'] : $parent['name_en']; ?>
                </td>
                <td><?php echo $parent['slug']; ?></td>
                <td><span class="badge badge-primary"><?php echo at('main_category'); ?></span></td>
                <td><?php echo $parent['display_order']; ?></td>
                <td>
                    <span class="badge badge-<?php echo $parent['status'] == 'active' ? 'success' : 'secondary'; ?>">
                        <?php echo at($parent['status']); ?>
                    </span>
                </td>
                <td>
                    <a href="edit.php?id=<?php echo $parent['id']; ?>" class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="delete.php?id=<?php echo $parent['id']; ?>" 
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('<?php echo at('confirm_delete'); ?>')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            
            <?php if (!empty($parent['children'])): ?>
                <?php foreach ($parent['children'] as $child): ?>
                <tr>
                    <td></td>
                    <td style="<?php echo isAdminRTL() ? 'padding-right: 40px;' : 'padding-left: 40px;'; ?>">
                        <i class="fas fa-level-up-alt fa-rotate-90" style="color: #999; margin-<?php echo isAdminRTL() ? 'left' : 'right'; ?>: 10px;"></i>
                        <?php echo getAdminLang() == 'ar' ? $child['name_ar'] : $child['name_en']; ?>
                    </td>
                    <td><?php echo $child['slug']; ?></td>
                    <td><span class="badge badge-secondary"><?php echo at('sub_category'); ?></span></td>
                    <td><?php echo $child['display_order']; ?></td>
                    <td>
                        <span class="badge badge-<?php echo $child['status'] == 'active' ? 'success' : 'secondary'; ?>">
                            <?php echo at($child['status']); ?>
                        </span>
                    </td>
                    <td>
                        <a href="edit.php?id=<?php echo $child['id']; ?>" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="delete.php?id=<?php echo $child['id']; ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('<?php echo at('confirm_delete'); ?>')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
