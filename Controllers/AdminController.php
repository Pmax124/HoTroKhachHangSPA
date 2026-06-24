<?php
class AdminController {
    protected $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
        
        // Kiểm tra đăng nhập admin
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }
    
    /**
     * Admin Dashboard
     */
    public function index() {
        // Thống kê
        $stats = [
            'total_customers' => $this->db->queryOne("SELECT COUNT(*) as count FROM customers")['count'],
            'total_appointments' => $this->db->queryOne("SELECT COUNT(*) as count FROM appointments")['count'],
            'pending_appointments' => $this->db->queryOne("SELECT COUNT(*) as count FROM appointments WHERE status = 'pending'")['count'],
            'total_services' => $this->db->queryOne("SELECT COUNT(*) as count FROM services WHERE status = 'active'")['count'],
            'total_revenue' => $this->db->queryOne("SELECT COALESCE(SUM(total_price), 0) as revenue FROM appointments WHERE payment_status = 'paid'")['revenue']
        ];
        
        // Lấy danh sách đặt lịch gần đây
        $recentAppointments = $this->db->query("
            SELECT a.*, 
                   c.full_name as customer_name, 
                   s.name as service_name, 
                   st.full_name as staff_name
            FROM appointments a
            LEFT JOIN customers c ON a.customer_id = c.id
            LEFT JOIN services s ON a.service_id = s.id
            LEFT JOIN staff st ON a.staff_id = st.id
            ORDER BY a.created_at DESC
            LIMIT 10
        ");
        
        require_once ROOT_PATH . DS . 'Views' . DS . 'admin' . DS . 'dashboard.php';
    }
    
    /**
     * Admin Logout
     */
    public function logout() {
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_name']);
        unset($_SESSION['admin_role']);
        unset($_SESSION['user_type']);
        
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    // ✅ Danh sách dịch vụ
    public function indexServices() {
        $servicesModel = new ServicesModel();
        // ✅ Sửa: getAll() → getAllForAdmin()
        $services = $servicesModel->getAllForAdmin();
        require_once ROOT_PATH . DS . 'Views' . DS . 'admin' . DS . 'services_list.php';
    }

    // ✅ Thêm dịch vụ mới
    public function addService() {
        $servicesModel = new ServicesModel();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'category_id' => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'duration' => $_POST['duration'],
                'price' => $_POST['price'],
                'discount_price' => $_POST['discount_price'],
                'benefits' => $_POST['benefits'],
                'suitable_for' => $_POST['suitable_for']
            ];

            if ($servicesModel->create($data)) {
                $serviceId = $this->db->lastInsertId();
                // Xử lý upload ảnh
                if (!empty($_FILES['images']['name'][0])) {
                    $servicesModel->saveImages($serviceId, $_FILES['images']);
                }
                header('Location: ' . BASE_URL . '/admin/services?msg=success');
                exit;
            }
        }

        require_once ROOT_PATH . DS . 'Views' . DS . 'admin' . DS . 'service_form.php';
    }

    public function editService($id) {
    $servicesModel = new ServicesModel();
    $service = $servicesModel->getServiceById($id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // ✅ Xử lý các trường có thể bị thiếu hoặc rỗng
        $data = [
            'category_id' => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'duration' => !empty($_POST['duration']) ? (int)$_POST['duration'] : 60, // ✅ Mặc định 60 nếu rỗng
            'price' => !empty($_POST['price']) ? (float)$_POST['price'] : 0,
            'discount_price' => !empty($_POST['discount_price']) ? (float)$_POST['discount_price'] : null, // ✅ NULL nếu rỗng
            'benefits' => trim($_POST['benefits'] ?? ''),
            'suitable_for' => trim($_POST['suitable_for'] ?? '')
        ];

        // Validation cơ bản
        if (empty($data['name']) || empty($data['price'])) {
            die("Vui lòng nhập tên dịch vụ và giá!");
        }

        if ($servicesModel->update($id, $data)) {
            // Upload ảnh mới nếu có
            if (!empty($_FILES['images']['name'][0])) {
                $servicesModel->saveImages($id, $_FILES['images'], true);
            }
            header('Location: ' . BASE_URL . '/admin/services?msg=updated');
            exit;
        } else {
            die("Cập nhật thất bại!");
        }
    }

    require_once ROOT_PATH . DS . 'Views' . DS . 'admin' . DS . 'service_form.php';
}

    // ✅ Xóa dịch vụ - Đã sửa tên class và biến
    public function deleteService($id) {
        // ✅ Sửa: ServiceModel → ServicesModel (thêm chữ "s")
        $servicesModel = new ServicesModel();
        
        // ✅ Sửa: getById() → getServiceById()
        $service = $servicesModel->getServiceById($id);
        
        if ($service) {
            // Lấy ảnh để xóa file vật lý
            foreach ($service['images'] as $img) {
                $filePath = ROOT_PATH . DS . str_replace('/', DS, $img['image_path']);
                if (file_exists($filePath)) unlink($filePath);
            }
            $servicesModel->delete($id);
        }
        header('Location: ' . BASE_URL . '/admin/services');
    }

   // ==========================================
