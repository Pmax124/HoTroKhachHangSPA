<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đội Ngũ Chuyên Gia - Spa Luxury</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                        <li><a href="<?php echo BASE_URL; ?>/services" class="nav-link">Dịch vụ</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/staff" class="nav-link active">Nhân viên</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/ai-consultation" class="nav-link">AI Tư vấn</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/login" class="btn btn-primary">Đăng nhập</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Page Header -->
    <section class="page-header" style="
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 100px 0 60px;
        text-align: center;
    ">
        <div class="container">
            <h1 style="font-size: 48px; margin-bottom: 15px;">Đội Ngũ Chuyên Gia</h1>
            <p style="font-size: 18px; opacity: 0.95;">Những người sẽ chăm sóc bạn tận tâm nhất</p>
        </div>
    </section>

    <!-- Staff Grid -->
    <section class="section-padding">
        <div class="container">
            <div class="staff-grid" style="
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 30px;
            ">
                <?php foreach ($staff as $member): ?>
                <div class="staff-card" style="
                    background: white;
                    border-radius: 20px;
                    overflow: hidden;
                    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
                    text-align: center;
                    transition: transform 0.3s;
                " onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div class="staff-image" style="height: 300px; background: linear-gradient(135deg, #667eea, #764ba2);">
                        <img src="<?= !empty($member['avatar']) ? BASE_URL . '/' . ltrim($member['avatar'], '/') : '' ?>" 
                             alt="<?= htmlspecialchars($member['full_name']) ?>"
                             style="width: 100%; height: 100%; object-fit: cover;"
                             onerror="this.parentElement.innerHTML='<i class=\'fas fa-user\' style=\'font-size:80px;color:white;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%)\'></i>'">
                    </div>
                    <div class="staff-info" style="padding: 25px;">
                        <h3 style="margin: 0 0 5px; color: #2d3748;"><?= htmlspecialchars($member['full_name']) ?></h3>
                        <p style="color: #667eea; margin: 0 0 10px;"><?= htmlspecialchars($member['position']) ?></p>
                        <div style="color: #ffc107; margin-bottom: 10px;">
                            <i class="fas fa-star"></i>
                            <span><?= $member['rating'] ?>/5</span>
                        </div>
                        <p style="color: #718096; font-size: 14px; margin: 0;">
                            <?= $member['experience_years'] ?> năm kinh nghiệm
                        </p>
                        <?php if (!empty($member['specialization'])): ?>
                        <p style="color: #718096; font-size: 13px; margin-top: 10px;">
                            <strong>Chuyên môn:</strong><br>
                            <?= htmlspecialchars($member['specialization']) ?>
                        </p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer style="background: #2d3748; color: white; padding: 40px 20px; text-align: center;">
        <p>&copy; 2026 Spa Luxury. All rights reserved.</p>
    </footer>
</body>
</html>