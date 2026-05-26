<?php
class SpaController {
    protected $spaModel;
    protected $appointmentModel;
    protected $customerModel;
    protected $aiModel;
    
    public function __construct() {
        $this->spaModel = new SpaModel();
        $this->appointmentModel = new AppointmentModel();
        $this->customerModel = new CustomerModel();
        $this->aiModel = new  AIConsultationModel();
    }
    
    // Trang chủ
    public function index() {
        $categories = $this->spaModel->getAllCategories();
        $services = $this->spaModel->getAllServices();
        $staff = $this->spaModel->getAllStaff();
        
        require_once 'views/spa/home.php';
    }
    
    // Chi tiết dịch vụ
    public function serviceDetail($id) {
        $service = $this->spaModel->getServiceById($id);
        
        if (!$service) {
            header('Location: /404');
            exit;
        }
        
        $relatedServices = $this->spaModel->getAllServices($service['category_id']);
        $staff = $this->spaModel->getAllStaff();
        
        require_once 'views/spa/service_detail.php';
    }

    // ✅ Method staff - Hiển thị danh sách nhân viên
    public function staff() {
        $staff = $this->spaModel->getAllStaff();
        
        require_once ROOT_PATH . DS . 'Views' . DS . 'spa' . DS . 'staff.php';
    }
    
