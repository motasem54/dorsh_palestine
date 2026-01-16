<?php
/**
 * Clear Chat History API
 */

session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Clear chat history from session
unset($_SESSION['chat_history']);

echo json_encode([
    'success' => true,
    'message' => 'Chat history cleared'
]);
