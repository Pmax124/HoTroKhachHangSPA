<?php
class CategoryController {
    protected $model;
    
    public function __construct() {
        $this->model = new CategoryModel();
    }
    
    public function index() {
        $categories = $this->model->getAll();
        require_once 'views/categories/index.php';
    }
    
    public function show($id) {
        $category = $this->model->getById($id);
        $services = $this->model->getServicesByCategory($id);
        require_once 'views/categories/show.php';
    }
}