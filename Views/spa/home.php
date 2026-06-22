<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spa Luxury - Chăm Sóc Sắc Đẹp & Thư Giãn</title>
    
    <!-- ✅ FIX: Thêm BASE_URL cho CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
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
                        <!-- ✅ FIX: Thêm BASE_URL cho tất cả link navigation -->
                        <li><a href="<?php echo BASE_URL; ?>/" class="nav-link active">Trang chủ</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/services" class="nav-link">Dịch vụ</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/staff" class="nav-link">Nhân viên</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/ai-consultation" class="nav-link"><i class="fas fa-robot"></i> AI Tư vấn</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/about" class="nav-link">Về chúng tôi</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/contact" class="nav-link">Liên hệ</a></li>
                        
                        <?php if (isset($_SESSION['customer_id'])): ?>
                            <li><a href="<?php echo BASE_URL; ?>/my-appointments" class="nav-link">Lịch của tôi</a></li>
                            <li class="dropdown">
                                <a href="#" class="nav-link dropdown-toggle">
                                    <i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['customer_name']) ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo BASE_URL; ?>/profile">Hồ sơ</a></li>
                                    <li><a href="<?php echo BASE_URL; ?>/logout">Đăng xuất</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li><a href="<?php echo BASE_URL; ?>/login" class="btn btn-primary">Đăng nhập</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/register" class="btn btn-outline">Đăng ký</a></li>
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-slider">
            <!-- ✅ FIX: Thêm BASE_URL cho background image -->
            <div class="hero-slide active" style="background-image: url('<?php echo BASE_URL; ?>/public/images/spa-bg-1.jpg');">
                <div class="hero-content">
                    <h1 class="hero-title">Thư Giãn & Tái Tạo Năng Lượng</h1>
                    <p class="hero-subtitle">Trải nghiệm dịch vụ spa cao cấp với đội ngũ chuyên viên chuyên nghiệp</p>
                    <div class="hero-buttons">
                        <!-- ✅ FIX: Thêm BASE_URL cho button links -->
                        <a href="<?php echo BASE_URL; ?>/booking" class="btn btn-primary btn-lg">
                            <i class="fas fa-calendar-check"></i> Đặt lịch ngay
                        </a>
                        <a href="<?php echo BASE_URL; ?>/ai-consultation" class="btn btn-outline btn-lg">
                            <i class="fas fa-robot"></i> AI Tư vấn miễn phí
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="hero-wave">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
            </svg>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features section-padding">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title">Tại sao chọn chúng tôi?</h2>
                <p class="section-subtitle">Trải nghiệm dịch vụ spa đẳng cấp 5 sao</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3>Chuyên gia hàng đầu</h3>
                    <p>Đội ngũ chuyên viên được đào tạo bài bản, giàu kinh nghiệm</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Sản phẩm tự nhiên</h3>
                    <p>100% nguyên liệu organic, an toàn cho da</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Đặt lịch linh hoạt</h3>
                    <p>Đặt lịch 24/7, chọn giờ phù hợp với bạn</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3>Chất lượng đảm bảo</h3>
                    <p>Cam kết hài lòng 100% hoặc hoàn tiền</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services section-padding bg-light">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title">Dịch vụ của chúng tôi</h2>
                <p class="section-subtitle">Đa dạng liệu trình chăm sóc sắc đẹp</p>
            </div>
            
            <div class="services-grid">
                <?php foreach ($services as $service): ?>
                <div class="service-card">
                    <div class="service-image">
                        <!-- ✅ FIX: Thêm BASE_URL cho image src với fallback -->
                        <img src="<?= $service['image'] ? BASE_URL . '/' . ltrim($service['image'], '/') : BASE_URL . '/public/images/default-service.jpg' ?>" alt="<?= htmlspecialchars($service['name']) ?>">
                        <?php if ($service['discount_price']): ?>
                            <span class="discount-badge">-<?= round((1 - $service['discount_price']/$service['price']) * 100) ?>%</span>
                        <?php endif; ?>
                    </div>
                    <div class="service-content">
                        <span class="service-category"><?= htmlspecialchars($service['category_name']) ?></span>
                        <h3 class="service-title"><?= htmlspecialchars($service['name']) ?></h3>
                        <p class="service-description"><?= htmlspecialchars(mb_substr($service['description'], 0, 100)) ?>...</p>
                        
                        <div class="service-meta">
                            <span class="service-duration">
                                <i class="far fa-clock"></i> <?= $service['duration'] ?> phút
                            </span>
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
                            <!-- ✅ FIX: Thêm BASE_URL cho service links -->
                            <a href="<?php echo BASE_URL; ?>/service/<?= $service['id'] ?>" class="btn btn-outline btn-sm">
                                <i class="fas fa-eye"></i> Xem chi tiết
                            </a>
                            <a href="<?php echo BASE_URL; ?>/booking?service_id=<?= $service['id'] ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-calendar-plus"></i> Đặt lịch
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center mt-5">
                <a href="<?php echo BASE_URL; ?>/services" class="btn btn-primary btn-lg">Xem tất cả dịch vụ</a>
            </div>
        </div>
    </section>

    <!-- AI Consultation CTA -->
    <section class="ai-cta section-padding">
        <div class="container">
            <div class="ai-cta-box">
                <div class="ai-cta-content">
                    <h2>Bạn chưa biết chọn liệu trình nào?</h2>
                    <p>AI của chúng tôi sẽ tư vấn liệu trình phù hợp nhất với nhu cầu của bạn hoàn toàn miễn phí</p>
                    <div class="ai-features">
                        <div class="ai-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Tư vấn 24/7</span>
                        </div>
                        <div class="ai-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Miễn phí 100%</span>
                        </div>
                        <div class="ai-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Chính xác & Nhanh chóng</span>
                        </div>
                    </div>
                    <a href="<?php echo BASE_URL; ?>/ai-consultation" class="btn btn-white btn-lg">
                        <i class="fas fa-robot"></i> Chat với AI ngay
                    </a>
                </div>
                <div class="ai-cta-image">
                    <!-- ✅ FIX: Thêm BASE_URL cho image -->
                    <img src="<?php echo BASE_URL; ?>/public/images/ai-consultation.png" alt="AI Consultation">
                </div>
            </div>
        </div>
    </section>

    <!-- Staff Section -->
    <section class="staff section-padding bg-light">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title">Đội ngũ chuyên gia</h2>
                <p class="section-subtitle">Những người sẽ chăm sóc bạn</p>
            </div>
            
            <div class="staff-grid">
                <?php foreach ($staff as $member): ?>
                <div class="staff-card">
                    <div class="staff-image">
                        <!-- ✅ FIX: Thêm BASE_URL cho staff avatar với fallback -->
                        <img src="<?= $member['avatar'] ? BASE_URL . '/' . ltrim($member['avatar'], '/') : BASE_URL . '/public/images/default-staff.jpg' ?>" alt="<?= htmlspecialchars($member['full_name']) ?>">
                        <div class="staff-overlay">
                            <div class="staff-social">
                                <a href="#"><i class="fab fa-facebook"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="staff-info">
                        <h3><?= htmlspecialchars($member['full_name']) ?></h3>
                        <p class="staff-position"><?= htmlspecialchars($member['position']) ?></p>
                        <div class="staff-rating">
                            <i class="fas fa-star"></i>
                            <span><?= $member['rating'] ?>/5</span>
                        </div>
                        <p class="staff-experience"><?= $member['experience_years'] ?> năm kinh nghiệm</p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials section-padding">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title">Khách hàng nói về chúng tôi</h2>
                <p class="section-subtitle">Đánh giá từ khách hàng thực tế</p>
            </div>
            
            <div class="testimonials-slider">
                <div class="testimonial-card">
                    <div class="testimonial-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"Dịch vụ tuyệt vời! Không gian thư giãn, nhân viên chuyên nghiệp. Mình sẽ quay lại thường xuyên."</p>
                    <div class="testimonial-author">
                        <!-- ✅ FIX: Thêm BASE_URL cho customer image -->
                        <img src="<?php echo BASE_URL; ?>/public/images/customer1.jpg" alt="Customer">
                        <div>
                            <h4>Nguyễn Thị A</h4>
                            <p>Khách hàng thân thiết</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="footer-logo">
                        <i class="fas fa-spa"></i>
                        <span>Spa Luxury</span>
                    </div>
                    <p>Địa chỉ chăm sóc sắc đẹp và thư giãn hàng đầu. Chúng tôi cam kết mang đến cho bạn trải nghiệm tuyệt vời nhất.</p>
                    <div class="footer-social">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                
                <div class="footer-col">
                    <h4>Dịch vụ</h4>
                    <ul>
                        <li><a href="<?php echo BASE_URL; ?>/services#massage">Massage</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/services#skincare">Chăm sóc da</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/services#body">Spa body</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/services#hair">Gội đầu dưỡng sinh</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Liên kết</h4>
                    <ul>
                        <li><a href="<?php echo BASE_URL; ?>/about">Về chúng tôi</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/services">Dịch vụ</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/booking">Đặt lịch</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/contact">Liên hệ</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Liên hệ</h4>
                    <ul class="footer-contact">
                        <li><i class="fas fa-map-marker-alt"></i> 123 Nguyễn Văn A, Quận 1, TP.HCM</li>
                        <li><i class="fas fa-phone"></i> 1900 1234</li>
                        <li><i class="fas fa-envelope"></i> info@spaluxury.com</li>
                        <li><i class="fas fa-clock"></i> 8:00 - 21:00 (T2-CN)</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2026 Spa Luxury. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- ✅ FIX: Thêm BASE_URL cho JavaScript -->
    <script src="<?php echo BASE_URL; ?>/public/js/main.js"></script>
</body>
</html>