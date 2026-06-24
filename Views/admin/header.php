<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Spa Luxury</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { 
            background-color: #f4f6f9; 
            font-family: 'Roboto', sans-serif;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar .brand {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        .sidebar .brand h4 {
            color: white;
            margin: 0;
            font-weight: 600;
        }
        .sidebar a {
            color: rgba(255,255,255,0.9);
            padding: 12px 20px;
            display: block;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        .sidebar a:hover, .sidebar a.active {
            background: rgba(255,255,255,0.1);
            border-left-color: white;
            color: white;
        }
        .sidebar a i {
            margin-right: 10px;
            width: 20px;
        }
        .main-content {
            padding: 30px;
        }
        .top-bar {
            background: white;
            padding: 15px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        }
        .card-header {
            background: white;
            border-bottom: 1px solid #e9ecef;
            padding: 20px;
            border-radius: 10px 10px 0 0 !important;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="sidebar-sticky">
                    <div class="brand">
                        <h4><i class="fas fa-spa"></i> Spa Luxury</h4>
                        <small style="color: rgba(255,255,255,0.7);">Admin Panel</small>
                    </div>
                    <ul class="nav flex-column">
                        <li><a href="<?php echo BASE_URL; ?>/admin" class="<?php echo ($_SERVER['REQUEST_URI'] == '/admin') ? 'active' : ''; ?>">
                            <i class="fas fa-home"></i> Dashboard
                        </a></li>
                        <li><a href="<?php echo BASE_URL; ?>/admin/categories" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/categories') !== false) ? 'active' : ''; ?>">
                            <i class="fas fa-folder"></i> Danh mục
                        </a></li>
                        <li><a href="<?php echo BASE_URL; ?>/admin/services" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/services') !== false) ? 'active' : ''; ?>">
                            <i class="fas fa-concierge-bell"></i> Dịch vụ
                        </a></li>
                        <li><a href="<?php echo BASE_URL; ?>/admin/staff" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/staff') !== false) ? 'active' : ''; ?>">
                            <i class="fas fa-users"></i> Nhân viên
                        </a></li>
                        <li><a href="<?php echo BASE_URL; ?>/admin/appointments" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/appointments') !== false) ? 'active' : ''; ?>">
                            <i class="fas fa-calendar-alt"></i> Lịch hẹn
                        </a></li>
                        <li style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 10px;">
                            <a href="<?php echo BASE_URL; ?>/">
                                <i class="fas fa-arrow-left"></i> Về trang chủ
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>/logout" style="color: #ff6b6b;">
                                <i class="fas fa-sign-out-alt"></i> Đăng xuất
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 ml-sm-auto main-content">
                <!-- Top Bar -->
                <div class="top-bar">
                    <h2 class="h4 mb-0 text-gray-800">
                        <i class="fas fa-cog"></i> Quản trị hệ thống
                    </h2>
                    <div>
                        <span class="text-muted">
                            <i class="fas fa-user"></i> 
                            <?php echo isset($_SESSION['admin_name']) ? htmlspecialchars($_SESSION['admin_name']) : 'Admin'; ?>
                        </span>
                    </div>
                </div>