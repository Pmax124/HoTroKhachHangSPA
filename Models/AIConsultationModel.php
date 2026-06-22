<?php
class AIConsultationModel {
    protected $db;
    protected $apiKey;
    protected $baseUrl = 'https://api.groq.com/openai/v1/chat/completions';
    
    public function __construct() {
        $this->db = Database::getInstance();
        $this->apiKey = '';
    }
    
    /**
     * AI tư vấn liệu trình dựa trên database
     */
    public function getAIRecommendation($symptoms, $skinType = null, $budget = null, $history = null) {
        // 1. Lấy toàn bộ dịch vụ từ database
        $services = $this->db->query("
            SELECT s.*, c.name as category_name 
            FROM services s 
            LEFT JOIN categories c ON s.category_id = c.id 
            WHERE s.status = 'active'
        ");
        
        // 2. Xây dựng danh sách dịch vụ cho AI
        $serviceList = [];
        foreach ($services as $service) {
            $serviceList[] = [
                'id' => $service['id'],
                'name' => $service['name'],
                'category' => $service['category_name'],
                'description' => $service['description'],
                'benefits' => $service['benefits'],
                'suitable_for' => $service['suitable_for'],
                'price' => $service['discount_price'] ?? $service['price'],
                'duration' => $service['duration']
            ];
        }
        
        // 3. Tạo prompt hệ thống với thông tin database
        $systemPrompt = $this->buildSystemPrompt($serviceList);
        $userPrompt = $this->buildUserPrompt($symptoms, $skinType, $budget, $history);
        
        // 4. Gọi Groq API
        $response = $this->callGroqAPI($systemPrompt, $userPrompt);
        
        // 5. Xử lý response
        return $this->processResponse($response);
    }
    
    /**
     * Xây dựng prompt hệ thống
     */
    protected function buildSystemPrompt($services) {
        $servicesJson = json_encode($services, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        
        return "Bạn là Chuyên Gia Tư Vấn Liệu Trình Spa AI với kiến thức sâu rộng về da liễu và spa trị liệu.

DANH SÁCH DỊCH VỤ CÓ SẴN TRONG DATABASE:
{$servicesJson}

NHIỆM VỤ CỦA BẠN:
1. Phân tích triệu chứng/vấn đề da khách hàng mô tả
2. Đề xuất 2-3 liệu trình phù hợp nhất từ danh sách trên
3. Xây dựng LỘ TRÌNH ĐIỀU TRỊ chi tiết (nhiều buổi, có thời gian cụ thể)
4. Giải thích lý do khoa học
5. Ước tính chi phí và thời gian

YÊU CẦU TRẢ VỀ JSON CHUẨN:
{
  \"diagnosis\": \"Chẩn đoán vấn đề da ngắn gọn\",
  \"severity\": \"Nhẹ/Trung bình/Nặng\",
  \"recommended_services\": [list service IDs],
  \"treatment_route\": {
    \"phase1\": \"Giai đoạn 1: Mục tiêu + Liệu trình + Tần suất + Thời lượng\",
    \"phase2\": \"Giai đoạn 2: ...\",
    \"phase3\": \"Giai đoạn 3: ...\",
    \"total_sessions\": số buổi,
    \"total_duration\": \"Tổng thời gian ước tính\",
    \"frequency\": \"Tần suất điều trị\"
  },
  \"estimated_cost\": \"Tổng chi phí VND\",
  \"expert_advice\": \"Lời khuyên chuyên gia chi tiết\",
  \"precautions\": \"Lưu ý khi điều trị\",
  \"expected_results\": \"Kết quả mong đợi\"
}

QUAN TRỌNG:
- Chỉ đề xuất dịch vụ CÓ TRONG DANH SÁCH trên
- Không bịa ra dịch vụ mới
- Trả về JSON hợp lệ, không thêm text thừa
- Sử dụng tiếng Việt";
    }
    
    /**
     * Xây dựng prompt người dùng
     */
    protected function buildUserPrompt($symptoms, $skinType, $budget, $history) {
        $prompt = "Thông tin khách hàng:\n";
        $prompt .= "- Vấn đề/Triệu chứng: {$symptoms}\n";
        
        if ($skinType) {
            $prompt .= "- Loại da: {$skinType}\n";
        }
        
        if ($budget) {
            $prompt .= "- Ngân sách: {$budget}\n";
        }
        
        if ($history) {
            $prompt .= "- Lịch sử tư vấn: {$history}\n";
        }
        
        $prompt .= "\nHãy phân tích và tư vấn lộ trình điều trị chi tiết.";
        
        return $prompt;
    }
    
    /**
     * Gọi Groq API
     */
    protected function callGroqAPI($systemPrompt, $userPrompt) {
        $data = [
            'model' => 'llama-3.3-70b-versatile', // Hoặc 'mixtral-8x7b-32768'
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $userPrompt]
            ],
            'temperature' => 0.7,
            'max_tokens' => 2048,
            'response_format' => ['type' => 'json_object']
        ];
        
