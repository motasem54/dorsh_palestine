<?php
/**
 * OpenAI Integration
 * Dorsh Palestine E-Commerce
 */

class OpenAI {
    private $api_key;
    private $model = 'gpt-3.5-turbo';
    private $api_url = 'https://api.openai.com/v1/chat/completions';
    private $db;
    
    public function __construct($db) {
        $this->api_key = OPENAI_API_KEY;
        $this->db = $db;
    }
    
    /**
     * Send message to OpenAI
     */
    public function sendMessage($message, $context = []) {
        $system_prompt = $this->buildSystemPrompt();
        $user_message = $this->enrichMessageWithContext($message, $context);
        
        $data = [
            'model' => $this->model,
            'messages' => [
                ['role' => 'system', 'content' => $system_prompt],
                ['role' => 'user', 'content' => $user_message]
            ],
            'temperature' => 0.7,
            'max_tokens' => 500
        ];
        
        return $this->makeRequest($data);
    }
    
    /**
     * Smart product search
     */
    public function searchProducts($query, $language = 'en') {
        // Get relevant products from database
        $products = $this->getRelevantProducts($query);
        
        if (empty($products)) {
            return [
                'success' => true,
                'message' => $language == 'ar' ? 'لم نجد منتجات مطابقة' : 'No matching products found',
                'products' => []
            ];
        }
        
        // Use OpenAI to generate smart response
        $context = $this->formatProductsForAI($products);
        $prompt = $language == 'ar' ? 
            "العميل يبحث عن: {$query}. هذه المنتجات المتوفرة: {$context}. قدم توصية مختصرة ومفيدة." :
            "Customer is searching for: {$query}. Available products: {$context}. Provide a brief, helpful recommendation.";
        
        $response = $this->sendMessage($prompt);
        
        return [
            'success' => true,
            'message' => $response['message'] ?? '',
            'products' => $products
        ];
    }
    
    /**
     * Product recommendations based on user history
     */
    public function getRecommendations($user_id, $language = 'en') {
        // Get user's browsing/purchase history
        $history = $this->getUserHistory($user_id);
        
        if (empty($history)) {
            return $this->getPopularProducts();
        }
        
        // Use AI to suggest similar products
        $context = "User has viewed/purchased: " . implode(', ', $history);
        $prompt = $language == 'ar' ?
            "{$context}. اقترح منتجات مشابهة أو مكملة." :
            "{$context}. Suggest similar or complementary products.";
        
        $response = $this->sendMessage($prompt);
        
        // Get actual product recommendations
        $recommended_products = $this->findSimilarProducts($history);
        
        return [
            'success' => true,
            'message' => $response['message'] ?? '',
            'products' => $recommended_products
        ];
    }
    
    /**
     * Answer FAQ questions
     */
    public function answerFAQ($question, $language = 'en') {
        $faq_data = $this->getFAQData($language);
        
        $system_prompt = $language == 'ar' ?
            "أنت مساعد متجر دورش فلسطين. أجب عن أسئلة العملاء بشكل ودي ومفيد. {$faq_data}" :
            "You are Dorsh Palestine store assistant. Answer customer questions in a friendly and helpful manner. {$faq_data}";
        
        $data = [
            'model' => $this->model,
            'messages' => [
                ['role' => 'system', 'content' => $system_prompt],
                ['role' => 'user', 'content' => $question]
            ],
            'temperature' => 0.5,
            'max_tokens' => 300
        ];
        
        return $this->makeRequest($data);
    }
    
    /**
     * Build system prompt for general chat
     */
    private function buildSystemPrompt() {
        return "You are a helpful shopping assistant for Dorsh Palestine, an e-commerce store. "
            . "Help customers find products, answer questions about shipping, returns, and payment methods. "
            . "Be friendly, concise, and informative. If you don't know something, direct them to contact customer service.";
    }
    
    /**
     * Enrich message with context
     */
    private function enrichMessageWithContext($message, $context) {
        if (empty($context)) {
            return $message;
        }
        
        $enriched = $message . "\n\nAdditional context: " . json_encode($context);
        return $enriched;
    }
    
