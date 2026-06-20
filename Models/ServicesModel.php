<?php
class ServicesModel {
    protected $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // ==========================================
    // CÁC HÀM DÀNH CHO TRANG CHỦ (KHÁCH HÀNG)
    // ==========================================
    
    /**
     * Lấy tất cả dịch vụ (Hiển thị trang chủ)
     */
  /**
 * Lấy tất cả dịch vụ (Hiển thị trang chủ) - CÓ KÈM ẢNH
 */
/**
 * Lấy tất cả dịch vụ (Hiển thị trang chủ) - CÓ KÈM ẢNH
 */
public function getAllServices($categoryId = null) {
    // 1. Query lấy danh sách dịch vụ
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
    
    // 2. ✅ QUAN TRỌNG: Load ảnh cho từng dịch vụ
    foreach ($services as &$service) {
        // Lấy danh sách ảnh từ bảng service_images
        $service['images'] = $this->getImages($service['id']);
        
        // ✅ Tạo property 'image' chứa đường dẫn ảnh chính để View dùng
        $service['image'] = null;
        if (!empty($service['images'])) {
            // Ưu tiên ảnh có is_main = 1
            foreach ($service['images'] as $img) {
                if ($img['is_main']) {
                    $service['image'] = $img['image_path'];
                    break;
                }
            }
            // Nếu không có ảnh main, lấy ảnh đầu tiên
            if (!$service['image']) {
                $service['image'] = $service['images'][0]['image_path'];
            }
        }
    }
    
    return $services;
}
    
