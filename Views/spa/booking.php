<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lịch hẹn - Spa Luxury</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 100px 0 60px;
        text-align: center;
    }
    .page-header h1 {
        font-size: 42px;
        margin-bottom: 10px;
        font-family: 'Playfair Display', serif;
    }
    .booking-section {
        padding: 60px 0;
        background: #f7fafc;
    }
    .booking-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 40px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    .booking-form-wrapper {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }
    .booking-form-wrapper h2 {
        margin-bottom: 30px;
        color: #2d3748;
        font-family: 'Playfair Display', serif;
    }
    .form-group {
        margin-bottom: 25px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #2d3748;
    }
    .form-group label i {
        margin-right: 8px;
        color: #667eea;
    }
    .form-control {
        width: 100%;
        padding: 12px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 16px;
        transition: border-color 0.3s;
    }
    .form-control:focus {
        outline: none;
        border-color: #667eea;
    }
    .booking-summary {
        background: #f7fafc;
        padding: 25px;
        border-radius: 15px;
        margin: 30px 0;
    }
    .booking-summary h3 {
        margin-bottom: 20px;
        color: #2d3748;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #e2e8f0;
    }
    .summary-row.total {
        border-bottom: none;
        font-size: 20px;
        font-weight: 700;
        color: #667eea;
        margin-top: 10px;
    }
    .btn-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    }
    .btn-primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    .booking-info {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 30px;
        border-radius: 20px;
        height: fit-content;
    }
    .booking-info h3 {
        margin-bottom: 20px;
        font-family: 'Playfair Display', serif;
    }
    .info-list {
        list-style: none;
        padding: 0;
        margin-bottom: 30px;
    }
    .info-list li {
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .contact-info {
        margin-top: 30px;
        padding-top: 30px;
        border-top: 1px solid rgba(255,255,255,0.2);
    }
    .contact-info h4 {
        margin-bottom: 15px;
    }
    .contact-info p {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .alert {
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .alert-success {
        background: #c6f6d5;
        color: #22543d;
        border: 1px solid #9ae6b4;
    }
    .alert-error {
        background: #fed7d7;
        color: #742a2a;
        border: 1px solid #fc8181;
    }
    @media (max-width: 992px) {
        .booking-container { grid-template-columns: 1fr; }
    }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="navbar">
            <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
                <div class="nav-wrapper" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="logo" style="display: flex; align-items: center; gap: 10px; font-size: 24px; font-weight: 700; color: #667eea;">
                        <i class="fas fa-spa"></i>
                        <span>Spa Luxury</span>
                    </div>
                    <ul class="nav-menu" style="display: flex; list-style: none; gap: 30px; align-items: center;">
                        <li><a href="<?php echo BASE_URL; ?>/" class="nav-link">Trang chủ</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/services" class="nav-link">Dịch vụ</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/staff" class="nav-link">Nhân viên</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/ai-consultation" class="nav-link"><i class="fas fa-robot"></i> AI Tư vấn</a></li>
                        <?php if (isset($_SESSION['customer_id'])): ?>
                            <li><a href="<?php echo BASE_URL; ?>/my-appointments" class="nav-link">Lịch của tôi</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/logout" class="btn btn-outline">Đăng xuất</a></li>
                        <?php else: ?>
                            <li><a href="<?php echo BASE_URL; ?>/login" class="btn btn-primary" style="padding: 10px 20px; text-decoration: none;">Đăng nhập</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <h1>Đặt lịch hẹn</h1>
            <p>Chọn dịch vụ và thời gian phù hợp với bạn</p>
        </div>
    </section>

    <!-- Booking Section -->
    <section class="booking-section">
        <div class="booking-container">
            <div class="booking-form-wrapper">
                <h2>Thông tin đặt lịch</h2>
                
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> Đặt lịch thành công! Chúng tôi sẽ xác nhận sớm.
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php endif; ?>

                <form id="bookingForm" method="POST" action="<?php echo BASE_URL; ?>/booking">
                    <!-- Dịch vụ -->
                    <div class="form-group">
                        <label><i class="fas fa-spa"></i> Chọn dịch vụ *</label>
                        <select name="service_id" id="service_id" class="form-control" required onchange="updateSummary()">
                            <option value="">-- Chọn dịch vụ --</option>
                            <?php 
                            if (!empty($services) && is_array($services)):
                                foreach ($services as $srv): 
                                    $selected = (isset($service) && $service['id'] == $srv['id']) ? 'selected' : '';
                                    $price = $srv['discount_price'] ?? $srv['price'];
                            ?>
                            <option value="<?= $srv['id'] ?>" 
                                    data-price="<?= $price ?>"
                                    data-duration="<?= $srv['duration'] ?>"
                                    data-name="<?= htmlspecialchars($srv['name']) ?>"
                                    <?= $selected ?>>
                                <?= htmlspecialchars($srv['name']) ?> - 
                                <?= number_format($price, 0, ',', '.') ?>₫ 
                                (<?= $srv['duration'] ?> phút)
                            </option>
                            <?php 
                                endforeach;
                            else:
                            ?>
                            <option disabled>Không có dịch vụ nào</option>
                            <?php endif; ?>
                        </select>
                        <?php if (empty($services)): ?>
                            <small style="color: #f56565;"><i class="fas fa-exclamation-triangle"></i> Chưa có dịch vụ nào. Vui lòng liên hệ admin.</small>
                        <?php endif; ?>
                    </div>

                    <!-- Nhân viên -->
                    <div class="form-group">
                        <label><i class="fas fa-user-tie"></i> Chọn nhân viên (Tùy chọn)</label>
                        <select name="staff_id" id="staff_id" class="form-control" onchange="updateSummary()">
                            <option value="">-- Không chọn --</option>
                            <?php 
                            if (!empty($staff) && is_array($staff)):
                                foreach ($staff as $member): 
                            ?>
                            <option value="<?= $member['id'] ?>">
                                <?= htmlspecialchars($member['full_name']) ?> - <?= htmlspecialchars($member['position']) ?>
                                (<?= $member['rating'] ?>★)
                            </option>
                            <?php 
                                endforeach;
                            else:
                            ?>
                            <option disabled>Không có nhân viên</option>
                            <?php endif; ?>
                        </select>
                        <small>Bạn có thể để hệ thống tự động phân công</small>
                    </div>

                    <!-- Ngày -->
                    <div class="form-group">
                        <label><i class="fas fa-calendar"></i> Chọn ngày *</label>
                        <input type="date" name="appointment_date" id="appointment_date" 
                               class="form-control" 
                               min="<?= date('Y-m-d') ?>" 
                               required
                               onchange="updateSummary()">
                    </div>

                    <!-- Giờ -->
                    <div class="form-group">
                        <label><i class="fas fa-clock"></i> Chọn giờ *</label>
                        <select name="appointment_time" id="appointment_time" class="form-control" required onchange="updateSummary()">
                            <option value="">-- Chọn giờ --</option>
                            <?php
                            $timeSlots = [
                                '08:00', '08:30', '09:00', '09:30', '10:00', '10:30',
                                '11:00', '11:30', '13:00', '13:30', '14:00', '14:30',
                                '15:00', '15:30', '16:00', '16:30', '17:00', '17:30',
                                '18:00', '18:30', '19:00', '19:30', '20:00'
                            ];
                            foreach ($timeSlots as $time):
                            ?>
                            <option value="<?= $time ?>"><?= $time ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Ghi chú -->
                    <div class="form-group">
                        <label><i class="fas fa-comment"></i> Ghi chú thêm</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3" 
                                  placeholder="Mô tả vấn đề bạn gặp phải hoặc yêu cầu đặc biệt..."></textarea>
                    </div>

                    <!-- Tổng tiền -->
                    <div class="booking-summary">
                        <h3>Tóm tắt đặt lịch</h3>
                        <div class="summary-row">
                            <span>Dịch vụ:</span>
                            <span id="summary_service">-</span>
                        </div>
                        <div class="summary-row">
                            <span>Nhân viên:</span>
                            <span id="summary_staff">-</span>
                        </div>
                        <div class="summary-row">
                            <span>Thời gian:</span>
                            <span id="summary_time">-</span>
                        </div>
                        <div class="summary-row total">
                            <span>Tổng cộng:</span>
                            <span id="summary_price">0₫</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                        <i class="fas fa-check-circle"></i> Xác nhận đặt lịch
                    </button>
                </form>
            </div>

            <div class="booking-info">
                <h3>Lưu ý khi đặt lịch</h3>
                <ul class="info-list">
                    <li><i class="fas fa-check-circle"></i> Vui lòng đến trước 15 phút để chuẩn bị</li>
                    <li><i class="fas fa-check-circle"></i> Hủy lịch trước ít nhất 2 giờ</li>
                    <li><i class="fas fa-check-circle"></i> Mang theo trang phục thoải mái</li>
                    <li><i class="fas fa-check-circle"></i> Thông báo dị ứng (nếu có)</li>
                </ul>

                <div class="contact-info">
                    <h4>Cần hỗ trợ?</h4>
                    <p><i class="fas fa-phone"></i> 1900 1234</p>
                    <p><i class="fas fa-envelope"></i> support@spaluxury.com</p>
                    <p><i class="fas fa-clock"></i> 8:00 - 21:00 (T2-CN)</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer style="background: #2d3748; color: white; padding: 40px 20px; text-align: center;">
        <p>&copy; 2026 Spa Luxury. All rights reserved.</p>
    </footer>

    <script>
    // Cập nhật tóm tắt
    function updateSummary() {
        const serviceSelect = document.getElementById('service_id');
        const staffSelect = document.getElementById('staff_id');
        const dateInput = document.getElementById('appointment_date');
        const timeSelect = document.getElementById('appointment_time');
        
        const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
        const selectedStaff = staffSelect.options[staffSelect.selectedIndex];
        
        const serviceName = selectedOption.dataset.name || '-';
        const staffName = selectedStaff.text.split(' - ')[0] || 'Tự động phân công';
        const date = dateInput.value || '';
        const time = timeSelect.value || '';
        const price = selectedOption.dataset.price || 0;
        
        document.getElementById('summary_service').textContent = serviceName;
        document.getElementById('summary_staff').textContent = staffName;
        document.getElementById('summary_time').textContent = date ? (date + ' ' + time) : '-';
        document.getElementById('summary_price').textContent = 
            price ? new Intl.NumberFormat('vi-VN').format(price) + '₫' : '0₫';
        
        // Enable submit button if all required fields are filled
        const submitBtn = document.getElementById('submitBtn');
        if (serviceSelect.value && date && time) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }

    // Form validation
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        const serviceSelect = document.getElementById('service_id');
        const dateInput = document.getElementById('appointment_date');
        const timeSelect = document.getElementById('appointment_time');
        
        if (!serviceSelect.value || !dateInput.value || !timeSelect.value) {
            e.preventDefault();
            alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
            return false;
        }
        
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
    });
    </script>
</body>
</html>