    /**
     * Get relevant products from database
     */
    private function getRelevantProducts($query) {
        try {
            $stmt = $this->db->prepare("
                SELECT p.*, 
                       pi.image_url as main_image,
                       c.name_en as category_name_en,
                       c.name_ar as category_name_ar
                FROM products p
                LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE (p.name_en LIKE :query OR p.name_ar LIKE :query 
                       OR p.description_en LIKE :query OR p.description_ar LIKE :query
                       OR c.name_en LIKE :query OR c.name_ar LIKE :query)
                AND p.status = 'active'
                AND p.stock_quantity > 0
                LIMIT 10
            ");
            
            $searchTerm = "%{$query}%";
            $stmt->bindParam(':query', $searchTerm);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error searching products: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Format products for AI context
     */
    private function formatProductsForAI($products) {
        $formatted = [];
        foreach ($products as $product) {
            $formatted[] = "{$product['name_en']} - {$product['price']} USD - {$product['description_en']}";
        }
        return implode('; ', $formatted);
    }
    
    /**
     * Get user's browsing/purchase history
     */
    private function getUserHistory($user_id) {
        try {
            $stmt = $this->db->prepare("
                SELECT DISTINCT p.name_en, p.name_ar, c.name_en as category
                FROM order_items oi
                JOIN orders o ON oi.order_id = o.id
                JOIN products p ON oi.product_id = p.id
                JOIN categories c ON p.category_id = c.id
                WHERE o.user_id = :user_id
                ORDER BY o.created_at DESC
                LIMIT 5
            ");
            
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return array_column($results, 'name_en');
        } catch (PDOException $e) {
            error_log("Error getting user history: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Find similar products based on history
     */
    private function findSimilarProducts($history) {
        if (empty($history)) {
            return [];
        }
        
        try {
            // Simple approach: find products in same categories
            $placeholders = str_repeat('?,', count($history) - 1) . '?';
            $stmt = $this->db->prepare("
                SELECT DISTINCT p.*, pi.image_url as main_image
                FROM products p
                LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
                WHERE p.category_id IN (
                    SELECT DISTINCT category_id FROM products 
                    WHERE name_en IN ({$placeholders})
                )
                AND p.status = 'active'
                AND p.stock_quantity > 0
                ORDER BY p.created_at DESC
                LIMIT 6
            ");
            
            $stmt->execute($history);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error finding similar products: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get popular products
     */
    private function getPopularProducts() {
        try {
            $stmt = $this->db->query("
                SELECT p.*, pi.image_url as main_image,
                       COUNT(oi.id) as order_count
                FROM products p
                LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
                LEFT JOIN order_items oi ON p.id = oi.product_id
                WHERE p.status = 'active' AND p.stock_quantity > 0
                GROUP BY p.id
                ORDER BY order_count DESC, p.created_at DESC
                LIMIT 6
            ");
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting popular products: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get FAQ data
     */
    private function getFAQData($language = 'en') {
        return $language == 'ar' ?
            "معلومات المتجر: الشحن مجاني للطلبات فوق 50د, الدفع عند الاستلام متاح, الإرجاع خلال 7 أيام" :
            "Store info: Free shipping over $50, Cash on delivery available, 7-day return policy";
    }
    
    /**
     * Make API request to OpenAI
     */
    private function makeRequest($data) {
        $ch = curl_init($this->api_url);
        
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->api_key
            ],
            CURLOPT_TIMEOUT => 30
        ]);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            error_log("OpenAI API Error: " . $error);
            return [
                'success' => false,
                'error' => 'Connection error'
            ];
        }
        
        if ($http_code !== 200) {
            error_log("OpenAI API returned code: " . $http_code);
            return [
                'success' => false,
                'error' => 'API error'
            ];
        }
        
        $result = json_decode($response, true);
        
        if (!isset($result['choices'][0]['message']['content'])) {
            return [
                'success' => false,
                'error' => 'Invalid response'
            ];
        }
        
        return [
            'success' => true,
            'message' => $result['choices'][0]['message']['content']
        ];
    }
}
