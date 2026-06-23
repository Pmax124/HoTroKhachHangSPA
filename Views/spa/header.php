<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Spa Luxury'; ?> - Spa Luxury</title>
    
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <?php if (!empty($useBootstrap)): ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php endif; ?>
    
    <style>
    /* Dropdown menu */
    .dropdown { position: relative; }
    .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        min-width: 180px;
        border-radius: 10px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        padding: 10px 0;
        z-index: 1000;
        animation: slideDown 0.2s ease;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .dropdown:hover .dropdown-menu { display: block; }
    .dropdown-menu li a {
        display: block;
        padding: 10px 20px;
        color: #2d3748;
        text-decoration: none;
        transition: background 0.2s;
    }
    .dropdown-menu li a:hover {
        background: #f7fafc;
        color: #667eea;
    }
    .dropdown-menu li a i {
        margin-right: 8px;
        width: 16px;
    }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="navbar">
            <div class="container">
                <div class="nav-wrapper">
                    <div class="logo">
                        <i class="fas fa-spa"></i>
                        <span>Spa Luxury</span>
                    </div>
                    
                    <ul class="nav-menu" id="navMenu">
                        <li><a href="<?php echo BASE_URL; ?>/" class="nav-link <?php echo ($currentPage ?? '') === 'home' ? 'active' : ''; ?>">Trang chủ</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/services" class="nav-link <?php echo ($currentPage ?? '') === 'services' ? 'active' : ''; ?>">Dịch vụ</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/staff" class="nav-link <?php echo ($currentPage ?? '') === 'staff' ? 'active' : ''; ?>">Nhân viên</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/ai-consultation" class="nav-link <?php echo ($currentPage ?? '') === 'ai' ? 'active' : ''; ?>"><i class="fas fa-robot"></i> AI Tư vấn</a></li>
                        
                        <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin'): ?>
                            <li><a href="<?php echo BASE_URL; ?>/admin" class="nav-link" style="color: #f56565;">
                                <i class="fas fa-shield-alt"></i> Admin
                            </a></li>
                            <li><a href="<?php echo BASE_URL; ?>/logout" class="btn btn-outline">
                                <i class="fas fa-sign-out-alt"></i> Đăng xuất
                            </a></li>
                            
                        <?php elseif (isset($_SESSION['customer_id'])): ?>
                            <li><a href="<?php echo BASE_URL; ?>/my-appointments" class="nav-link <?php echo ($currentPage ?? '') === 'appointments' ? 'active' : ''; ?>">
                                <i class="fas fa-calendar-check"></i> Lịch của tôi
                            </a></li>
                            <li class="dropdown">
                                <a href="#" class="nav-link dropdown-toggle">
                                    <i class="fas fa-user-circle"></i> <?= htmlspecialchars($_SESSION['customer_name']) ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo BASE_URL; ?>/profile"><i class="fas fa-user"></i> Hồ sơ</a></li>
                                    <li><a href="<?php echo BASE_URL; ?>/logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
                                </ul>
                            </li>
                            
                        <?php else: ?>
                            <li><a href="<?php echo BASE_URL; ?>/login" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt"></i> Đăng nhập
                            </a></li>
                            <li><a href="<?php echo BASE_URL; ?>/register" class="btn btn-outline">
                                <i class="fas fa-user-plus"></i> Đăng ký
                            </a></li>
                        <?php endif; ?>
                    </ul>
                    
                    <div class="hamburger" id="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </nav>
    </header>