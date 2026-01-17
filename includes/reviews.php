<?php
/**
 * Product Reviews Functions
 */

function getProductReviews($product_id, $limit = 10, $offset = 0) {
    global $db;
    return $db->query(
        "SELECT r.*, CONCAT(u.first_name, ' ', u.last_name) as user_name
        FROM product_reviews r
        LEFT JOIN users u ON r.user_id = u.id
        WHERE r.product_id = ? AND r.status = 'approved'
        ORDER BY r.created_at DESC
        LIMIT ? OFFSET ?",
        [$product_id, $limit, $offset]
    )->fetchAll();
}

function getProductRating($product_id) {
    global $db;
    $result = $db->query(
        "SELECT 
            COUNT(*) as total_reviews,
            COALESCE(AVG(rating), 0) as average_rating,
            SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) as five_star,
            SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) as four_star,
            SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) as three_star,
            SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) as two_star,
            SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) as one_star
        FROM product_reviews
        WHERE product_id = ? AND status = 'approved'",
        [$product_id]
    )->fetch();
    
    return $result;
}

function canUserReview($product_id, $user_id) {
    global $db;
    
    // Check if user has purchased this product
    $purchased = $db->query(
        "SELECT COUNT(*) as count
        FROM order_items oi
        JOIN orders o ON oi.order_id = o.id
        WHERE oi.product_id = ? AND o.user_id = ? AND o.status IN ('completed', 'delivered')",
        [$product_id, $user_id]
    )->fetch();
    
    if ($purchased['count'] == 0) return false;
    
    // Check if user already reviewed
    $reviewed = $db->query(
        "SELECT COUNT(*) as count FROM product_reviews WHERE product_id = ? AND user_id = ?",
        [$product_id, $user_id]
    )->fetch();
    
    return $reviewed['count'] == 0;
}

function addReview($product_id, $user_id, $rating, $review_text) {
    global $db;
    
    if (!canUserReview($product_id, $user_id)) {
        return false;
    }
    
    $db->query(
        "INSERT INTO product_reviews (product_id, user_id, rating, review, status, created_at) 
        VALUES (?, ?, ?, ?, 'pending', NOW())",
        [$product_id, $user_id, $rating, $review_text]
    );
    
    return true;
}

function renderStars($rating, $size = 'medium') {
    $size_class = $size === 'small' ? 'stars-sm' : ($size === 'large' ? 'stars-lg' : '');
    $output = '<div class="stars ' . $size_class . '">';
    
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= floor($rating)) {
            $output .= '<i class="fas fa-star"></i>';
        } elseif ($i - 0.5 <= $rating) {
            $output .= '<i class="fas fa-star-half-alt"></i>';
        } else {
            $output .= '<i class="far fa-star"></i>';
        }
    }
    
    $output .= '</div>';
    return $output;
}