// QUẢN LÝ NHÂN VIÊN - Thêm vào AdminController
// ==========================================

public function indexStaff() {
    $staffModel = new StaffModel();
    $staffList = $staffModel->getAll();
    
    $pageTitle = "Quản lý Nhân viên";
    $currentPage = "staff";
    require_once ROOT_PATH . DS . 'Views' . DS . 'admin' . DS . 'partials' . DS . 'sidebar.php';
    require_once ROOT_PATH . DS . 'Views' . DS . 'admin' . DS . 'staff_list.php';
    require_once ROOT_PATH . DS . 'Views' . DS . 'admin' . DS . 'partials' . DS . 'footer.php';
}

// Method addStaff()
public function addStaff() {
    $staffModel = new StaffModel();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $avatarPath = null;
        
        if (!empty($_FILES['avatar']['name']) && $_FILES['avatar']['error'] === 0) {
            $uploadDir = ROOT_PATH . DS . 'public' . DS . 'uploads' . DS . 'staff' . DS;
            if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
            
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            if (in_array($_FILES['avatar']['type'], $allowedTypes)) {
                $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                $fileName = 'staff_' . uniqid() . '_' . time() . '.' . $extension;
                $destination = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $destination)) {
                    $avatarPath = 'public/uploads/staff/' . $fileName;
                }
            }
        }

        $data = [
            'full_name' => trim($_POST['full_name']),
            'email' => trim($_POST['email']),
            'phone' => trim($_POST['phone']),
            'position' => trim($_POST['position']),
            'specialization' => trim($_POST['specialization']),
            'experience_years' => (int)($_POST['experience_years'] ?? 0),
            'rating' => (float)($_POST['rating'] ?? 5.0),
            'avatar' => $avatarPath,        // ✅ Key phải là 'avatar'
            'status' => 'active'
        ];

        if ($staffModel->create($data)) {
            header('Location: ' . BASE_URL . '/admin/staff?msg=success');
            exit;
        }
    }

    $pageTitle = "Thêm Nhân viên";
    $currentPage = "staff";
    require_once ROOT_PATH . DS . 'Views' . DS . 'admin' . DS . 'partials' . DS . 'sidebar.php';
    require_once ROOT_PATH . DS . 'Views' . DS . 'admin' . DS . 'staff_form.php';
    require_once ROOT_PATH . DS . 'Views' . DS . 'admin' . DS . 'partials' . DS . 'footer.php';
}

