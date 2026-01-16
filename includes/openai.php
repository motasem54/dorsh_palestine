<?php
/**
 * OpenAI Integration
 * Handles AI chatbot and smart product search
 */

class OpenAI {
    private $api_key;
    private $model;
    private $db;
    
    public function __construct($db) {
        $this->api_key = OPENAI_API_KEY;
        $this->model = OPENAI_MODEL;
        $this->db = $db;
    }
    
    /**
     * Send chat completion request to OpenAI
     */
    public function chat($messages, $temperature = 0.7, $max_tokens = 800) {
        $url = 'https://api.openai.com/v1/chat/completions';
        
        $data = [
            'model' => $this->model,
            'messages' => $messages,
            'temperature' => $temperature,
            'max_tokens' => $max_tokens
        ];
        
        $ch = curl_init($url);
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
            return [
                'success' => false,
                'error' => 'OpenAI API error: ' . $http_code
            ];
        }
        
        $result = json_decode($response, true);
        
        return [
            'success' => true,
            'message' => $result['choices'][0]['message']['content'] ?? '',
            'usage' => $result['usage'] ?? []
        ];
    }
    
    /**
     * Smart product search using AI
     */
    public function searchProducts($query, $lang = 'en') {
        // Get products from database
        $products = $this->getProductsContext();
        
        // Create system message
        $system_message = $this->getSystemMessage($lang);
        
        // Build messages array
        $messages = [
            ['role' => 'system', 'content' => $system_message],
            ['role' => 'system', 'content' => "Available products:\n" . json_encode($products, JSON_UNESCAPED_UNICODE)],
            ['role' => 'user', 'content' => $query]
        ];
        
        $response = $this->chat($messages, 0.3, 600);
        
        if (!$response['success']) {
            return $response;
        }
        
        // Parse AI response to extract product IDs
        $product_ids = $this->extractProductIds($response['message']);
        
        return [
            'success' => true,
            'message' => $response['message'],
            'products' => $product_ids,
            'usage' => $response['usage']
        ];
    }
    
    /**
     * Get product recommendations
     */
    public function getRecommendations($product_id, $user_history = [], $lang = 'en') {
        // Get product details
        $stmt = $this->db->prepare("
            SELECT p.*, c.name_en, c.name_ar 
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.id = ?
        ");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();
        
        if (!$product) {
            return ['success' => false, 'error' => 'Product not found'];
        }
        
        // Get similar products
        $similar_products = $this->getSimilarProducts($product['category_id'], $product_id);
        
        // Create recommendation prompt
        $prompt = $this->buildRecommendationPrompt($product, $similar_products, $user_history, $lang);
        
        $messages = [
            ['role' => 'system', 'content' => $this->getSystemMessage($lang)],
            ['role' => 'user', 'content' => $prompt]
        ];
        
        $response = $this->chat($messages, 0.5, 400);
        
        return $response;
    }
    
    /**
     * Answer FAQ questions
     */
    public function answerFAQ($question, $lang = 'en') {
        $faq_context = $this->getFAQContext($lang);
        
        $messages = [
            ['role' => 'system', 'content' => $this->getSystemMessage($lang)],
            ['role' => 'system', 'content' => "FAQ Information:\n" . $faq_context],
            ['role' => 'user', 'content' => $question]
        ];
        
        return $this->chat($messages, 0.4, 500);
    }
    
    /**
     * General customer support
     */
    public function handleCustomerQuery($query, $conversation_history = [], $lang = 'en') {
        $messages = [
            ['role' => 'system', 'content' => $this->getSystemMessage($lang)]
        ];
        
        // Add conversation history
        foreach ($conversation_history as $msg) {
            $messages[] = $msg;
        }
        
        // Add current query
        $messages[] = ['role' => 'user', 'content' => $query];
        
        return $this->chat($messages);
    }
    
    /**
     * Get system message based on language
     */
    private function getSystemMessage($lang) {
        global $current_lang;
        $lang = $lang ?: $current_lang;
        
        if ($lang === 'ar') {
            return "أنت مساعد ذكي لمتجر Dorsh Palestine الإلكتروني. مهمتك مساعدة العملاء في:
- البحث عن المنتجات المناسبة
- تقديم توصيات ذكية
- الإجابة على الأسئلة الشائعة
- مساعدة العملاء في إتمام عملية الشراء

كن ودوداً، محترفاً، ومفيداً. أجب باللغة العربية بشكل واضح ومختصر.
إذا سأل العميل عن منتج، ابحث في قائمة المنتجات المتوفرة واقترح الأنسب.
إذا لم تجد المعلومة، اعتذر بأدب ووجه العميل للتواصل مع خدمة العملاء.";
        } else {
            return "You are an AI assistant for Dorsh Palestine e-commerce store. Your role is to help customers with:
- Finding the right products
- Providing smart recommendations
- Answering frequently asked questions
- Assisting with the purchase process

Be friendly, professional, and helpful. Answer in English clearly and concisely.
If asked about a product, search the available product list and suggest the most suitable ones.
If you don't have the information, politely apologize and direct the customer to customer service.";
        }
    }
    
    /**
     * Get products context for AI
     */
    private function getProductsContext($limit = 50) {
        $stmt = $this->db->query("
            SELECT 
                p.id, 
                p.name_en, 
                p.name_ar, 
                p.description_en, 
                p.description_ar,
                p.price,
                p.stock_quantity,
                c.name_en as category_en,
                c.name_ar as category_ar
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.status = 'active'
            ORDER BY p.created_at DESC
            LIMIT $limit
        ");
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get similar products
     */
    private function getSimilarProducts($category_id, $exclude_id, $limit = 10) {
        $stmt = $this->db->prepare("
            SELECT id, name_en, name_ar, price, description_en, description_ar
            FROM products
            WHERE category_id = ? AND id != ? AND status = 'active'
            LIMIT $limit
        ");
        $stmt->execute([$category_id, $exclude_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Build recommendation prompt
     */
    private function buildRecommendationPrompt($product, $similar_products, $user_history, $lang) {
        $name = $lang === 'ar' ? $product['name_ar'] : $product['name_en'];
        
        if ($lang === 'ar') {
            $prompt = "بناءً على المنتج التالي: $name\n";
            $prompt .= "والمنتجات المشابهة المتاحة:\n";
            $prompt .= json_encode($similar_products, JSON_UNESCAPED_UNICODE);
            $prompt .= "\n\nقدم توصيات ذكية للعميل (3-5 منتجات) مع شرح مختصر لكل منتج.";
        } else {
            $prompt = "Based on the product: $name\n";
            $prompt .= "And similar available products:\n";
            $prompt .= json_encode($similar_products);
            $prompt .= "\n\nProvide smart recommendations (3-5 products) with brief explanation for each.";
        }
        
        return $prompt;
    }
    
    /**
     * Get FAQ context
     */
    private function getFAQContext($lang) {
        if ($lang === 'ar') {
            return "
# معلومات الشحن
- نوفر الشحن لجميع مدن فلسطين
- مدة التوصيل: 2-5 أيام عمل
- الشحن مجاني للطلبات فوق 200 شيكل
- تكلفة الشحن العادية: 15 شيكل

# سياسة الإرجاع
- يمكن إرجاع المنتج خلال 14 يوم
- يجب أن يكون المنتج بحالته الأصلية
- سيتم استرداد المبلغ خلال 7-10 أيام

# طرق الدفع
- الدفع عند الاستلام
- بطاقات الائتمان (Visa, Mastercard)
- PayPal

# التواصل
- الهاتف: +970-XXX-XXXX
- البريد: support@dorsh.ps
- واتساب: متاح 24/7
            ";
        } else {
            return "
# Shipping Information
- We deliver to all Palestinian cities
- Delivery time: 2-5 business days
- Free shipping for orders over 200 ILS
- Standard shipping cost: 15 ILS

# Return Policy
- Products can be returned within 14 days
- Product must be in original condition
- Refund processed within 7-10 days

# Payment Methods
- Cash on Delivery
- Credit Cards (Visa, Mastercard)
- PayPal

# Contact
- Phone: +970-XXX-XXXX
- Email: support@dorsh.ps
- WhatsApp: Available 24/7
            ";
        }
    }
    
    /**
     * Extract product IDs from AI response
     */
    private function extractProductIds($message) {
        // Try to find product IDs in the response
        preg_match_all('/\b(id|product)[:\s]*(\d+)/i', $message, $matches);
        return array_unique($matches[2] ?? []);
    }
}
