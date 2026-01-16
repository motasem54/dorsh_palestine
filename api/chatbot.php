<?php
/**
 * Chatbot API Endpoint
 * Handles AI chatbot interactions
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/openai.php';
require_once '../includes/language.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get request data
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}

// Validate required fields
if (!isset($input['message']) || empty(trim($input['message']))) {
    http_response_code(400);
    echo json_encode(['error' => 'Message is required']);
    exit;
}

$message = trim($input['message']);
$type = $input['type'] ?? 'chat'; // chat, search, recommendation, faq
$lang = $input['lang'] ?? $current_lang;
$conversation_history = $input['history'] ?? [];
$product_id = $input['product_id'] ?? null;

try {
    // Initialize OpenAI
    $openai = new OpenAI($db);
    
    // Handle different request types
    switch ($type) {
        case 'search':
            // Product search
            $response = $openai->searchProducts($message, $lang);
            break;
            
        case 'recommendation':
            // Product recommendations
            if (!$product_id) {
                throw new Exception('Product ID is required for recommendations');
            }
            $response = $openai->getRecommendations($product_id, $conversation_history, $lang);
            break;
            
        case 'faq':
            // FAQ questions
            $response = $openai->answerFAQ($message, $lang);
            break;
            
        case 'chat':
        default:
            // General chat
            $response = $openai->handleCustomerQuery($message, $conversation_history, $lang);
            break;
    }
    
    // Check if response is successful
    if (!$response['success']) {
        throw new Exception($response['error'] ?? 'Unknown error');
    }
    
    // Save conversation to database (optional)
    if (SAVE_CHAT_HISTORY) {
        $stmt = $db->prepare("
            INSERT INTO chat_history (session_id, user_message, bot_response, type, lang, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        $session_id = session_id();
        $stmt->execute([
            $session_id,
            $message,
            $response['message'],
            $type,
            $lang
        ]);
    }
    
    // Return success response
    echo json_encode([
        'success' => true,
        'message' => $response['message'],
        'products' => $response['products'] ?? [],
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