    // ✅ Đặt lịch
    public function bookAppointment() {
        // Xử lý POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Kiểm tra đăng nhập
                if (!isset($_SESSION['customer_id'])) {
                    header('Location: ' . BASE_URL . '/login?redirect=booking');
                    exit;
                }
                
                $serviceId = $_POST['service_id'] ?? null;
                $staffId = $_POST['staff_id'] ?? null;
                $appointmentDate = $_POST['appointment_date'] ?? null;
                $appointmentTime = $_POST['appointment_time'] ?? null;
                $notes = $_POST['notes'] ?? null;
                
                // Validation
                if (!$serviceId || !$appointmentDate || !$appointmentTime) {
                    header('Location: ' . BASE_URL . '/booking?error=Vui lòng điền đầy đủ thông tin');
                    exit;
                }
                
                // Lấy thông tin dịch vụ
                $service = $this->spaModel->getServiceById($serviceId);
                if (!$service) {
                    header('Location: ' . BASE_URL . '/booking?error=Dịch vụ không tồn tại');
                    exit;
                }
                
                // Tính giá
                $totalPrice = $service['discount_price'] ?? $service['price'];
                
                // Kiểm tra lịch trống (nếu chọn nhân viên)
                if ($staffId) {
                    $isAvailable = $this->spaModel->checkAvailableSlot(
                        $staffId,
                        $appointmentDate,
                        $appointmentTime,
                        $service['duration']
                    );
                    
                    if (!$isAvailable) {
                        header('Location: ' . BASE_URL . '/booking?error=Khung giờ này đã được đặt. Vui lòng chọn giờ khác.');
                        exit;
                    }
                }
                
                // Tạo đặt lịch
                $appointmentModel = new AppointmentModel();
                $appointmentId = $appointmentModel->createAppointment([
                    'customer_id' => $_SESSION['customer_id'],
                    'service_id' => $serviceId,
                    'staff_id' => $staffId ?: null,
                    'appointment_date' => $appointmentDate,
                    'appointment_time' => $appointmentTime,
                    'notes' => $notes,
                    'total_price' => $totalPrice
                ]);
                
                if ($appointmentId) {
                    // Gửi email thông báo (optional)
                    // $this->sendBookingEmail($appointmentId);
                    
                    header('Location: ' . BASE_URL . '/booking?success=1');
                    exit;
                } else {
                    header('Location: ' . BASE_URL . '/booking?error=Có lỗi xảy ra. Vui lòng thử lại.');
                    exit;
                }
                
            } catch (Exception $e) {
                header('Location: ' . BASE_URL . '/booking?error=' . urlencode($e->getMessage()));
                exit;
            }
        }
        
        // GET request - hiển thị form
        $serviceId = $_GET['service_id'] ?? null;
        $service = $serviceId ? $this->spaModel->getServiceById($serviceId) : null;
        $services = $this->spaModel->getAllServices();
        $staff = $this->spaModel->getAllStaff();
        
        require_once ROOT_PATH . DS . 'Views' . DS . 'spa' . DS . 'booking.php';
    }
    
    // Lịch sử đặt lịch
    public function myAppointments() {
        if (!isset($_SESSION['customer_id'])) {
            header('Location: /login');
            exit;
        }
        
        $page = $_GET['page'] ?? 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $appointments = $this->appointmentModel->getCustomerAppointments(
            $_SESSION['customer_id'], 
            $limit, 
            $offset
        );
        
        $total = $this->appointmentModel->countCustomerAppointments($_SESSION['customer_id']);
        $totalPages = ceil($total / $limit);
        
        require_once 'views/spa/my_appointments.php';
    }
    
    // Hủy đặt lịch
    public function cancelAppointment($id) {
        if (!isset($_SESSION['customer_id'])) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập']);
            return;
        }
        
        if ($this->appointmentModel->cancelAppointment($id, $_SESSION['customer_id'])) {
            echo json_encode(['success' => true, 'message' => 'Đã hủy đặt lịch']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không thể hủy đặt lịch']);
        }
    }
    
    // AI tư vấn
    public function aiConsultation() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $symptoms = $data['symptoms'] ?? '';
        $skinType = $data['skin_type'] ?? null;
        $budget = $data['budget'] ?? null;
        $sessionId = $data['session_id'] ?? session_id();
        $history = $data['history'] ?? null;
        
        if (empty($symptoms)) {
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng mô tả vấn đề của bạn'
            ]);
            return;
        }
        
        try {
            $aiModel = new AIConsultationModel();
            
            // Gọi AI tư vấn
            $recommendation = $aiModel->getAIRecommendation(
                $symptoms,
                $skinType,
                $budget,
                $history
            );
            
            // Lưu lịch sử
            if ($recommendation['success']) {
                $aiModel->saveConsultation([
                    'customer_id' => $_SESSION['customer_id'] ?? null,
                    'session_id' => $sessionId,
                    'user_message' => $symptoms,
                    'ai_response' => $recommendation,
                    'recommended_services' => $recommendation['services'] ?? []
                ]);
            }
            
            echo json_encode($recommendation);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage()
            ]);
        }
        return;
    }
    
    // GET request - hiển thị trang AI consultation
    $history = [];
    if (isset($_SESSION['customer_id'])) {
        $aiModel = new AIConsultationModel();
        $history = $aiModel->getConsultationHistory($_SESSION['customer_id']);
    }
    
    require_once ROOT_PATH . DS . 'Views' . DS . 'spa' . DS . 'ai_consultation.php';
}
    
    // Đăng ký
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'full_name' => $_POST['full_name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'password' => $_POST['password'],
                'gender' => $_POST['gender']
            ];
            
            // Validation
            if ($this->customerModel->emailExists($data['email'])) {
                echo json_encode(['success' => false, 'message' => 'Email đã tồn tại']);
                return;
            }
            
            if ($this->customerModel->register($data)) {
                echo json_encode(['success' => true, 'message' => 'Đăng ký thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Đăng ký thất bại']);
            }
            return;
        }
        
        require_once 'views/auth/register.php';
    }
    
    // Đăng nhập
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $customer = $this->customerModel->login($email, $password);
            
            if ($customer) {
                $_SESSION['customer_id'] = $customer['id'];
                $_SESSION['customer_name'] = $customer['full_name'];
                $_SESSION['customer_email'] = $customer['email'];
                
                echo json_encode(['success' => true, 'message' => 'Đăng nhập thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Email hoặc mật khẩu không đúng']);
            }
            return;
        }
        
        require_once 'views/auth/login.php';
    }
    
    // Đăng xuất
    public function logout() {
        session_destroy();
        header('Location: /');
        exit;
    }
}