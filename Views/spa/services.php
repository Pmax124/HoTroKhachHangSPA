<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dịch Vụ - Spa Luxury</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
    .services-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 120px 0 80px;
        text-align: center;
    }
    .services-hero h1 {
        font-size: 48px;
        margin-bottom: 15px;
        font-family: 'Playfair Display', serif;
    }
    .services-hero p {
        font-size: 18px;
        opacity: 0.95;
        max-width: 600px;
        margin: 0 auto;
    }
    .filter-bar {
        background: white;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        margin: -40px auto 40px;
        max-width: 900px;
        position: relative;
        z-index: 10;
    }
    .filter-bar select, .filter-bar input {
        padding: 12px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        margin-right: 10px;
    }
    .filter-bar select:focus, .filter-bar input:focus {
        outline: none;
        border-color: #667eea;
    }
    .category-tabs {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: center;
        margin-bottom: 40px;
    }
    .category-tab {
        padding: 10px 25px;
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 500;
    }
    .category-tab:hover, .category-tab.active {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-color: transparent;
    }
    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
    }
    .service-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }
    .service-image {
        position: relative;
        height: 220px;
        overflow: hidden;
    }
    .service-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    .service-card:hover .service-image img {
        transform: scale(1.1);
    }
    .discount-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #f56565;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 12px;
    }
    .service-content {
        padding: 25px;
    }
    .service-category {
        color: #667eea;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .service-title {
        font-size: 20px;
        margin: 10px 0;
        color: #2d3748;
        font-family: 'Playfair Display', serif;
    }
    .service-description {
        color: #718096;
        font-size: 14px;
        margin-bottom: 15px;
        line-height: 1.5;
    }
    .service-meta {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
        color: #718096;
        font-size: 13px;
    }
    .service-price {
        margin-bottom: 20px;
    }
    .price-old {
        text-decoration: line-through;
        color: #a0aec0;
        margin-right: 10px;
        font-size: 14px;
    }
    .price-current {
        font-size: 22px;
        font-weight: 700;
        color: #667eea;
    }
    .service-actions {
        display: flex;
        gap: 10px;
    }
    .btn-outline {
        background: transparent;
        color: #667eea;
        border: 2px solid #667eea;
        padding: 10px 20px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
        flex: 1;
        text-align: center;
    }
    .btn-outline:hover {
        background: #667eea;
        color: white;
    }
    .btn-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
        flex: 1;
        text-align: center;
        cursor: pointer;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
    }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #718096;
    }
    .empty-state i {
        font-size: 60px;
        color: #e2e8f0;
        margin-bottom: 20px;
    }
    @media (max-width: 768px) {
        .services-hero h1 { font-size: 32px; }
        .filter-bar { margin: 20px; }
        .category-tabs { flex-direction: column; align-items: center; }
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
                    <ul class="nav-menu">
                        <li><a href="<?php echo BASE_URL; ?>/" class="nav-link">Trang chủ</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/services" class="nav-link active">Dịch vụ</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/staff" class="nav-link">Nhân viên</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/ai-consultation" class="nav-link"><i class="fas fa-robot"></i> AI Tư vấn</a></li>
                        <?php if (isset($_SESSION['customer_id'])): ?>
                            <li><a href="<?php echo BASE_URL; ?>/my-appointments" class="nav-link">Lịch của tôi</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/logout" class="btn btn-outline">Đăng xuất</a></li>
                        <?php else: ?>
                            <li><a href="<?php echo BASE_URL; ?>/login" class="btn btn-primary">Đăng nhập</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero -->
    <section class="services-hero">
        <div class="container">
            <h1>Dịch Vụ Của Chúng Tôi</h1>
            <p>Khám phá các liệu trình chăm sóc sắc đẹp và thư giãn đẳng cấp, được thiết kế riêng cho bạn</p>
        </div>
    </section>

    <!-- Filter & Search -->
    <div class="container">
        <div class="filter-bar">
            <form method="GET" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
                <select name="category" onchange="this.form.submit()">
                    <option value="">Tất cả danh mục</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <select name="sort" onchange="this.form.submit()">
                    <option value="default">Sắp xếp</option>
                    <option value="price_asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? 'selected' : '' ?>>Giá: Thấp → Cao</option>
                    <option value="price_desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? 'selected' : '' ?>>Giá: Cao → Thấp</option>
                    <option value="duration" <?= (isset($_GET['sort']) && $_GET['sort'] == 'duration') ? 'selected' : '' ?>>Thời gian</option>
                </select>
                <input type="text" name="search" placeholder="Tìm kiếm dịch vụ..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" style="flex: 1; min-width: 200px;">
                <button type="submit" class="btn btn-primary" style="padding: 12px 25px;">
                    <i class="fas fa-search"></i> Tìm
                </button>
            </form>
        </div>
    </div>

    <!-- Category Tabs -->
    <div class="container">
        <div class="category-tabs">
            <a href="<?php echo BASE_URL; ?>/services" class="category-tab <?= !isset($_GET['category']) ? 'active' : '' ?>">
                <i class="fas fa-th-large"></i> Tất cả
            </a>
            <?php foreach ($categories as $cat): ?>
            <a href="<?php echo BASE_URL; ?>/services?category=<?= $cat['id'] ?>" 
               class="category-tab <?= (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'active' : '' ?>">
                <?= htmlspecialchars($cat['name']) ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Services Grid -->
    <section class="section-padding" style="padding-top: 0;">
        <div class="container">
            <?php if (empty($services)): ?>
                <div class="empty-state">
                    <i class="fas fa-spa"></i>
                    <h3>Chưa có dịch vụ nào</h3>
                    <p>Chúng tôi đang cập nhật thêm nhiều liệu trình mới. Vui lòng quay lại sau!</p>
                </div>
            <?php else: ?>
            <div class="services-grid">
                <?php foreach ($services as $service): ?>
                <div class="service-card">
                    <div class="service-image">
                        <img src="<?= !empty($service['image']) ? BASE_URL . '/' . ltrim($service['image'], '/') : BASE_URL . '/public/images/default-service.jpg' ?>" 
                             alt="<?= htmlspecialchars($service['name']) ?>"
                             onerror="this.src='<?php echo BASE_URL; ?>/public/images/default-service.jpg'">
                        <?php if ($service['discount_price']): ?>
                            <span class="discount-badge">
                                -<?= round((1 - $service['discount_price']/$service['price']) * 100) ?>%
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="service-content">
                        <span class="service-category"><?= htmlspecialchars($service['category_name']) ?></span>
                        <h3 class="service-title"><?= htmlspecialchars($service['name']) ?></h3>
                        <p class="service-description"><?= htmlspecialchars(mb_substr($service['description'], 0, 120)) ?>...</p>
                        
                        <div class="service-meta">
                            <span><i class="far fa-clock"></i> <?= $service['duration'] ?> phút</span>
                            <?php if (!empty($service['benefits'])): ?>
                            <span><i class="fas fa-check-circle"></i> Hiệu quả</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="service-price">
                            <?php if ($service['discount_price']): ?>
                                <span class="price-old"><?= number_format($service['price'], 0, ',', '.') ?>₫</span>
                                <span class="price-current"><?= number_format($service['discount_price'], 0, ',', '.') ?>₫</span>
                            <?php else: ?>
                                <span class="price-current"><?= number_format($service['price'], 0, ',', '.') ?>₫</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="service-actions">
                            <a href="<?php echo BASE_URL; ?>/service/<?= $service['id'] ?>" class="btn-outline">
                                <i class="fas fa-eye"></i> Chi tiết
                            </a>
                            <a href="<?php echo BASE_URL; ?>/booking?service_id=<?= $service['id'] ?>" class="btn-primary">
                                <i class="fas fa-calendar-plus"></i> Đặt lịch
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- AI Consultation CTA -->
    <section style="background: linear-gradient(135deg, #667eea, #764ba2); padding: 60px 0; color: white; text-align: center;">
        <div class="container">
            <h2 style="font-size: 32px; margin-bottom: 15px;">🤔 Chưa biết chọn dịch vụ nào?</h2>
            <p style="margin-bottom: 25px; opacity: 0.95;">AI của chúng tôi sẽ tư vấn liệu trình phù hợp nhất với bạn - Hoàn toàn miễn phí!</p>
            <a href="<?php echo BASE_URL; ?>/ai-consultation" class="btn btn-white btn-lg" style="background: white; color: #667eea;">
                <i class="fas fa-robot"></i> Chat với AI ngay
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer style="background: #2d3748; color: white; padding: 40px 20px; text-align: center;">
        <p>&copy; 2026 Spa Luxury. All rights reserved.</p>
    </footer>

    <script>
    // Smooth scroll for category tabs
    document.querySelectorAll('.category-tab').forEach(tab => {
        tab.addEventListener('click', function(e) {
            // Remove active from all
            document.querySelectorAll('.category-tab').forEach(t => t.classList.remove('active'));
            // Add active to clicked
            this.classList.add('active');
        });
    });
    </script>
</body>
</html>