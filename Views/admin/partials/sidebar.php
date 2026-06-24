<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Admin'; ?> - Spa Luxury</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; background: #f7fafc; }
        
        .admin-wrapper { display: flex; min-height: 100vh; }
        
        .admin-sidebar {
            width: 260px;
            background: linear-gradient(180deg, #2d3748 0%, #1a202c 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }
        .admin-sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid #4a5568;
            text-align: center;
        }
        .admin-sidebar-header i { font-size: 40px; color: #667eea; margin-bottom: 10px; }
        .admin-sidebar-header h2 { font-size: 22px; margin: 10px 0 5px; }
        .admin-sidebar-header p { font-size: 13px; opacity: 0.8; }
        
        .admin-menu { list-style: none; padding: 20px 0; margin: 0; }
        .admin-menu li a {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: #e2e8f0;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }
        .admin-menu li a:hover, .admin-menu li a.active {
            background: rgba(102, 126, 234, 0.1);
            color: white;
            border-left-color: #667eea;
        }
        .admin-menu li a i { margin-right: 12px; width: 20px; text-align: center; }
        
        .admin-main {
            flex: 1;
            margin-left: 260px;
            padding: 30px;
        }
        
        .admin-header {
            background: white;
            padding: 20px 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-header h1 { font-size: 28px; color: #2d3748; margin: 0; }
        .admin-breadcrumb { color: #718096; font-size: 14px; margin-top: 5px; }
        .admin-breadcrumb a { color: #667eea; text-decoration: none; }
        
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #edf2f7;
            color: #4a5568;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-back:hover { background: #e2e8f0; transform: translateX(-3px); }
        
        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            transition: all 0.3s;
        }
        .btn-add:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5); }
        
        .content-box {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-error { background: #fed7d7; color: #742a2a; border: 1px solid #fc8181; }
        
        .table-responsive { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f7fafc; }
        th {
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            color: #4a5568;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }
        td {
            padding: 15px 12px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }
        tr:hover { background: #f7fafc; }
        
        .thumb {
            width: 70px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            border: 2px solid #e2e8f0;
        }
        .no-image {
            width: 70px;
            height: 50px;
            background: #f7fafc;
            border: 2px dashed #cbd5e0;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #a0aec0;
        }
        
        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        .status-active { background: #d1fae5; color: #065f46; }
        .status-inactive { background: #fed7d7; color: #742a2a; }
        
        .action-buttons { display: flex; gap: 8px; }
        .btn-action {
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s;
        }
        .btn-edit { background: #fef3c7; color: #92400e; }
        .btn-edit:hover { background: #fde68a; }
        .btn-delete { background: #fee2e2; color: #991b1b; border: none; cursor: pointer; }
        .btn-delete:hover { background: #fecaca; }
        
        .admin-footer {
            margin-top: 40px;
            padding: 20px 30px;
            background: white;
            border-radius: 12px;
            text-align: center;
            color: #718096;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="admin-sidebar-header">
                <i class="fas fa-spa"></i>
                <h2>Spa Luxury</h2>
                <p>Admin Panel</p>
            </div>
            <ul class="admin-menu">
                <li><a href="<?php echo BASE_URL; ?>/admin" class="<?php echo ($currentPage ?? '') === 'dashboard' ? 'active' : ''; ?>">
                    <i class="fas fa-home"></i> Tổng quan
                </a></li>
                <li><a href="<?php echo BASE_URL; ?>/admin/services" class="<?php echo ($currentPage ?? '') === 'services' ? 'active' : ''; ?>">
                    <i class="fas fa-spa"></i> Dịch vụ
                </a></li>
                <li><a href="<?php echo BASE_URL; ?>/admin/categories" class="<?php echo ($currentPage ?? '') === 'categories' ? 'active' : ''; ?>">
                    <i class="fas fa-folder"></i> Danh mục
                </a></li>
                <li><a href="<?php echo BASE_URL; ?>/admin/appointments" class="<?php echo ($currentPage ?? '') === 'appointments' ? 'active' : ''; ?>">
                    <i class="fas fa-calendar"></i> Đặt lịch
                </a></li>
                <li><a href="<?php echo BASE_URL; ?>/admin/customers" class="<?php echo ($currentPage ?? '') === 'customers' ? 'active' : ''; ?>">
                    <i class="fas fa-users"></i> Khách hàng
                </a></li>
                <li><a href="<?php echo BASE_URL; ?>/admin/staff" class="<?php echo ($currentPage ?? '') === 'staff' ? 'active' : ''; ?>">
                    <i class="fas fa-user-tie"></i> Nhân viên
                </a></li>
                <li><a href="<?php echo BASE_URL; ?>/">
                    <i class="fas fa-arrow-left"></i> Về trang chủ
                </a></li>
                <li><a href="<?php echo BASE_URL; ?>/admin/logout">
                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                </a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">