    /**
     * Lấy dịch vụ theo ID (Kèm theo danh sách ảnh)
     */
/**
 * Lấy dịch vụ theo ID (Kèm theo danh sách ảnh)
 */
public function getServiceById($id) {
    // 1. Lấy thông tin dịch vụ
    $service = $this->db->queryOne("
        SELECT s.*, c.name as category_name 
        FROM services s 
        LEFT JOIN categories c ON s.category_id = c.id 
        WHERE s.id = ?
    ", [$id]);
    
    // 2. Lấy danh sách ảnh của dịch vụ đó
    if ($service) {
        $service['images'] = $this->getImages($id);
        
        // ✅ Tạo property 'image' chứa đường dẫn ảnh chính
        $service['image'] = null;
        if (!empty($service['images'])) {
            foreach ($service['images'] as $img) {
                if ($img['is_main']) {
                    $service['image'] = $img['image_path'];
                    break;
                }
            }
            if (!$service['image']) {
                $service['image'] = $service['images'][0]['image_path'];
            }
        }
    }
    
    return $service;
}
    
    /**
     * Lấy danh mục
     */
    public function getAllCategories() {
        return $this->db->query("SELECT * FROM categories WHERE status = 'active' ORDER BY display_order");
    }
    
    /**
     * Tìm kiếm dịch vụ
     */
    public function searchServices($keyword) {
        return $this->db->query("
            SELECT s.*, c.name as category_name 
            FROM services s 
            LEFT JOIN categories c ON s.category_id = c.id 
            WHERE s.status = 'active' 
            AND (s.name LIKE ? OR s.description LIKE ?)
            ORDER BY s.created_at DESC
        ", ["%{$keyword}%", "%{$keyword}%"]);
    }

    // ==========================================
    // CÁC HÀM DÀNH CHO ADMIN (QUẢN TRỊ VIÊN)
    // ==========================================

    /**
     * Lấy tất cả dịch vụ (Cho Admin xem - bao gồm cả inactive)
     */
    /**
 * Lấy tất cả dịch vụ (Cho Admin xem - bao gồm cả inactive) - CÓ KÈM ẢNH
 */
public function getAllForAdmin() {
    // 1. Lấy danh sách dịch vụ
    $services = $this->db->query("
        SELECT s.*, c.name as category_name 
        FROM services s 
        LEFT JOIN categories c ON s.category_id = c.id 
        ORDER BY s.id DESC
    ");
    
    // 2. ✅ QUAN TRỌNG: Load ảnh cho từng dịch vụ
    foreach ($services as &$service) {
        $service['images'] = $this->getImages($service['id']);
    }
    
    return $services;
}

    /**
     * Thêm dịch vụ mới
     */
    public function create($data) {
    // ✅ Đảm bảo discount_price là float hoặc null
    $discountPrice = !empty($data['discount_price']) ? (float)$data['discount_price'] : null;
    
    return $this->db->execute(
        "INSERT INTO services (category_id, name, description, duration, price, discount_price, benefits, suitable_for, status) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'active')",
        [
            $data['category_id'],
            $data['name'],
            $data['description'],
            $data['duration'],
            $data['price'],
            $discountPrice,  // ✅ Dùng biến đã xử lý
            $data['benefits'],
            $data['suitable_for']
        ]
    );
}

public function update($id, $data) {
    // ✅ Đảm bảo discount_price là float hoặc null
    $discountPrice = !empty($data['discount_price']) ? (float)$data['discount_price'] : null;
    $categoryId = !empty($data['category_id']) ? (int)$data['category_id'] : null;
    
    return $this->db->execute(
        "UPDATE services SET 
            category_id = ?, name = ?, description = ?, duration = ?, 
            price = ?, discount_price = ?, benefits = ?, suitable_for = ? 
         WHERE id = ?",
        [
            $categoryId,
            $data['name'],
            $data['description'],
            $data['duration'],
            $data['price'],
            $discountPrice,  // ✅ Dùng biến đã xử lý
            $data['benefits'],
            $data['suitable_for'],
            $id
        ]
    );
}

    /**
     * Xóa dịch vụ
     */
    public function delete($id) {
        // Xóa ảnh trong database trước (ON DELETE CASCADE sẽ xóa ảnh nếu khóa ngoại đúng, 
        // nhưng ở đây ta nên xóa file vật lý nếu cần thiết trong Controller)
        return $this->db->execute("DELETE FROM services WHERE id = ?", [$id]);
    }

    // ==========================================
    // XỬ LÝ HÌNH ẢNH (MULTIPLE IMAGES)
    // ==========================================

    /**
     * Lấy danh sách ảnh của dịch vụ
     */
    public function getImages($serviceId) {
        return $this->db->query("SELECT * FROM service_images WHERE service_id = ? ORDER BY id ASC", [$serviceId]);
    }

    /**
     * Lưu nhiều hình ảnh mới
     * @param int $serviceId ID của dịch vụ
     * @param array $files Dữ liệu từ $_FILES['images']
     * @param bool $isEdit true nếu đang sửa, false nếu đang tạo mới
     */
    public function saveImages($serviceId, $files, $isEdit = false) {
        $uploadDir = ROOT_PATH . DS . 'public' . DS . 'uploads' . DS . 'services' . DS;
        
        // Tạo thư mục nếu chưa có
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $count = 0;
        // Lặp qua từng file upload lên
        foreach ($files['tmp_name'] as $key => $tmp_name) {
            if ($files['error'][$key] === 0) {
                $fileName = uniqid() . '_' . $files['name'][$key]; // Tạo tên file duy nhất
                $destination = $uploadDir . $fileName;
                
                // Di chuyển file upload vào thư mục server
                if (move_uploaded_file($tmp_name, $destination)) {
                    $path = 'public/uploads/services/' . $fileName;
                    
                    // Nếu đang tạo mới (không phải edit), ảnh đầu tiên sẽ là ảnh chính
                    $isMain = (!$isEdit && $count === 0) ? 1 : 0;
                    
                    $this->db->execute(
                        "INSERT INTO service_images (service_id, image_path, is_main) VALUES (?, ?, ?)",
                        [$serviceId, $path, $isMain]
                    );
                    $count++;
                }
            }
        }
        return $count; // Trả về số ảnh đã lưu thành công
    }

    /**
     * Xóa một ảnh cụ thể
     */
    public function deleteImage($imageId) {
        $image = $this->db->queryOne("SELECT * FROM service_images WHERE id = ?", [$imageId]);
        if ($image) {
            // Xóa file vật lý
            $filePath = ROOT_PATH . DS . str_replace('/', DS, $image['image_path']);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            // Xóa record trong DB
            $this->db->execute("DELETE FROM service_images WHERE id = ?", [$imageId]);
            return true;
        }
        return false;
    }

      public function getAll() {
        return $this->getAllForAdmin();
    }
    
    public function getById($id) {
        return $this->getServiceById($id);
    }
}