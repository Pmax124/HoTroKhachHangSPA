<?php
class ReviewModel {
    protected $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Thêm đánh giá mới
     */
    public function addReview($data) {
        try {
            $sql = "INSERT INTO reviews 
                    (customer_id, service_id, staff_id, appointment_id, rating, comment, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, NOW())";
            
            $params = [
                (int)$data['customer_id'],
                (int)$data['service_id'],
                !empty($data['staff_id']) ? (int)$data['staff_id'] : null,
                !empty($data['appointment_id']) ? (int)$data['appointment_id'] : null,
                (int)$data['rating'],
                $data['comment'] ?? ''
            ];
            
            // Dùng execute() và lấy lastInsertId()
            $success = $this->db->execute($sql, $params);
            
            if ($success) {
                return $this->db->lastInsertId();
            }
            
            return false;
            
        } catch (Exception $e) {
            error_log("ReviewModel addReview Error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Lấy đánh giá theo ID
     */
    public function getReviewById($id) {
        return $this->db->queryOne("SELECT * FROM reviews WHERE id = ?", [(int)$id]);
    }
    
    /**
     * Xóa đánh giá
     */
    public function deleteReview($id, $customerId = null) {
        if ($customerId) {
            return $this->db->execute(
                "DELETE FROM reviews WHERE id = ? AND customer_id = ?", 
                [(int)$id, (int)$customerId]
            );
        }
        return $this->db->execute("DELETE FROM reviews WHERE id = ?", [(int)$id]);
    }
}