<?php
class CustomerModel {
    protected $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Đăng ký khách hàng mới
     */
    public function register($data) {
        return $this->db->execute(
            "INSERT INTO customers (full_name, email, phone, password, gender, status) 
             VALUES (?, ?, ?, ?, ?, 'active')",
            [
                $data['full_name'],
                $data['email'],
                $data['phone'],
                $data['password'],
                $data['gender']
            ]
        );
    }
    
    /**
     * Đăng nhập
     */
    public function login($email, $password) {
        $customer = $this->db->queryOne(
            "SELECT * FROM customers WHERE email = ? AND status = 'active'",
            [$email]
        );
        
        if ($customer && password_verify($password, $customer['password'])) {
            unset($customer['password']);
            return $customer;
        }
        
        return false;
    }
    
    /**
     * Kiểm tra email tồn tại
     */
    public function emailExists($email, $excludeId = null) {
        if ($excludeId) {
            $result = $this->db->queryOne(
                "SELECT COUNT(*) as count FROM customers WHERE email = ? AND id != ?",
                [$email, $excludeId]
            );
        } else {
            $result = $this->db->queryOne(
                "SELECT COUNT(*) as count FROM customers WHERE email = ?",
                [$email]
            );
        }
        
        return $result['count'] > 0;
    }
    
    /**
     * Lấy thông tin khách hàng
     */
    public function getById($id) {
        $customer = $this->db->queryOne(
            "SELECT * FROM customers WHERE id = ?",
            [$id]
        );
        
        if ($customer) {
            unset($customer['password']);
        }
        
        return $customer;
    }
}