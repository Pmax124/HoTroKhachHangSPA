<?php
class SpaModel {
    protected $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Lấy tất cả dịch vụ
    public function getAllServices($categoryId = null) {
    if ($categoryId) {
        $services = $this->db->query("
            SELECT s.*, c.name as category_name 
            FROM services s 
            LEFT JOIN categories c ON s.category_id = c.id 
            WHERE s.status = 'active' AND s.category_id = ?
            ORDER BY s.created_at DESC
        ", [$categoryId]);
    } else {
        $services = $this->db->query("
            SELECT s.*, c.name as category_name 
            FROM services s 
            LEFT JOIN categories c ON s.category_id = c.id 
            WHERE s.status = 'active' 
            ORDER BY c.display_order, s.created_at DESC
        ");
    }
    
    // ✅ QUAN TRỌNG: Load ảnh cho từng dịch vụ
    foreach ($services as &$service) {
        $service['images'] = $this->db->query(
            "SELECT * FROM service_images WHERE service_id = ? ORDER BY id ASC", 
            [$service['id']]
        );
    }
    
    return $services;
}
    
    // Lấy dịch vụ theo ID
  public function getServiceById($id) {
    $service = $this->db->queryOne("
        SELECT s.*, c.name as category_name 
        FROM services s 
        LEFT JOIN categories c ON s.category_id = c.id 
        WHERE s.id = ?
    ", [$id]);
    
    if ($service) {
        // ✅ Load ảnh
        $service['images'] = $this->db->query(
            "SELECT * FROM service_images WHERE service_id = ? ORDER BY id ASC", 
            [$id]
        );
    }
    
    return $service;
}
    
    // Lấy tất cả danh mục
    public function getAllCategories() {
        return $this->db->query("SELECT * FROM categories WHERE status = 'active' ORDER BY display_order");
    }
    
    // Lấy tất cả nhân viên
    public function getAllStaff() {
        return $this->db->query("SELECT * FROM staff WHERE status = 'active' ORDER BY rating DESC");
    }
    
    // Lấy nhân viên theo ID
    public function getStaffById($id) {
        return $this->db->queryOne("SELECT * FROM staff WHERE id = ?", [$id]);
    }
    
    // Kiểm tra lịch trống
   public function checkAvailableSlot($staffId, $date, $time, $duration = 60) {
    $endTime = date('H:i:s', strtotime($time . " +{$duration} minutes"));
    
    return $this->db->queryOne("
        SELECT COUNT(*) as count FROM appointments 
        WHERE staff_id = ? 
        AND appointment_date = ?
        AND status IN ('pending', 'confirmed')
        AND (
            (appointment_time <= ? AND DATE_ADD(appointment_time, INTERVAL ? MINUTE) > ?)
            OR
            (appointment_time < ? AND DATE_ADD(appointment_time, INTERVAL ? MINUTE) >= ?)
        )", 
        [$staffId, $date, $time, $duration, $time, $endTime, $duration, $endTime]
    );
}

    // Thêm vào cuối class SpaModel
    public function searchServices($keyword) {
        return $this->db->query("
            SELECT s.*, c.name as category_name 
            FROM services s 
            LEFT JOIN categories c ON s.category_id = c.id 
            WHERE s.status = 'active' 
            AND (s.name LIKE ? OR s.description LIKE ? OR c.name LIKE ?)
            ORDER BY s.created_at DESC
        ", ["%{$keyword}%", "%{$keyword}%", "%{$keyword}%"]);
    }
}