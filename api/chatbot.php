<?php
/**
 * Chatbot API Endpoint
 * Dorsh Palestine E-Commerce
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/openai.php';
require_once __DIR__ . '/../includes/functions.php';

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'error' => 'Method not allowed'
    ]);
    exit();
}

// Get request data
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['message']) || empty(trim($input['message']))) {
    echo json_encode([
        'success' => false,
        'error' => 'Message is required'
    ]);
    exit();
}

$message = sanitizeInput($input['message']);
$action = $input['action'] ?? 'chat';
$language = $input['language'] ?? 'en';
$user_id = $input['user_id'] ?? null;

try {
    $database = new Database();
    $db = $database->getConnection();
    $openai = new OpenAI($db);
    
    switch ($action) {
        case 'search':
            // Smart product search
            $response = $openai->searchProducts($message, $language);
            break;
            
        case 'recommend':
            // Product recommendations
            if (!$user_id) {
                $response = [
                    'success' => false,
                    'error' => 'User ID required for recommendations'
                ];
            } else {
                $response = $openai->getRecommendations($user_id, $language);
            }
            break;
            
        case 'faq':
            // FAQ answers
            $response = $openai->answerFAQ($message, $language);
            break;
            
        case 'chat':
        default:
            // General chat
            $context = [];
            
            // Add cart context if user is logged in
            if ($user_id) {
                $cart = getCartItems($db, $user_id);
                if (!empty($cart)) {
                    $context['cart_items'] = count($cart);
                }
            }
            
            $response = $openai->sendMessage($message, $context);
            break;
    }
    
    // Log conversation for analytics (optional)
    if (ENABLE_CHAT_LOGGING) {
        logChatMessage($db, $user_id, $message, $response['message'] ?? '', $action);
    }
    
    echo json_encode($response);
    
} catch (Exception $e) {
    error_log("Chatbot API Error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => 'An error occurred. Please try again.'
    ]);
}

/**
 * Get cart items for user
 */
function getCartItems($db, $user_id) {
    try {
        $stmt = $db->prepare("
            SELECT c.*, p.name_en, p.price
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = :user_id
        ");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Log chat message
 */
function logChatMessage($db, $user_id, $message, $response, $action) {
    try {
        $stmt = $db->prepare("
            INSERT INTO chat_logs (user_id, message, response, action, created_at)
            VALUES (:user_id, :message, :response, :action, NOW())
        ");
        
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':response', $response);
        $stmt->bindParam(':action', $action);
        $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error logging chat: " . $e->getMessage());
    }
}