// Method editStaff()
public function editStaff($id) {
    $staffModel = new StaffModel();
    $staff = $staffModel->getById($id);

    if (!$staff) {
        header('Location: ' . BASE_URL . '/admin/staff?error=not_found');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $avatarPath = $staff['avatar'];  // Giữ ảnh cũ
        
        if (!empty($_FILES['avatar']['name']) && $_FILES['avatar']['error'] === 0) {
            if (!empty($staff['avatar']) && file_exists(ROOT_PATH . DS . $staff['avatar'])) {
                unlink(ROOT_PATH . DS . $staff['avatar']);
            }
            
            $uploadDir = ROOT_PATH . DS . 'public' . DS . 'uploads' . DS . 'staff' . DS;
            if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
            
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            if (in_array($_FILES['avatar']['type'], $allowedTypes)) {
                $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                $fileName = 'staff_' . uniqid() . '_' . time() . '.' . $extension;
                $destination = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $destination)) {
                    $avatarPath = 'public/uploads/staff/' . $fileName;
                }
            }
        }

        $data = [
            'full_name' => trim($_POST['full_name']),
            'email' => trim($_POST['email']),
            'phone' => trim($_POST['phone']),
            'position' => trim($_POST['position']),
            'specialization' => trim($_POST['specialization']),
            'experience_years' => (int)($_POST['experience_years'] ?? 0),
            'rating' => (float)($_POST['rating'] ?? 5.0),
            'avatar' => $avatarPath,        // ✅ Key phải là 'avatar'
            'status' => $_POST['status'] ?? 'active'
        ];

        if ($staffModel->update($id, $data)) {
            header('Location: ' . BASE_URL . '/admin/staff?msg=updated');
            exit;
        }
    }

    $pageTitle = "Sửa Nhân viên";
    $currentPage = "staff";
    require_once ROOT_PATH . DS . 'Views' . DS . 'admin' . DS . 'partials' . DS . 'sidebar.php';
    require_once ROOT_PATH . DS . 'Views' . DS . 'admin' . DS . 'staff_form.php';
    require_once ROOT_PATH . DS . 'Views' . DS . 'admin' . DS . 'partials' . DS . 'footer.php';
}

public function deleteStaff($id) {
    $staffModel = new StaffModel();
    $staff = $staffModel->getById($id);
    
    if ($staff && !empty($staff['avatar']) && file_exists(ROOT_PATH . DS . $staff['avatar'])) {
        unlink(ROOT_PATH . DS . $staff['avatar']);
    }
    
    $staffModel->delete($id);
    header('Location: ' . BASE_URL . '/admin/staff');
    exit;
}

    /**
     * Helper: Upload avatar nhân viên
     */
    private function uploadAvatar($file) {
        $uploadDir = ROOT_PATH . DS . 'public' . DS . 'uploads' . DS . 'staff' . DS;
        
        // Tạo thư mục nếu chưa có
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid() . '_' . $file['name'];
        $destination = $uploadDir . $fileName;
        
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return 'public/uploads/staff/' . $fileName;
        }
        
        return null;
    }

    /**
 * Quản lý tất cả lịch hẹn
 */
public function manageAppointments() {
    // Kiểm tra admin
    if (!isset($_SESSION['admin_id'])) {
        header('Location: ' . BASE_URL . '/admin/login');
        exit;
    }
    
    $appointmentModel = new AppointmentModel();
    $spaModel = new SpaModel();
    
    // Lấy filter
    $statusFilter = $_GET['status'] ?? '';
    $dateFilter = $_GET['date'] ?? '';
    $staffFilter = $_GET['staff_id'] ?? '';
    $searchFilter = $_GET['search'] ?? '';
    
    // Lấy danh sách lịch hẹn
    $appointments = $appointmentModel->getAllAppointmentsWithDetails([
        'status' => $statusFilter,
        'date' => $dateFilter,
        'staff_id' => $staffFilter,
        'search' => $searchFilter
    ]);
    
    // Lấy danh sách nhân viên cho filter
    $staffList = $spaModel->getAllStaff();
    
    // Thống kê
    $stats = [
        'total' => count($appointments),
        'pending' => 0,
        'confirmed' => 0,
        'completed' => 0,
        'cancelled' => 0,
        'revenue' => 0
    ];
    
    foreach ($appointments as $apt) {
        if (isset($stats[$apt['status']])) {
            $stats[$apt['status']]++;
        }
        if ($apt['status'] === 'completed') {
            $stats['revenue'] += $apt['total_price'];
        }
    }
    
    require_once ROOT_PATH . DS . 'Views' . DS . 'admin' . DS . 'appointments.php';
}

/**
 * Cập nhật trạng thái lịch hẹn (AJAX)
 */
