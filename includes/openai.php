<?php
/**
 * OpenAI Integration
 * Dorsh Palestine E-Commerce
 */

class OpenAI {
    private $apiKey;
    private $model;
    private $baseUrl = 'https://api.openai.com/v1';
    
    public function __construct() {
        $this->apiKey = OPENAI_API_KEY;
        $this->model = OPENAI_MODEL ?? 'gpt-3.5-turbo';
    }
    
    /**
     * Send chat completion request to OpenAI
     */
    public function chat($messages, $temperature = 0.7, $maxTokens = 500) {
        $url = $this->baseUrl . '/chat/completions';
        
        $data = [
            'model' => $this->model,
            'messages' => $messages,
            'temperature' => $temperature,
            'max_tokens' => $maxTokens
        ];
        
        return $this->makeRequest($url, $data);
    }
    
    /**
     * Search products using AI
     */
    public function searchProducts($query, $language = 'en') {
        global $db;
        
        // Get product context
        $products = $this->getProductContext();
        
        $systemMessage = [
            'role' => 'system',
            'content' => "You are a helpful shopping assistant for Dorsh Palestine e-commerce store. 
            You help customers find products based on their needs. 
            Language: {$language}
            Available products: " . json_encode($products) . "
            
            When suggesting products, provide:
            1. Product name
            2. Brief description
            3. Price
            4. Why it matches their needs
            
            Always respond in {$language} language (Arabic if 'ar', English if 'en')."
        ];
        
        $userMessage = [
            'role' => 'user',
            'content' => $query
        ];
        
        $response = $this->chat([$systemMessage, $userMessage]);
        
        if ($response && isset($response['choices'][0]['message']['content'])) {
            return [
                'success' => true,
                'response' => $response['choices'][0]['message']['content'],
                'products' => $this->extractProductIds($response['choices'][0]['message']['content'], $products)
            ];
        }
        
        return [
            'success' => false,
            'error' => 'Failed to get AI response'
        ];
    }
    
    /**
     * Get product recommendations
     */
    public function getRecommendations($productId, $userId = null, $language = 'en') {
        global $db;
        
        // Get current product details
        $product = $db->query(
            "SELECT * FROM products WHERE id = ?",
            [$productId]
        )->fetch();
        
        if (!$product) {
            return ['success' => false, 'error' => 'Product not found'];
        }
        
        // Get user's browsing history if available
        $userHistory = [];
        if ($userId) {
            $userHistory = $this->getUserHistory($userId);
        }
        
        // Get similar products
        $similarProducts = $db->query(
            "SELECT * FROM products 
             WHERE category_id = ? 
             AND id != ? 
             AND stock_quantity > 0 
             LIMIT 10",
            [$product['category_id'], $productId]
        )->fetchAll();
        
        $systemMessage = [
            'role' => 'system',
            'content' => "You are a product recommendation AI for an e-commerce store.
            Current product: " . json_encode($product) . "
            Similar products: " . json_encode($similarProducts) . "
            User history: " . json_encode($userHistory) . "
            
            Recommend 3-5 products that would complement or be alternatives to the current product.
            Consider user's browsing history if available.
            Return product IDs as a JSON array."
        ];
        
        $response = $this->chat([$systemMessage]);
        
        if ($response && isset($response['choices'][0]['message']['content'])) {
            $content = $response['choices'][0]['message']['content'];
            $productIds = $this->extractProductIdsFromJson($content);
            
            return [
                'success' => true,
                'product_ids' => $productIds,
                'explanation' => $content
            ];
        }
        
        // Fallback to similar products
        return [
            'success' => true,
            'product_ids' => array_column($similarProducts, 'id'),
            'explanation' => 'Similar products from the same category'
        ];
    }
    
    /**
     * Answer FAQ questions
     */
    public function answerFAQ($question, $language = 'en') {
        $faqContext = $this->getFAQContext();
        $siteInfo = $this->getSiteInfo();
        
        $systemMessage = [
            'role' => 'system',
            'content' => "You are a customer service assistant for Dorsh Palestine e-commerce store.
            
            Store Information:
            " . json_encode($siteInfo) . "
            
            FAQ Database:
            " . json_encode($faqContext) . "
            
            Answer customer questions about:
            - Shipping and delivery
            - Payment methods
            - Return policy
            - Product availability
            - Order tracking
            
            Always respond in {$language} language.
            Be helpful, friendly, and professional."
        ];
        
        $userMessage = [
            'role' => 'user',
            'content' => $question
        ];
        
        $response = $this->chat([$systemMessage, $userMessage]);
        
        if ($response && isset($response['choices'][0]['message']['content'])) {
            return [
                'success' => true,
                'answer' => $response['choices'][0]['message']['content']
            ];
        }
        
        return [
            'success' => false,
            'error' => 'Failed to get answer'
        ];
    }
    
