<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdminLogin();

$page_title = 'Coupons';
$current_page = 'coupons';

// Get all coupons
$coupons = $db->query(
    "SELECT * FROM coupons ORDER BY created_at DESC"
)->fetchAll();

include __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
    <h1 class="page-title"><i class="fas fa-ticket-alt"></i> Discount Coupons</h1>
    <div class="page-actions">
        <button onclick="openCouponModal()" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Coupon
        </button>
    </div>
</div>

<div class="dashboard-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Usage</th>
                        <th>Expires</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($coupons as $coupon): ?>
                    <tr>
                        <td><strong><code><?php echo h($coupon['code']); ?></code></strong></td>
                        <td><span class="badge badge-info"><?php echo ucfirst($coupon['type']); ?></span></td>
                        <td>
                            <strong>
                                <?php if ($coupon['type'] === 'percentage'): ?>
                                    <?php echo $coupon['value']; ?>%
                                <?php else: ?>
                                    $<?php echo number_format($coupon['value'], 2); ?>
                                <?php endif; ?>
                            </strong>
                        </td>
                        <td><?php echo $coupon['times_used']; ?> / <?php echo $coupon['usage_limit'] ?: '∞'; ?></td>
                        <td><?php echo $coupon['expires_at'] ? date('M d, Y', strtotime($coupon['expires_at'])) : 'Never'; ?></td>
                        <td><span class="badge badge-<?php echo $coupon['status'] === 'active' ? 'success' : 'secondary'; ?>"><?php echo ucfirst($coupon['status']); ?></span></td>
                        <td>
                            <button onclick="editCoupon(<?php echo $coupon['id']; ?>)" class="btn-icon" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="delete.php?id=<?php echo $coupon['id']; ?>" class="btn-icon text-danger" onclick="return confirm('Delete this coupon?')" title="Delete">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Coupon Modal -->
<div class="modal" id="couponModal">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h3 id="modalTitle">Add Coupon</h3>
            <button onclick="closeCouponModal()" class="modal-close">&times;</button>
        </div>
        <form method="POST" action="save.php" class="modal-body">
            <input type="hidden" name="id" id="couponId">
            
            <div class="form-group">
                <label class="form-label">Coupon Code *</label>
                <input type="text" name="code" id="code" class="form-control" required style="text-transform: uppercase;">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Type *</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="percentage">Percentage</option>
                        <option value="fixed">Fixed Amount</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Value *</label>
                    <input type="number" name="value" id="value" class="form-control" step="0.01" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Min Order Amount</label>
                    <input type="number" name="min_order_amount" id="min_order_amount" class="form-control" step="0.01">
                </div>
                <div class="form-group">
                    <label class="form-label">Max Discount</label>
                    <input type="number" name="max_discount" id="max_discount" class="form-control" step="0.01">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Usage Limit</label>
                    <input type="number" name="usage_limit" id="usage_limit" class="form-control" placeholder="Leave empty for unlimited">
                </div>
                <div class="form-group">
                    <label class="form-label">Expires At</label>
                    <input type="datetime-local" name="expires_at" id="expires_at" class="form-control">
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="closeCouponModal()" class="btn btn-outline">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Coupon</button>
            </div>
        </form>
    </div>
</div>

<script>
function openCouponModal() {
    document.getElementById('couponModal').classList.add('show');
    document.getElementById('modalTitle').textContent = 'Add Coupon';
    document.querySelector('form').reset();
    document.getElementById('couponId').value = '';
}

function closeCouponModal() {
    document.getElementById('couponModal').classList.remove('show');
}

function editCoupon(id) {
    fetch('get.php?id=' + id)
        .then(r => r.json())
        .then(data => {
            document.getElementById('modalTitle').textContent = 'Edit Coupon';
            document.getElementById('couponId').value = data.id;
            document.getElementById('code').value = data.code;
            document.getElementById('type').value = data.type;
            document.getElementById('value').value = data.value;
            document.getElementById('min_order_amount').value = data.min_order_amount;
            document.getElementById('max_discount').value = data.max_discount;
            document.getElementById('usage_limit').value = data.usage_limit;
            document.getElementById('expires_at').value = data.expires_at ? data.expires_at.slice(0, 16) : '';
            document.getElementById('status').value = data.status;
            openCouponModal();
        });
}
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
