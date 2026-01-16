<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdminLogin();

$page_title = 'Categories';
$current_page = 'categories';

// Get all categories
$categories = $db->query(
    "SELECT c.*, COUNT(p.id) as product_count 
    FROM categories c 
    LEFT JOIN products p ON c.id = p.category_id 
    GROUP BY c.id 
    ORDER BY c.name_en"
)->fetchAll();

include __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
    <h1 class="page-title"><i class="fas fa-tags"></i> Categories</h1>
    <div class="page-actions">
        <button class="btn btn-primary" onclick="openAddModal()">
            <i class="fas fa-plus"></i> Add Category
        </button>
    </div>
</div>

<div class="dashboard-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Products</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td>
                            <strong><?php echo htmlspecialchars($cat['name_en']); ?></strong><br>
                            <small style="color: #999;"><?php echo htmlspecialchars($cat['name_ar']); ?></small>
                        </td>
                        <td><span class="badge badge-info"><?php echo $cat['product_count']; ?> products</span></td>
                        <td><span class="badge badge-<?php echo $cat['status'] === 'active' ? 'success' : 'secondary'; ?>"><?php echo ucfirst($cat['status']); ?></span></td>
                        <td>
                            <button class="btn-icon" onclick="editCategory(<?php echo $cat['id']; ?>)" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon text-danger" onclick="deleteCategory(<?php echo $cat['id']; ?>)" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div id="categoryModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Add Category</h3>
            <button onclick="closeModal()" class="modal-close">&times;</button>
        </div>
        <form id="categoryForm" method="POST" action="save.php">
            <input type="hidden" name="id" id="category_id">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Name (English) *</label>
                    <input type="text" name="name_en" id="name_en" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Name (Arabic) *</label>
                    <input type="text" name="name_ar" id="name_ar" class="form-control" required dir="rtl">
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal()" class="btn btn-outline">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Category</button>
            </div>
        </form>
    </div>
</div>

<style>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}
.modal-content {
    background: white;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
}
.modal-header {
    padding: 20px;
    border-bottom: 1px solid var(--gray-200);
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.modal-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
}
.modal-body {
    padding: 20px;
}
.modal-footer {
    padding: 20px;
    border-top: 1px solid var(--gray-200);
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}
</style>

<script>
function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Add Category';
    document.getElementById('categoryForm').reset();
    document.getElementById('category_id').value = '';
    document.getElementById('categoryModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('categoryModal').style.display = 'none';
}

function editCategory(id) {
    // Fetch category data and populate form
    fetch(`get.php?id=${id}`)
        .then(r => r.json())
        .then(data => {
            document.getElementById('modalTitle').textContent = 'Edit Category';
            document.getElementById('category_id').value = data.id;
            document.getElementById('name_en').value = data.name_en;
            document.getElementById('name_ar').value = data.name_ar;
            document.getElementById('status').value = data.status;
            document.getElementById('categoryModal').style.display = 'flex';
        });
}

function deleteCategory(id) {
    if (confirm('Are you sure you want to delete this category?')) {
        window.location.href = `delete.php?id=${id}`;
    }
}
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
