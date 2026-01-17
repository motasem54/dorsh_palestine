<?php
/**
 * Change Language API
 * Handles language switching requests
 */

session_start();

header('Content-Type: application/json');

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['lang'])) {
    echo json_encode(['success' => false, 'message' => 'Language not specified']);
    exit;
}

$lang = $input['lang'];

// Validate language
$allowed_languages = ['en', 'ar', 'he'];

if (!in_array($lang, $allowed_languages)) {
    echo json_encode(['success' => false, 'message' => 'Invalid language']);
    exit;
}

// Set language in session
$_SESSION['lang'] = $lang;

// Set cookie for persistence (30 days)
setcookie('lang', $lang, time() + (30 * 24 * 60 * 60), '/');

echo json_encode([
    'success' => true,
    'lang' => $lang,
    'message' => 'Language changed successfully'
]);
?>