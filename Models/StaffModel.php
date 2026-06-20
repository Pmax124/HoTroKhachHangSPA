<?php
class StaffModel {
    protected $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM staff ORDER BY rating DESC, full_name ASC");
    }

    public function getById($id) {
        return $this->db->queryOne("SELECT * FROM staff WHERE id = ?", [$id]);
    }

    /**
     * Tạo nhân viên mới - ĐÃ SỬA LỖI PARAMETER
     */
    public function create($data) {
        return $this->db->execute(
            "INSERT INTO staff (full_name, email, phone, position, specialization, experience_years, rating, avatar, status) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",  // ✅ 9 dấu ? cho 9 cột
            [
                $data['full_name'],           // 1
                $data['email'],               // 2
                $data['phone'],               // 3
                $data['position'],            // 4
                $data['specialization'],      // 5
                $data['experience_years'],    // 6
                $data['rating'],              // 7
                $data['avatar'],              // 8 ✅ SỬA: avatar_path → avatar
                $data['status'] ?? 'active'   // 9 ✅ Thêm status vào values
            ]
        );
    }

    /**
     * Cập nhật nhân viên - ĐÃ THÊM avatar
     */
    public function update($id, $data) {
        return $this->db->execute(
            "UPDATE staff SET 
                full_name = ?, email = ?, phone = ?, position = ?, 
                specialization = ?, experience_years = ?, rating = ?, avatar = ?, status = ? 
             WHERE id = ?",  // ✅ 9 dấu ? + 1 cho id = 10 total
            [
                $data['full_name'],           // 1
                $data['email'],               // 2
                $data['phone'],               // 3
                $data['position'],            // 4
                $data['specialization'],      // 5
                $data['experience_years'],    // 6
                $data['rating'],              // 7
                $data['avatar'],              // 8 ✅ THÊM avatar
                $data['status'],              // 9
                $id                           // 10
            ]
        );
    }

    public function delete($id) {
        return $this->db->execute("DELETE FROM staff WHERE id = ?", [$id]);
    }
}