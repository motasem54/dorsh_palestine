<?php
/**
 * Chatbot API Endpoint
 * Dorsh Palestine E-Commerce
 */

require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';
require_once '../includes/openai.php';

// Set JSON header
header('Content-Type: application/json');

// Enable CORS if needed
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get request data
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request data']);
    exit;
}

// Validate required fields
if (!isset($input['message']) || empty(trim($input['message']))) {
    http_response_code(400);
    echo json_encode(['error' => 'Message is required']);
    exit;
}

// Get parameters
$message = sanitize($input['message']);
$language = $input['language'] ?? getCurrentLanguage();
$userId = $input['user_id'] ?? null;
$conversationId = $input['conversation_id'] ?? null;

// Initialize OpenAI
$openai = new OpenAI();

try {
    // Determine intent
    $intent = detectIntent($message);
    
    $response = [];
    
    switch ($intent) {
        case 'product_search':
            // Search for products
            $result = $openai->searchProducts($message, $language);
            
            if ($result['success']) {
                $response = [
                    'type' => 'product_search',
                    'message' => $result['response'],
                    'products' => getProductsByIds($result['products']),
                    'suggestions' => getSearchSuggestions($message)
                ];
            } else {
                $response = [
                    'type' => 'error',
                    'message' => translate('chatbot_error', $language)
                ];
            }
            break;
            
        case 'faq':
            // Answer FAQ question
            $result = $openai->answerFAQ($message, $language);
            
            if ($result['success']) {
                $response = [
                    'type' => 'faq',
                    'message' => $result['answer'],
                    'related_links' => getRelatedFAQLinks($message)
                ];
            } else {
                $response = [
                    'type' => 'error',
                    'message' => translate('chatbot_error', $language)
                ];
            }
            break;
            
        case 'recommendation':
            // Get product recommendations
            if (isset($input['product_id'])) {
                $result = $openai->getRecommendations(
                    $input['product_id'],
                    $userId,
                    $language
                );
                
                if ($result['success']) {
                    $response = [
                        'type' => 'recommendation',
                        'message' => $result['explanation'],
                        'products' => getProductsByIds($result['product_ids'])
                    ];
                }
            }
            break;
            
        case 'greeting':
            $response = [
                'type' => 'greeting',
                'message' => translate('chatbot_welcome', $language),
                'quick_replies' => getQuickReplies($language)
            ];
            break;
            
        default:
            // General conversation
            $result = $openai->answerFAQ($message, $language);
            
            if ($result['success']) {
                $response = [
                    'type' => 'general',
                    'message' => $result['answer']
                ];
            } else {
                $response = [
                    'type' => 'fallback',
                    'message' => translate('chatbot_fallback', $language),
                    'contact_support' => true
                ];
            }
    }
    
    // Save conversation to database
    if ($conversationId) {
        saveConversation($conversationId, $userId, $message, $response['message']);
    }
    
    // Return response
    echo json_encode([
        'success' => true,
        'data' => $response,
        'timestamp' => time()
    ]);
    
} catch (Exception $e) {
    error_log('Chatbot Error: ' . $e->getMessage());
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Internal server error',
        'message' => translate('chatbot_error', $language)
    ]);
}

/**
 * Detect user intent from message
 */
function detectIntent($message) {
    $message = strtolower($message);
    
    // Product search keywords
    $productKeywords = ['بحث', 'ابحث', 'أبحث', 'search', 'find', 'looking for', 'need', 'want', 'منتج', 'product'];
    
    // FAQ keywords
    $faqKeywords = ['شحن', 'توصيل', 'دفع', 'إرجاع', 'shipping', 'delivery', 'payment', 'return', 'policy', 'how'];
    
    // Greeting keywords
    $greetingKeywords = ['مرحبا', 'السلام', 'hello', 'hi', 'hey', 'start'];
    
    foreach ($productKeywords as $keyword) {
        if (stripos($message, $keyword) !== false) {
            return 'product_search';
        }
    }
    
    foreach ($faqKeywords as $keyword) {
        if (stripos($message, $keyword) !== false) {
            return 'faq';
        }
    }
    
    foreach ($greetingKeywords as $keyword) {
        if (stripos($message, $keyword) !== false) {
            return 'greeting';
        }
    }
    
    return 'general';
}

/**
 * Get products by IDs
 */
function getProductsByIds($ids) {
    if (empty($ids)) {
        return [];
    }
    
    global $db;
    
    $placeholders = str_repeat('?,', count($ids) - 1) . '?';
    
    $products = $db->query(
        "SELECT id, name_en, name_ar, description_en, description_ar, 
                price, sale_price, image, slug, stock_quantity
         FROM products 
         WHERE id IN ({$placeholders})",
        $ids
    )->fetchAll();
    
    return $products;
}

/**
 * Get search suggestions
 */
function getSearchSuggestions($query) {
    // Return popular categories or related searches
    return [
        'Electronics',
        'Fashion',
        'Home & Garden',
        'Sports'
    ];
}

/**
 * Get related FAQ links
 */
function getRelatedFAQLinks($question) {
    return [
        ['title' => 'Shipping Policy', 'url' => '/shipping-policy'],
        ['title' => 'Return Policy', 'url' => '/return-policy'],
        ['title' => 'Payment Methods', 'url' => '/payment-methods']
    ];
}

/**
 * Get quick reply buttons
 */
function getQuickReplies($language) {
    if ($language === 'ar') {
        return [
            'ابحث عن منتجات',
            'معلومات الشحن',
            'طرق الدفع',
            'سياسة الإرجاع'
        ];
    }
    
    return [
        'Search Products',
        'Shipping Info',
        'Payment Methods',
        'Return Policy'
    ];
}

/**
 * Save conversation to database
 */
function saveConversation($conversationId, $userId, $userMessage, $botResponse) {
    global $db;
    
    try {
        $db->query(
            "INSERT INTO chatbot_conversations 
             (conversation_id, user_id, user_message, bot_response, created_at) 
             VALUES (?, ?, ?, ?, NOW())",
            [$conversationId, $userId, $userMessage, $botResponse]
        );
    } catch (Exception $e) {
        error_log('Failed to save conversation: ' . $e->getMessage());
    }
}
