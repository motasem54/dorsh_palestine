<?php
/**
 * Chatbot API Endpoint
 * Handles AI chat requests from frontend
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/openai.php';
require_once __DIR__ . '/../includes/language.php';

// Start session
session_start();

// Initialize language
Language::init();

// Set JSON header
header('Content-Type: application/json');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get request data
$input = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!isset($input['message']) || empty(trim($input['message']))) {
    http_response_code(400);
    echo json_encode(['error' => 'Message is required']);
    exit;
}

$message = sanitize($input['message']);
$type = $input['type'] ?? 'general'; // general, product_search, faq, recommendations
$language = $input['language'] ?? Language::getCurrentLanguage();
$context = $input['context'] ?? [];

// Initialize OpenAI
$openai = new OpenAI();

try {
    $response = [];
    
    switch ($type) {
        case 'product_search':
            // AI-powered product search
            $result = $openai->searchProducts($message, $language);
            
            if ($result['success']) {
                $response = [
                    'success' => true,
                    'message' => $result['ai_response'],
                    'products' => formatProductsForResponse($result['products'], $language),
                    'type' => 'product_search'
                ];
            } else {
                throw new Exception($result['error']);
            }
            break;
            
        case 'recommendations':
            // Get AI recommendations for a product
            if (!isset($context['product_id'])) {
                throw new Exception('Product ID is required for recommendations');
            }
            
            $result = $openai->getRecommendations($context['product_id'], $language);
            
            if ($result['success']) {
                $response = [
                    'success' => true,
                    'message' => $result['ai_explanation'],
                    'products' => formatProductsForResponse($result['products'], $language),
                    'type' => 'recommendations'
                ];
            } else {
                throw new Exception($result['error']);
            }
            break;
            
        case 'faq':
            // Answer FAQ questions
            $result = $openai->answerFAQ($message, $language);
            
            if ($result['success']) {
                $response = [
                    'success' => true,
                    'message' => $result['answer'],
                    'type' => 'faq'
                ];
            } else {
                throw new Exception($result['error']);
            }
            break;
            
        case 'general':
        default:
            // General chat
            // Get conversation history from session
            $history = $_SESSION['chat_history'] ?? [];
            
            $context['history'] = $history;
            $context['language'] = $language;
            
            $result = $openai->chat($message, $context);
            
            if ($result['success']) {
                // Save to history
                $history[] = ['role' => 'user', 'content' => $message];
                $history[] = ['role' => 'assistant', 'content' => $result['message']];
                
                // Keep only last 10 messages
                if (count($history) > 10) {
                    $history = array_slice($history, -10);
                }
                
                $_SESSION['chat_history'] = $history;
                
                $response = [
                    'success' => true,
                    'message' => $result['message'],
                    'type' => 'general'
                ];
            } else {
                throw new Exception($result['error']);
            }
            break;
    }
    
    // Log chat interaction
    logChatInteraction($message, $response['message'] ?? '', $type);
    
    echo json_encode($response);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

/**
 * Format products for API response
 * @param array $products
 * @param string $language
 * @return array
 */
function formatProductsForResponse($products, $language) {
    $formatted = [];
    
    foreach ($products as $product) {
        $name_field = $language === 'ar' ? 'name_ar' : 'name_en';
        $desc_field = $language === 'ar' ? 'description_ar' : 'description_en';
        
        $formatted[] = [
            'id' => $product['id'],
            'name' => $product[$name_field] ?? $product['name_en'],
            'price' => number_format($product['price'], 2),
            'image' => $product['main_image'] ?? '/images/products/default.jpg',
            'url' => '/product.php?id=' . $product['id'],
            'in_stock' => $product['stock_quantity'] > 0,
            'description' => substr($product[$desc_field] ?? '', 0, 150) . '...'
        ];
    }
    
    return $formatted;
}

/**
 * Log chat interaction to database
 * @param string $user_message
 * @param string $ai_response
 * @param string $type
 */
function logChatInteraction($user_message, $ai_response, $type) {
    global $db;
    
    try {
        $user_id = $_SESSION['user_id'] ?? null;
        $session_id = session_id();
        
        $db->query(
            "INSERT INTO chat_logs (user_id, session_id, user_message, ai_response, chat_type, created_at) 
            VALUES (?, ?, ?, ?, ?, NOW())",
            [$user_id, $session_id, $user_message, $ai_response, $type]
        );
    } catch (Exception $e) {
        // Silent fail - don't break chat if logging fails
        error_log('Chat logging failed: ' . $e->getMessage());
    }
}
