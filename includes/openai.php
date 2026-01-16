<?php
/**
 * OpenAI Integration Class
 * Smart Chatbot & Product Search Assistant
 */

class OpenAI {
    private $api_key;
    private $model = 'gpt-4-turbo-preview';
    private $api_url = 'https://api.openai.com/v1/chat/completions';
    private $max_tokens = 500;
    private $temperature = 0.7;
    
    public function __construct() {
        $this->api_key = Config::get('openai_api_key');
    }
    
    /**
     * Send chat message to OpenAI
     * @param string $message User message
     * @param array $context Additional context
     * @return array Response
     */
    public function chat($message, $context = []) {
        try {
            // Build system message
            $system_message = $this->buildSystemMessage($context);
            
            // Prepare messages
            $messages = [
                ['role' => 'system', 'content' => $system_message],
                ['role' => 'user', 'content' => $message]
            ];
            
            // Add conversation history if provided
            if (isset($context['history']) && is_array($context['history'])) {
                array_splice($messages, 1, 0, $context['history']);
            }
            
            // Make API request
            $response = $this->makeRequest($messages);
            
            return [
                'success' => true,
                'message' => $response['choices'][0]['message']['content'],
                'tokens_used' => $response['usage']['total_tokens'] ?? 0
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Search products using AI
     * @param string $query Search query
     * @param string $language Current language
     * @return array Relevant products
     */
    public function searchProducts($query, $language = 'en') {
        global $db;
        
        try {
            // Get product embeddings or use simple search
            $products = $this->getRelevantProducts($query);
            
            // Format products for AI context
            $products_context = $this->formatProductsForAI($products);
            
            // Ask AI to analyze and recommend
            $context = [
                'type' => 'product_search',
                'products' => $products_context,
                'language' => $language
            ];
            
            $ai_message = "The user is searching for: {$query}. Based on the available products, recommend the most relevant ones and explain why.";
            
            $response = $this->chat($ai_message, $context);
            
            return [
                'success' => true,
                'products' => $products,
                'ai_response' => $response['message'] ?? '',
                'query' => $query
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Get product recommendations
     * @param int $product_id Current product ID
     * @param string $language Language
     * @return array Recommended products
     */
    public function getRecommendations($product_id, $language = 'en') {
        global $db;
        
        try {
            // Get current product details
            $product = $db->query(
                "SELECT * FROM products WHERE id = ? AND status = 'active'",
                [$product_id]
            )->fetch();
            
            if (!$product) {
                throw new Exception('Product not found');
            }
            
            // Get similar products
            $similar_products = $db->query(
                "SELECT * FROM products 
                WHERE category_id = ? 
                AND id != ? 
                AND status = 'active' 
                LIMIT 10",
                [$product['category_id'], $product_id]
            )->fetchAll();
            
            // Ask AI for smart recommendations
            $context = [
                'type' => 'recommendations',
                'current_product' => $product,
                'similar_products' => $this->formatProductsForAI($similar_products),
                'language' => $language
            ];
            
            $ai_message = "Based on the current product, recommend the best matching products from the similar products list.";
            
            $response = $this->chat($ai_message, $context);
            
            return [
                'success' => true,
                'products' => array_slice($similar_products, 0, 4),
                'ai_explanation' => $response['message'] ?? ''
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Answer FAQ questions
     * @param string $question User question
     * @param string $language Language
     * @return array Answer
     */
    public function answerFAQ($question, $language = 'en') {
        try {
            $context = [
                'type' => 'faq',
                'language' => $language,
                'store_info' => [
                    'name' => 'Dorsh Palestine',
                    'location' => 'Palestine',
                    'shipping' => 'We ship within Palestine',
                    'payment' => 'We accept PayPal, Credit Cards',
                    'return_policy' => '14 days return policy',
                    'support' => 'WhatsApp support available'
                ]
            ];
            
            $response = $this->chat($question, $context);
            
            return [
                'success' => true,
                'answer' => $response['message'] ?? '',
                'question' => $question
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Build system message based on context
     * @param array $context
     * @return string
     */
    private function buildSystemMessage($context) {
        $language = $context['language'] ?? 'en';
        $type = $context['type'] ?? 'general';
        
        $system_messages = [
            'en' => [
                'general' => "You are a helpful shopping assistant for Dorsh Palestine e-commerce store. Be friendly, concise, and helpful. Answer in English.",
                'product_search' => "You are a product recommendation expert for Dorsh Palestine. Analyze user queries and recommend the most relevant products. Be specific and explain your recommendations. Answer in English.",
                'recommendations' => "You are a product recommendation specialist. Based on the current product, suggest complementary or similar items that the customer might be interested in. Answer in English.",
                'faq' => "You are a customer service representative for Dorsh Palestine. Answer questions about shipping, payments, returns, and store policies clearly and professionally. Answer in English."
            ],
            'ar' => [
                'general' => "أنت مساعد تسوق مفيد لمتجر دورش فلسطين الإلكتروني. كن ودوداً ومختصراً ومفيداً. أجب بالعربية.",
                'product_search' => "أنت خبير في التوصية بالمنتجات لمتجر دورش فلسطين. حلل استفسارات المستخدمين وأوصِ بالمنتجات الأكثر صلة. كن محدداً واشرح توصياتك. أجب بالعربية.",
                'recommendations' => "أنت متخصص في التوصية بالمنتجات. بناءً على المنتج الحالي، اقترح منتجات تكميلية أو مشابهة قد تهم العميل. أجب بالعربية.",
                'faq' => "أنت ممثل خدمة العملاء لمتجر دورش فلسطين. أجب عن الأسئلة المتعلقة بالشحن والدفع والإرجاع وسياسات المتجر بوضوح واحترافية. أجب بالعربية."
            ]
        ];
        
        $base_message = $system_messages[$language][$type] ?? $system_messages['en']['general'];
        
        // Add products context if available
        if (isset($context['products']) && !empty($context['products'])) {
            $base_message .= "\n\nAvailable products: " . $context['products'];
        }
        
        // Add store info for FAQ
        if ($type === 'faq' && isset($context['store_info'])) {
            $store_info = json_encode($context['store_info'], JSON_UNESCAPED_UNICODE);
            $base_message .= "\n\nStore Information: " . $store_info;
        }
        
        return $base_message;
    }
    
    /**
     * Make API request to OpenAI
     * @param array $messages
     * @return array
     */
    private function makeRequest($messages) {
        $data = [
            'model' => $this->model,
            'messages' => $messages,
            'max_tokens' => $this->max_tokens,
            'temperature' => $this->temperature
        ];
        
        $ch = curl_init($this->api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->api_key
        ]);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code !== 200) {
            throw new Exception('OpenAI API request failed with code: ' . $http_code);
        }
        
        $result = json_decode($response, true);
        
        if (!isset($result['choices'])) {
            throw new Exception('Invalid OpenAI API response');
        }
        
        return $result;
    }
    
    /**
     * Get relevant products based on query
     * @param string $query
     * @return array
     */
    private function getRelevantProducts($query) {
        global $db;
        
        // Simple text search (can be enhanced with vector embeddings)
        $search_term = '%' . $query . '%';
        
        $products = $db->query(
            "SELECT p.*, c.name_en as category_name_en, c.name_ar as category_name_ar
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE (p.name_en LIKE ? OR p.name_ar LIKE ? 
                   OR p.description_en LIKE ? OR p.description_ar LIKE ?)
            AND p.status = 'active'
            LIMIT 10",
            [$search_term, $search_term, $search_term, $search_term]
        )->fetchAll();
        
        return $products;
    }
    
    /**
     * Format products for AI context
     * @param array $products
     * @return string
     */
    private function formatProductsForAI($products) {
        $formatted = [];
        
        foreach ($products as $product) {
            $formatted[] = sprintf(
                "[ID: %d] %s - %s (Price: $%.2f, Category: %s)",
                $product['id'],
                $product['name_en'] ?? '',
                $product['name_ar'] ?? '',
                $product['price'],
                $product['category_name_en'] ?? $product['category_name_ar'] ?? 'N/A'
            );
        }
        
        return implode("\n", $formatted);
    }
    
    /**
     * Set model
     * @param string $model
     */
    public function setModel($model) {
        $this->model = $model;
    }
    
    /**
     * Set max tokens
     * @param int $tokens
     */
    public function setMaxTokens($tokens) {
        $this->max_tokens = $tokens;
    }
    
    /**
     * Set temperature
     * @param float $temperature
     */
    public function setTemperature($temperature) {
        $this->temperature = $temperature;
    }
}