public function updateAppointmentStatus() {
    header('Content-Type: application/json');
    
    if (!isset($_SESSION['admin_id'])) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $appointmentId = $data['id'] ?? null;
        $status = $data['status'] ?? null;
        
        $validStatuses = ['pending', 'confirmed', 'completed', 'cancelled'];
        
        if ($appointmentId && $status && in_array($status, $validStatuses)) {
            $appointmentModel = new AppointmentModel();
            if ($appointmentModel->updateStatus($appointmentId, $status)) {
                echo json_encode(['success' => true, 'message' => 'Cập nhật thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Cập nhật thất bại']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
        }
    }
}

/**
 * Xóa lịch hẹn
 */
public function deleteAppointment($id) {
    if (!isset($_SESSION['admin_id'])) {
        header('Location: ' . BASE_URL . '/admin/login');
        exit;
    }
    
    $appointmentModel = new AppointmentModel();
    $appointmentModel->deleteAppointment($id);
    
    header('Location: ' . BASE_URL . '/admin/appointments');
    exit;
}

// Quản lý danh mục
public function indexCategories() {
    // Kiểm tra đăng nhập admin
    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
        header('Location: ' . BASE_URL . '/admin/login');
        exit;
    }
    
    $db = Database::getInstance();
    $categories = $db->query("SELECT * FROM categories ORDER BY display_order ASC, id DESC");
    
    require_once ROOT_PATH . '/Views/admin/categories.php';
}

public function addCategory() {
    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
        header('Location: ' . BASE_URL . '/admin/login');
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $displayOrder = intval($_POST['display_order'] ?? 0);
        $status = $_POST['status'] ?? 'active';
        
        if (empty($name)) {
            header('Location: ' . BASE_URL . '/admin/add-category?error=Vui lòng nhập tên danh mục');
            exit;
        }
        
        $db = Database::getInstance();
        $result = $db->execute(
            "INSERT INTO categories (name, description, display_order, status, created_at) VALUES (?, ?, ?, ?, NOW())",
            [$name, $description, $displayOrder, $status]
        );
        
        if ($result) {
            header('Location: ' . BASE_URL . '/admin/categories?success=1');
            exit;
        } else {
            header('Location: ' . BASE_URL . '/admin/add-category?error=Có lỗi xảy ra');
            exit;
        }
    }
    
    require_once ROOT_PATH . '/Views/admin/add_category.php';
}

public function editCategory($id) {
    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
        header('Location: ' . BASE_URL . '/admin/login');
        exit;
    }
    
    $db = Database::getInstance();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $displayOrder = intval($_POST['display_order'] ?? 0);
        $status = $_POST['status'] ?? 'active';
        
        if (empty($name)) {
            header('Location: ' . BASE_URL . '/admin/edit-category/' . $id . '?error=Vui lòng nhập tên danh mục');
            exit;
        }
        
        $result = $db->execute(
            "UPDATE categories SET name = ?, description = ?, display_order = ?, status = ? WHERE id = ?",
            [$name, $description, $displayOrder, $status, $id]
        );
        
        if ($result) {
            header('Location: ' . BASE_URL . '/admin/categories?success=1');
            exit;
        } else {
            header('Location: ' . BASE_URL . '/admin/edit-category/' . $id . '?error=Có lỗi xảy ra');
            exit;
        }
    }
    
    $category = $db->queryOne("SELECT * FROM categories WHERE id = ?", [$id]);
    
    if (!$category) {
        header('Location: ' . BASE_URL . '/admin/categories?error=Danh mục không tồn tại');
        exit;
    }
    
    require_once ROOT_PATH . '/Views/admin/edit_category.php';
}

public function deleteCategory($id) {
    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        return;
    }
    
    $db = Database::getInstance();
    
    // Kiểm tra xem có service nào thuộc category này không
    $services = $db->query("SELECT COUNT(*) as count FROM services WHERE category_id = ?", [$id]);
    
    if ($services[0]['count'] > 0) {
        echo json_encode(['success' => false, 'message' => 'Không thể xóa danh mục đang có dịch vụ']);
        return;
    }
    
    $result = $db->execute("DELETE FROM categories WHERE id = ?", [$id]);
    
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Đã xóa danh mục']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Không thể xóa danh mục']);
    }
}
}