        $ch = curl_init($this->baseUrl);
        
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey
            ],
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => false
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        curl_close($ch);
        
        if ($error || $httpCode !== 200) {
            return [
                'error' => true,
                'message' => $error ?: "HTTP Error: {$httpCode}",
                'success' => false
            ];
        }
        
        return json_decode($response, true);
    }
    
    /**
     * Xử lý response từ AI
     */
    protected function processResponse($response) {
        if (isset($response['error'])) {
            return $response;
        }
        
        if (!isset($response['choices'][0]['message']['content'])) {
            return [
                'success' => false,
                'message' => 'AI không trả lời. Vui lòng thử lại.'
            ];
        }
        
        $content = $response['choices'][0]['message']['content'];
        
        // Parse JSON
        try {
            // Loại bỏ markdown nếu có
            $content = preg_replace('/```json\s?/', '', $content);
            $content = preg_replace('/```\s?/', '', $content);
            
            $data = json_decode($content, true);
            
            if (!$data || !isset($data['recommended_services'])) {
                throw new Exception('Invalid JSON');
            }
            
            // Lấy thông tin dịch vụ từ database
            $recommendedServices = $this->getServicesByIds($data['recommended_services']);
            
            return [
                'success' => true,
                'diagnosis' => $data['diagnosis'] ?? '',
                'severity' => $data['severity'] ?? '',
                'message' => $data['expert_advice'] ?? '',
                'treatment_route' => $data['treatment_route'] ?? null,
                'estimated_cost' => $data['estimated_cost'] ?? '',
                'precautions' => $data['precautions'] ?? '',
                'expected_results' => $data['expected_results'] ?? '',
                'services' => $recommendedServices,
                'raw_response' => $content
            ];
            
        } catch (Exception $e) {
            // Fallback: trả về text thô
            return [
                'success' => true,
                'message' => $content,
                'services' => [],
                'raw_response' => $content
            ];
        }
    }
    
  /**
 * Lấy dịch vụ theo IDs
 */
protected function getServicesByIds($ids) {
    if (empty($ids) || !is_array($ids)) return [];
    
    // Lọc chỉ lấy ID hợp lệ
    $ids = array_filter($ids, 'is_numeric');
    if (empty($ids)) return [];
    
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    
    // ✅ THÊM subquery lấy ảnh từ service_images
    return $this->db->query("
        SELECT s.*, c.name as category_name,
        (SELECT si.image_path FROM service_images si 
         WHERE si.service_id = s.id 
         ORDER BY si.id ASC 
         LIMIT 1) as main_image
        FROM services s 
        LEFT JOIN categories c ON s.category_id = c.id 
        WHERE s.id IN ($placeholders) AND s.status = 'active'
    ", $ids);
}
    
    /**
     * Lưu lịch sử tư vấn
     */
    public function saveConsultation($data) {
        return $this->db->execute(
            "INSERT INTO ai_consultations (customer_id, session_id, user_message, ai_response, recommended_services) 
             VALUES (?, ?, ?, ?, ?)",
            [
                $data['customer_id'] ?? null,
                $data['session_id'],
                $data['user_message'],
                json_encode($data['ai_response'] ?? []),
                json_encode($data['recommended_services'] ?? [])
            ]
        );
    }
    
    /**
     * Lấy lịch sử tư vấn
     */
  /**
 * Lấy lịch sử tư vấn
 */
public function getConsultationHistory($customerId, $limit = 5) {
    $limit = (int)$limit;
    
    return $this->db->query(
        "SELECT * FROM ai_consultations 
         WHERE customer_id = ? 
         ORDER BY created_at DESC 
         LIMIT {$limit}",
        [$customerId]
    );
}
}