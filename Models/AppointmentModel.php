<?php
class AppointmentModel {
    protected $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Tạo đặt lịch mới
 public function createAppointment($data) {
    $sql = "INSERT INTO appointments (customer_id, staff_id, service_id, appointment_date, 
             appointment_time, notes, total_price, status) 
             VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')";
    
    $this->db->execute($sql, [
        $data['customer_id'],
        $data['staff_id'] ?? null,
        $data['service_id'],
        $data['appointment_date'],
        $data['appointment_time'],
        $data['notes'] ?? null,
        $data['total_price']
    ]);
    
    // ✅ Trả về ID vừa insert
    return $this->db->lastInsertId(); 
}
    
    // Lấy lịch sử đặt lịch của khách
public function getCustomerAppointments($customerId, $limit = 10, $offset = 0) {
    $limit = (int)$limit;
    $offset = (int)$offset;
    
    $sql = "SELECT a.*, 
            s.name as service_name, 
            s.duration,
            s.price,
            s.description as service_description,
            (SELECT si.image_path FROM service_images si WHERE si.service_id = a.service_id ORDER BY si.id ASC LIMIT 1) as service_image,
            st.full_name as staff_name, 
            st.phone as staff_phone
            FROM appointments a
            LEFT JOIN services s ON a.service_id = s.id
            LEFT JOIN staff st ON a.staff_id = st.id
            WHERE a.customer_id = ?
            ORDER BY a.appointment_date DESC, a.appointment_time DESC
            LIMIT {$limit} OFFSET {$offset}";
    
    return $this->db->query($sql, [$customerId]);
}
    
    // Lấy số lượng đặt lịch
   public function countCustomerAppointments($customerId) {
    $result = $this->db->queryOne("SELECT COUNT(*) as count FROM appointments WHERE customer_id = ?", [$customerId]);
    return $result['count'] ?? 0;  // ✅ Thêm ?? 0 để tránh null
}
    
    // Cập nhật trạng thái đặt lịch
    public function updateStatus($id, $status) {
        return $this->db->execute("UPDATE appointments SET status = ? WHERE id = ?", [$status, $id]);
    }
    
    // Hủy đặt lịch
    public function cancelAppointment($id, $customerId) {
        return $this->db->execute("UPDATE appointments SET status = 'cancelled' WHERE id = ? AND customer_id = ?", [$id, $customerId]);
    }

    /**
 * Lấy tất cả lịch hẹn với đầy đủ thông tin (cho Admin)
 */
public function getAllAppointmentsWithDetails($filters = []) {
    $sql = "SELECT 
        a.*,
        s.name as service_name,
        s.duration,
        s.price as service_price,
        c.full_name as customer_name,
        c.phone as customer_phone,
        c.email as customer_email,
        st.full_name as staff_name,
        st.phone as staff_phone,
        (SELECT si.image_path FROM service_images si 
         WHERE si.service_id = a.service_id 
         ORDER BY si.id ASC LIMIT 1) as service_image
    FROM appointments a
    LEFT JOIN services s ON a.service_id = s.id
    LEFT JOIN customers c ON a.customer_id = c.id
    LEFT JOIN staff st ON a.staff_id = st.id
    WHERE 1=1";
    
    $params = [];
    
    // Filter theo trạng thái
    if (!empty($filters['status'])) {
        $sql .= " AND a.status = ?";
        $params[] = $filters['status'];
    }
    
    // Filter theo ngày
    if (!empty($filters['date'])) {
        $sql .= " AND a.appointment_date = ?";
        $params[] = $filters['date'];
    }
    
    // Filter theo nhân viên
    if (!empty($filters['staff_id'])) {
        $sql .= " AND a.staff_id = ?";
        $params[] = $filters['staff_id'];
    }
    
    // Tìm kiếm theo tên khách hoặc SĐT
    if (!empty($filters['search'])) {
        $sql .= " AND (c.full_name LIKE ? OR c.phone LIKE ? OR c.email LIKE ?)";
        $searchTerm = '%' . $filters['search'] . '%';
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $params[] = $searchTerm;
    }
    
    $sql .= " ORDER BY a.appointment_date DESC, a.appointment_time ASC";
    
    return $this->db->query($sql, $params);
}

/**
 * Xóa lịch hẹn (Admin)
 */
public function deleteAppointment($id) {
    return $this->db->execute("DELETE FROM appointments WHERE id = ?", [$id]);
}
}