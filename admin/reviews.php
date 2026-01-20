<?php
session_start();
$page_title = 'Product Reviews';
require_once 'includes/header.php';

// Get all reviews
$reviews = $db->query(
    "SELECT r.*, p.name_en as product_name, u.first_name, u.last_name, u.email 
    FROM reviews r 
    LEFT JOIN products p ON r.product_id = p.id 
    LEFT JOIN users u ON r.user_id = u.id 
    ORDER BY r.created_at DESC"
)->fetchAll();
?>

<style>
.reviews-grid {
    display: grid;
    gap: 20px;
}

.review-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border-radius: 15px;
    padding: 25px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.review-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 15px;
}

.review-user {
    display: flex;
    align-items: center;
    gap: 15px;
}

.user-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 20px;
}

.user-info strong {
    display: block;
    color: white;
    font-size: 16px;
}

.user-info small {
    color: rgba(255, 255, 255, 0.7);
}

.rating-stars {
    color: #f39c12;
    font-size: 18px;
}

.review-content {
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.6;
    margin: 15px 0;
}

.review-product {
    display: inline-block;
    background: rgba(52, 152, 219, 0.2);
    color: #3498db;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    margin-top: 10px;
}

.review-actions {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}

.btn-sm {
    padding: 8px 16px;
    border-radius: 8px;
    border: none;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-approve {
    background: #2ecc71;
    color: white;
}

.btn-reject {
    background: #e74c3c;
    color: white;
}

.btn-sm:hover {
    transform: translateY(-2px);
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-approved {
    background: rgba(46, 204, 113, 0.2);
    color: #2ecc71;
}

.status-pending {
    background: rgba(243, 156, 18, 0.2);
    color: #f39c12;
}
</style>

<div class="reviews-grid">
    <?php if (empty($reviews)): ?>
    <div style="text-align: center; padding: 60px; color: white;">
        <i class="fas fa-star" style="font-size: 64px; opacity: 0.3; margin-bottom: 20px;"></i>
        <h3>No reviews yet</h3>
    </div>
    <?php else: ?>
        <?php foreach ($reviews as $review): ?>
        <div class="review-card">
            <div class="review-header">
                <div class="review-user">
                    <div class="user-avatar">
                        <?php echo strtoupper(substr($review['first_name'] ?? 'U', 0, 1)); ?>
                    </div>
                    <div class="user-info">
                        <strong><?php echo htmlspecialchars(($review['first_name'] ?? '') . ' ' . ($review['last_name'] ?? 'User')); ?></strong>
                        <small><?php echo htmlspecialchars($review['email'] ?? 'N/A'); ?></small>
                    </div>
                </div>
                <div>
                    <?php if ($review['status'] === 'approved'): ?>
                        <span class="status-badge status-approved"><i class="fas fa-check"></i> Approved</span>
                    <?php else: ?>
                        <span class="status-badge status-pending"><i class="fas fa-clock"></i> Pending</span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="rating-stars">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <?php if ($i <= $review['rating']): ?>
                        <i class="fas fa-star"></i>
                    <?php else: ?>
                        <i class="far fa-star"></i>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
            
            <div class="review-content">
                <?php echo htmlspecialchars($review['review']); ?>
            </div>
            
            <span class="review-product">
                <i class="fas fa-box"></i> <?php echo htmlspecialchars($review['product_name'] ?? 'Unknown Product'); ?>
            </span>
            
            <?php if ($review['status'] !== 'approved'): ?>
            <div class="review-actions">
                <button class="btn-sm btn-approve" onclick="updateReview(<?php echo $review['id']; ?>, 'approved')">
                    <i class="fas fa-check"></i> Approve
                </button>
                <button class="btn-sm btn-reject" onclick="updateReview(<?php echo $review['id']; ?>, 'rejected')">
                    <i class="fas fa-times"></i> Reject
                </button>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
function updateReview(id, status) {
    if (confirm('Are you sure?')) {
        fetch('api/update-review.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({id: id, status: status})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}
</script>

<?php require_once 'includes/footer.php'; ?>