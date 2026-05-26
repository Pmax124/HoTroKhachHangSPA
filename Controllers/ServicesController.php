<?php
class ServicesController {
    protected $model;
    
    public function __construct() {
        $this->model = new ServicesModel(); // Hoặc ServicesModel nếu có
    }
    
    // Danh sách dịch vụ
    public function index() {
        $categoryId = $_GET['category'] ?? null;
        $search = $_GET['search'] ?? null;
        $sort = $_GET['sort'] ?? 'default';
        
        // Lấy danh mục
        $categories = $this->model->getAllCategories();
        
        // Lấy dịch vụ với filter
        if ($categoryId) {
            $services = $this->model->getAllServices($categoryId);
        } elseif ($search) {
            $services = $this->model->searchServices($search);
        } else {
            $services = $this->model->getAllServices();
        }
        
        // Sorting
        if ($sort === 'price_asc') {
            usort($services, fn($a, $b) => ($a['discount_price'] ?? $a['price']) <=> ($b['discount_price'] ?? $b['price']));
        } elseif ($sort === 'price_desc') {
            usort($services, fn($a, $b) => ($b['discount_price'] ?? $b['price']) <=> ($a['discount_price'] ?? $a['price']));
        } elseif ($sort === 'duration') {
            usort($services, fn($a, $b) => $a['duration'] <=> $b['duration']);
        }
        
        require_once ROOT_PATH . DS . 'Views' . DS . 'spa' . DS . 'services.php';
    }
    
    // Chi tiết dịch vụ
    public function show($id) {
        $service = $this->model->getServiceById($id);
        
        if (!$service) {
            http_response_code(404);
            echo "<h1>404 - Dịch vụ không tồn tại</h1>";
            echo "<a href='" . BASE_URL . "/services'>← Quay lại</a>";
            return;
        }
        
        // Lấy dịch vụ liên quan cùng danh mục
        $relatedServices = $this->model->getAllServices($service['category_id']);
        
        require_once ROOT_PATH . DS . 'Views' . DS . 'spa' . DS . 'service_detail.php';
    }
}