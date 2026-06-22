<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($service['name']) ?> - Spa Luxury</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
    .service-detail-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 100px 0 60px;
    }
    .service-detail-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 40px;
        margin-top: -60px;
        position: relative;
        z-index: 10;
    }
    .service-images {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }
    .service-images img {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }
    .service-info {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        position: sticky;
        top: 20px;
        height: fit-content;
    }
    .service-category {
        color: #667eea;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }
    .service-title {
        font-size: 32px;
        margin: 0 0 15px;
        color: #2d3748;
        font-family: 'Playfair Display', serif;
    }
    .service-rating {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }
    .service-rating i { color: #ffc107; }
    .service-description {
        color: #718096;
        line-height: 1.7;
        margin-bottom: 25px;
    }
    .service-meta-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 25px;
    }
    .meta-item {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #4a5568;
    }
    .meta-item i {
        color: #667eea;
        font-size: 18px;
    }
    .service-price-box {
        background: #f7fafc;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 25px;
    }
    .price-old {
        text-decoration: line-through;
        color: #a0aec0;
        font-size: 16px;
        margin-right: 10px;
    }
    .price-current {
        font-size: 32px;
        font-weight: 700;
        color: #667eea;
    }
    .btn-book {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.3s, box-shadow 0.3s;
        text-decoration: none;
        display: block;
        text-align: center;
        margin-bottom: 10px;
    }
    .btn-book:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    }
    .btn-ai {
        width: 100%;
        padding: 12px;
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: block;
        text-align: center;
    }
    .btn-ai:hover {
        background: #667eea;
        color: white;
    }
    .service-benefits {
        margin-top: 30px;
    }
    .service-benefits h4 {
        color: #2d3748;
        margin-bottom: 15px;
        font-family: 'Playfair Display', serif;
    }
    .benefits-list {
        list-style: none;
        padding: 0;
    }
    .benefits-list li {
        padding: 8px 0;
        color: #4a5568;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .benefits-list li i {
        color: #48bb78;
    }
    .related-services {
        margin-top: 60px;
    }
    .related-services h3 {
        font-size: 24px;
        color: #2d3748;
        margin-bottom: 25px;
        font-family: 'Playfair Display', serif;
    }
    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }
    .related-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: transform 0.3s;
    }
    .related-card:hover { transform: translateY(-5px); }
    .related-card img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }
    .related-card .content { padding: 15px; }
    .related-card .title {
        font-size: 16px;
        color: #2d3748;
        margin: 5px 0;
        font-weight: 500;
    }
    .related-card .price {
        color: #667eea;
        font-weight: 600;
    }
    @media (max-width: 992px) {
        .service-detail-grid { grid-template-columns: 1fr; }
        .service-info { position: static; }
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
    <section class="service-detail-hero">
        <div class="container">
            <span class="service-category"><?= htmlspecialchars($service['category_name']) ?></span>
            <h1 class="service-title"><?= htmlspecialchars($service['name']) ?></h1>
            <div class="service-rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <span style="opacity: 0.9;">(128 đánh giá)</span>
            </div>
        </div>
    </section>

    <!-- Detail Content -->
    <section class="section-padding" style="padding-top: 0;">
        <div class="container">
            <div class="service-detail-grid">
                <!-- Left: Images & Description -->
                <div>
                    <div class="service-images">
                        <img src="<?= !empty($service['image']) ? BASE_URL . '/' . ltrim($service['image'], '/') : BASE_URL . '/public/images/default-service.jpg' ?>" 
                             alt="<?= htmlspecialchars($service['name']) ?>"
                             onerror="this.src='<?php echo BASE_URL; ?>/public/images/default-service.jpg'">
                    </div>
                    
                    <div style="margin-top: 30px;">
                        <h3 style="color: #2d3748; font-family: 'Playfair Display', serif; margin-bottom: 15px;">Mô tả dịch vụ</h3>
                        <p class="service-description"><?= nl2br(htmlspecialchars($service['description'])) ?></p>
                        
                        <?php if (!empty($service['benefits'])): ?>
                        <div class="service-benefits">
                            <h4>✨ Lợi ích khi trải nghiệm</h4>
                            <ul class="benefits-list">
                                <?php 
                                $benefits = explode(',', $service['benefits']);
                                foreach ($benefits as $benefit): 
                                ?>
                                <li><i class="fas fa-check-circle"></i> <?= htmlspecialchars(trim($benefit)) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($service['suitable_for'])): ?>
                        <div style="margin-top: 25px; background: #f7fafc; padding: 20px; border-radius: 15px;">
                            <h4 style="color: #2d3748; margin-bottom: 10px;">🎯 Phù hợp với</h4>
                            <p style="color: #4a5568; margin: 0;"><?= htmlspecialchars($service['suitable_for']) ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right: Booking Box -->
                <div class="service-info">
                    <div class="service-meta-grid">
                        <div class="meta-item">
                            <i class="far fa-clock"></i>
                            <span><?= $service['duration'] ?> phút</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-user-friends"></i>
                            <span>1-2 người</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-tag"></i>
                            <span>Đã bao gồm VAT</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-gift"></i>
                            <span>Tặng kèm trà thảo mộc</span>
                        </div>
                    </div>
                    
                    <div class="service-price-box">
                        <?php if ($service['discount_price']): ?>
                            <div class="price-old"><?= number_format($service['price'], 0, ',', '.') ?>₫</div>
                            <div class="price-current"><?= number_format($service['discount_price'], 0, ',', '.') ?>₫</div>
                            <div style="color: #f56565; font-size: 14px; margin-top: 5px;">
                                <i class="fas fa-fire"></i> Tiết kiệm <?= number_format($service['price'] - $service['discount_price'], 0, ',', '.') ?>₫
                            </div>
                        <?php else: ?>
                            <div class="price-current"><?= number_format($service['price'], 0, ',', '.') ?>₫</div>
                        <?php endif; ?>
                    </div>
                    
                    <a href="<?php echo BASE_URL; ?>/booking?service_id=<?= $service['id'] ?>" class="btn-book">
                        <i class="fas fa-calendar-check"></i> Đặt lịch ngay
                    </a>
                    <a href="<?php echo BASE_URL; ?>/ai-consultation?service=<?= $service['id'] ?>" class="btn-ai">
                        <i class="fas fa-robot"></i> AI tư vấn về dịch vụ này
                    </a>
                    
                    <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                        <p style="color: #718096; font-size: 13px; margin: 0;">
                            <i class="fas fa-shield-alt"></i> Cam kết hoàn tiền nếu không hài lòng
                        </p>
                        <p style="color: #718096; font-size: 13px; margin: 10px 0 0;">
                            <i class="fas fa-headset"></i> Hỗ trợ 24/7: 1900 1234
                        </p>
                    </div>
                </div>
            </div>

            <!-- Related Services -->
            <?php if (!empty($relatedServices) && count($relatedServices) > 1): ?>
            <div class="related-services">
                <h3>Có thể bạn cũng thích</h3>
                <div class="related-grid">
                    <?php foreach ($relatedServices as $related): ?>
                        <?php if ($related['id'] != $service['id']): ?>
                        <a href="<?php echo BASE_URL; ?>/service/<?= $related['id'] ?>" class="related-card" style="text-decoration: none;">
                            <img src="<?= !empty($related['image']) ? BASE_URL . '/' . ltrim($related['image'], '/') : BASE_URL . '/public/images/default-service.jpg' ?>" 
                                 alt="<?= htmlspecialchars($related['name']) ?>"
                                 onerror="this.src='<?php echo BASE_URL; ?>/public/images/default-service.jpg'">
                            <div class="content">
                                <div class="title"><?= htmlspecialchars($related['name']) ?></div>
                                <div class="price"><?= number_format($related['discount_price'] ?? $related['price'], 0, ',', '.') ?>₫</div>
                            </div>
                        </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer style="background: #2d3748; color: white; padding: 40px 20px; text-align: center;">
        <p>&copy; 2026 Spa Luxury. All rights reserved.</p>
    </footer>
</body>
</html>