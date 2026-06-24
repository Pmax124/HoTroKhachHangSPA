<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('ROOT_PATH', __DIR__);
define('DS', DIRECTORY_SEPARATOR);

// Auto-detect base URL
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$requestUri = $_SERVER['REQUEST_URI'];

$basePath = str_replace('/index.php', '', $scriptName);
$basePath = rtrim($basePath, '/');

define('BASE_URL', 'http://localhost:8080' . $basePath);

// Load helpers
$helpersFile = ROOT_PATH . DS . 'config' . DS . 'helpers.php';
if (file_exists($helpersFile)) {
    require_once $helpersFile;
}

// Autoloader
spl_autoload_register(function ($class) {
    $folders = ['config', 'Models', 'Controllers'];
    foreach ($folders as $folder) {
        $file = ROOT_PATH . DS . $folder . DS . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    }
    return false;
});

// ✅ FIX: Get URI and remove base path properly
$uri = parse_url($requestUri, PHP_URL_PATH);

// Debug: Show what we're working with
// echo "<pre>URI: $uri\nBasePath: $basePath\n</pre>";

// Remove base path - Case INSENSITIVE and handle both with/without trailing slash
if (!empty($basePath)) {
    // Escape slashes for regex
    $basePathEscaped = preg_quote($basePath, '#');
    // Remove base path (case-insensitive)
    $uri = preg_replace('#^' . $basePathEscaped . '#i', '', $uri);
}

// Remove query string
$uri = explode('?', $uri)[0];

// Remove trailing slash (but keep root as /)
$uri = '/' . trim($uri, '/');
if ($uri === '/') {
    // Root path
} else {
    $uri = rtrim($uri, '/');
}

// Debug output
// echo "<pre>Final URI: $uri</pre>"; exit;

// Routes
$routes = [
    '/' => ['controller' => 'SpaController', 'action' => 'index'],
    '/services' => ['controller' => 'ServicesController', 'action' => 'index'],
    '/service/([0-9]+)' => ['controller' => 'ServicesController', 'action' => 'show'],
    '/staff' => ['controller' => 'SpaController', 'action' => 'staff'],
    '/booking' => ['controller' => 'SpaController', 'action' => 'bookAppointment'],
    '/my-appointments' => ['controller' => 'SpaController', 'action' => 'myAppointments'],
    '/cancel-appointment/([0-9]+)' => ['controller' => 'SpaController', 'action' => 'cancelAppointment'],
    '/ai-consultation' => ['controller' => 'SpaController', 'action' => 'aiConsultation'],
    '/register' => ['controller' => 'SpaController', 'action' => 'register'],
    '/login' => ['controller' => 'SpaController', 'action' => 'login'],
    '/logout' => ['controller' => 'SpaController', 'action' => 'logout'],
    '/categories' => ['controller' => 'CategoryController', 'action' => 'index'],
     // ✅ THÊM CÁC ROUTE ADMIN NÀY:
    '/admin' => ['controller' => 'AdminController', 'action' => 'index'],
    '/admin/login' => ['controller' => 'AdminController', 'action' => 'login'],
    '/admin/logout' => ['controller' => 'AdminController', 'action' => 'logout'],
    '/admin/dashboard' => ['controller' => 'AdminController', 'action' => 'index'],

    
// ✅ THÊM ROUTE ADMIN QUẢN LÝ DỊCH VỤ
'/admin/services' => ['controller' => 'AdminController', 'action' => 'indexServices'],
'/admin/add-service' => ['controller' => 'AdminController', 'action' => 'addService'],
'/admin/edit-service/([0-9]+)' => ['controller' => 'AdminController', 'action' => 'editService'],
'/admin/delete-service/([0-9]+)' => ['controller' => 'AdminController', 'action' => 'deleteService'],

// ✅ ROUTE QUẢN LÝ NHÂN VIÊN
'/admin/staff' => ['controller' => 'AdminController', 'action' => 'indexStaff'],
'/admin/add-staff' => ['controller' => 'AdminController', 'action' => 'addStaff'],
'/admin/edit-staff/([0-9]+)' => ['controller' => 'AdminController', 'action' => 'editStaff'],
'/admin/delete-staff/([0-9]+)' => ['controller' => 'AdminController', 'action' => 'deleteStaff'],

// Thêm vào mảng $routes
    '/admin/staff' => ['controller' => 'AdminController', 'action' => 'indexStaff'],
    '/admin/add-staff' => ['controller' => 'AdminController', 'action' => 'addStaff'],
    '/admin/edit-staff/([0-9]+)' => ['controller' => 'AdminController', 'action' => 'editStaff'],
    '/admin/delete-staff/([0-9]+)' => ['controller' => 'AdminController', 'action' => 'deleteStaff'],

// ✅ THÊM MỚI: ADMIN QUẢN LÝ LỊCH HẸN
    '/admin/appointments' => ['controller' => 'AdminController', 'action' => 'manageAppointments'],
    '/admin/appointments/update-status' => ['controller' => 'AdminController', 'action' => 'updateAppointmentStatus'],
    '/admin/appointments/delete/([0-9]+)' => ['controller' => 'AdminController', 'action' => 'deleteAppointment'],
    '/admin/appointments/export' => ['controller' => 'AdminController', 'action' => 'exportAppointments'],

     // ✅ THÊM ROUTE CATEGORIES NÀY:
    '/admin/categories' => ['controller' => 'AdminController', 'action' => 'indexCategories'],
    '/admin/add-category' => ['controller' => 'AdminController', 'action' => 'addCategory'],
    '/admin/edit-category/([0-9]+)' => ['controller' => 'AdminController', 'action' => 'editCategory'],
    '/admin/delete-category/([0-9]+)' => ['controller' => 'AdminController', 'action' => 'deleteCategory'],
];

// Match route
$matched = false;

foreach ($routes as $route => $config) {
    $pattern = '#^' . preg_replace('/\(\[0-9\]\+\)/', '([0-9]+)', $route) . '$#';
    
    if (preg_match($pattern, $uri, $matches)) {
        array_shift($matches);
        
        $controllerName = $config['controller'];
        $action = $config['action'];
        $controllerFile = ROOT_PATH . DS . 'Controllers' . DS . $controllerName . '.php';
        
        if (!file_exists($controllerFile)) {
            die("❌ Controller not found: {$controllerFile}");
        }
        
        require_once $controllerFile;
        
        if (!class_exists($controllerName)) {
            die("❌ Class '{$controllerName}' not found");
        }
        
        $controller = new $controllerName();
        
        if (!method_exists($controller, $action)) {
            die("❌ Method '{$action}' not found in {$controllerName}");
        }
        
        call_user_func_array([$controller, $action], $matches);
        $matched = true;
        exit;
    }
}

// 404 handler
if (!$matched) {
    http_response_code(404);
    echo "<h1>404 - Page Not Found</h1>";
    echo "<p>Requested URI: " . htmlspecialchars($uri) . "</p>";
    echo "<p>Original Request: " . htmlspecialchars($requestUri) . "</p>";
    echo "<p>Base Path: " . htmlspecialchars($basePath) . "</p>";
    echo "<details><summary>Available Routes</summary><pre>";
    print_r($routes);
    echo "</pre></details>";
}