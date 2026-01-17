<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/reviews.php';

session_start();
header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Please login to submit a review']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$product_id = (int)$_POST['product_id'];
$rating = (int)$_POST['rating'];
$review_text = trim($_POST['review']);
$user_id = $_SESSION['user_id'];

if ($rating < 1 || $rating > 5) {
    echo json_encode(['success' => false, 'message' => 'Invalid rating']);
    exit;
}

if (strlen($review_text) < 10) {
    echo json_encode(['success' => false, 'message' => 'Review must be at least 10 characters']);
    exit;
}

if (!canUserReview($product_id, $user_id)) {
    echo json_encode(['success' => false, 'message' => 'You can only review products you have purchased and have not reviewed before']);
    exit;
}

if (addReview($product_id, $user_id, $rating, $review_text)) {
    echo json_encode(['success' => true, 'message' => 'Thank you! Your review is pending approval.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to submit review']);
}