    /**
     * Generate product descriptions
     */
    public function generateProductDescription($productData, $language = 'en') {
        $systemMessage = [
            'role' => 'system',
            'content' => "You are a professional product description writer for an e-commerce store.
            Generate an engaging, SEO-friendly product description.
            Language: {$language}
            
            Product Details:
            " . json_encode($productData) . "
            
            Include:
            - Main features and benefits
            - Key specifications
            - Use cases
            - Call to action
            
            Keep it concise (100-150 words) and compelling."
        ];
        
        $response = $this->chat([$systemMessage], 0.8, 300);
        
        if ($response && isset($response['choices'][0]['message']['content'])) {
            return [
                'success' => true,
                'description' => $response['choices'][0]['message']['content']
            ];
        }
        
        return [
            'success' => false,
            'error' => 'Failed to generate description'
        ];
    }
    
    /**
     * Make HTTP request to OpenAI API
     */
    private function makeRequest($url, $data) {
        $ch = curl_init($url);
        
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey
            ]
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            error_log("OpenAI API Error: HTTP {$httpCode} - {$response}");
            return null;
        }
        
        return json_decode($response, true);
    }
    
    /**
     * Get product context for AI
     */
    private function getProductContext($limit = 50) {
        global $db;
        
        $products = $db->query(
            "SELECT id, name_en, name_ar, description_en, description_ar, 
                    price, sale_price, category_id, stock_quantity
             FROM products 
             WHERE stock_quantity > 0 
             ORDER BY created_at DESC 
             LIMIT ?",
            [$limit]
        )->fetchAll();
        
        return $products;
    }
    
    /**
     * Get user browsing history
     */
    private function getUserHistory($userId) {
        global $db;
        
        $history = $db->query(
            "SELECT p.id, p.name_en, p.name_ar, p.category_id
             FROM product_views pv
             JOIN products p ON pv.product_id = p.id
             WHERE pv.user_id = ?
             ORDER BY pv.viewed_at DESC
             LIMIT 10",
            [$userId]
        )->fetchAll();
        
        return $history;
    }
    
    /**
     * Get FAQ context
     */
    private function getFAQContext() {
        return [
            'shipping' => [
                'delivery_time' => '3-5 business days within Palestine',
                'shipping_cost' => 'Free shipping on orders over 200 ILS',
                'international' => 'Currently shipping within Palestine only'
            ],
            'payment' => [
                'methods' => ['Credit Card', 'PayPal', 'Cash on Delivery'],
                'security' => 'SSL encrypted secure payment',
                'currency' => 'ILS (Israeli Shekel)'
            ],
            'returns' => [
                'policy' => '30-day return policy',
                'condition' => 'Items must be unused and in original packaging',
                'refund_time' => '7-10 business days after return received'
            ]
        ];
    }
    
    /**
     * Get site information
     */
    private function getSiteInfo() {
        return [
            'name' => 'Dorsh Palestine',
            'email' => SITE_EMAIL,
            'phone' => SITE_PHONE ?? '+970-XXX-XXXX',
            'address' => 'Palestine',
            'business_hours' => 'Sunday - Thursday: 9 AM - 6 PM',
            'support_whatsapp' => WHATSAPP_NUMBER ?? '+970-XXX-XXXX'
        ];
    }
    
    /**
     * Extract product IDs from AI response
     */
    private function extractProductIds($content, $products) {
        $productIds = [];
        
        foreach ($products as $product) {
            // Check if product name is mentioned
            if (stripos($content, $product['name_en']) !== false || 
                stripos($content, $product['name_ar']) !== false) {
                $productIds[] = $product['id'];
            }
        }
        
        return $productIds;
    }
    
    /**
     * Extract product IDs from JSON response
     */
    private function extractProductIdsFromJson($content) {
        // Try to extract JSON array
        preg_match('/\[([0-9,\s]+)\]/', $content, $matches);
        
        if (isset($matches[1])) {
            $ids = explode(',', $matches[1]);
            return array_map('trim', $ids);
        }
        
        return [];
    }
}
