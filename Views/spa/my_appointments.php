<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch hẹn của tôi - Spa Luxury</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6f42c1;
            --primary-light: #f3f0ff;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .page-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #9c74e8 100%);
            color: white;
            padding: 40px 0;
            margin-bottom: 40px;
            box-shadow: 0 4px 20px rgba(111, 66, 193, 0.3);
        }
        
        .page-header h1 {
            font-weight: 600;
            margin: 0;
        }
        
        .page-header p {
            opacity: 0.9;
            margin: 10px 0 0 0;
        }
        
        .appointment-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: none;
        }
        
        .appointment-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(111, 66, 193, 0.15);
        }
        
        .appointment-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            background: linear-gradient(135deg, #e0e0e0 0%, #f5f5f5 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 48px;
        }
        
        .appointment-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .appointment-body {
            padding: 24px;
        }
        
        .service-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 12px;
        }
        
        .info-row {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            color: #555;
        }
        
        .info-row i {
            width: 24px;
            color: var(--primary-color);
            margin-right: 10px;
            font-size: 1.1rem;
        }
        
        .info-row strong {
            color: #2c3e50;
            margin-right: 6px;
        }
        
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .status-pending {
            background: #fff8e1;
            color: #f57c00;
        }
        
        .status-confirmed {
            background: #e8f5e9;
            color: #2e7d32;
        }
        
        .status-cancelled {
            background: #ffebee;
            color: #c62828;
        }
        
        .status-completed {
            background: #e3f2fd;
            color: #1565c0;
        }
        
        .price-tag {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary-color);
            background: var(--primary-light);
            padding: 8px 16px;
            border-radius: 8px;
            display: inline-block;
        }
        
        .btn-cancel {
            background: white;
            color: var(--danger-color);
            border: 2px solid var(--danger-color);
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-cancel:hover {
            background: var(--danger-color);
            color: white;
            transform: scale(1.05);
        }
        
        .btn-reschedule {
            background: var(--primary-color);
            color: white;
            border: 2px solid var(--primary-color);
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-reschedule:hover {
            background: #5a32a3;
            color: white;
            transform: scale(1.05);
        }
        
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }
        
        .empty-state i {
            font-size: 100px;
            color: #e0e0e0;
            margin-bottom: 24px;
        }
        
        .empty-state h3 {
            color: #555;
            margin-bottom: 16px;
        }
        
        .btn-primary-custom {
            background: var(--primary-color);
            color: white;
            padding: 14px 32px;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .btn-primary-custom:hover {
            background: #5a32a3;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(111, 66, 193, 0.3);
        }
        
        .pagination .page-link {
            color: var(--primary-color);
            border: none;
            padding: 10px 16px;
            margin: 0 4px;
            border-radius: 8px;
        }
        
        .pagination .page-item.active .page-link {
            background: var(--primary-color);
            color: white;
        }
        
        .duration-badge {
            background: #f0f0f0;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            color: #666;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        
        @media (max-width: 768px) {
            .appointment-image {
                height: 180px;
            }
            
            .service-title {
                font-size: 1.2rem;
            }
            
            .price-tag {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="page-header">
        <div class="container">
            <h1><i class="fas fa-calendar-check"></i> Lịch hẹn của tôi</h1>
            <p>Quản lý tất cả các lịch hẹn của bạn tại Spa Luxury</p>
        </div>
    </div>
    
    <div class="container mb-5">
        <?php if (empty($appointments)): ?>
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <h3>Bạn chưa có lịch hẹn nào</h3>
                <p class="text-muted mb-4">Hãy đặt lịch ngay để trải nghiệm dịch vụ chăm sóc sắc đẹp tuyệt vời!</p>
                <a href="<?= BASE_URL ?>/booking" class="btn-primary-custom">
                    <i class="fas fa-plus"></i> Đặt lịch ngay
                </a>
            </div>
        <?php else: ?>
            <?php foreach ($appointments as $appointment): ?>
                <div class="appointment-card">
                    <div class="row g-0">
                        <!-- Ảnh dịch vụ -->
                        <div class="col-md-4">
                            <div class="appointment-image">
                                <?php if (!empty($appointment['service_image'])): ?>
                                    <img src="<?= BASE_URL ?>/<?= htmlspecialchars($appointment['service_image']) ?>" 
                                         alt="<?= htmlspecialchars($appointment['service_name']) ?>">
                                <?php else: ?>
                                    <i class="fas fa-spa"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Thông tin -->
                        <div class="col-md-8">
                            <div class="appointment-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h3 class="service-title"><?= htmlspecialchars($appointment['service_name']) ?></h3>
                                        <?php if (!empty($appointment['duration'])): ?>
                                            <span class="duration-badge">
                                                <i class="fas fa-clock"></i> <?= $appointment['duration'] ?> phút
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <span class="status-badge status-<?= $appointment['status'] ?>">
                                        <?php
                                        $statusConfig = [
                                            'pending' => ['icon' => 'fa-hourglass-half', 'text' => 'Chờ xác nhận'],
                                            'confirmed' => ['icon' => 'fa-check-circle', 'text' => 'Đã xác nhận'],
                                            'cancelled' => ['icon' => 'fa-times-circle', 'text' => 'Đã hủy'],
                                            'completed' => ['icon' => 'fa-check-double', 'text' => 'Hoàn thành']
                                        ];
                                        $config = $statusConfig[$appointment['status']] ?? ['icon' => 'fa-circle', 'text' => $appointment['status']];
                                        ?>
                                        <i class="fas <?= $config['icon'] ?>"></i> <?= $config['text'] ?>
                                    </span>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-row">
                                            <i class="fas fa-calendar-day"></i>
                                            <strong>Ngày:</strong>
                                            <span><?= date('d/m/Y', strtotime($appointment['appointment_date'])) ?></span>
                                        </div>
                                        
                                        <div class="info-row">
                                            <i class="fas fa-clock"></i>
                                            <strong>Giờ:</strong>
                                            <span><?= date('H:i', strtotime($appointment['appointment_time'])) ?></span>
                                        </div>
                                        
                                        <?php if (!empty($appointment['staff_name'])): ?>
                                            <div class="info-row">
                                                <i class="fas fa-user-tie"></i>
                                                <strong>Kỹ thuật viên:</strong>
                                                <span><?= htmlspecialchars($appointment['staff_name']) ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <?php if (!empty($appointment['spa_name'])): ?>
                                            <div class="info-row">
                                                <i class="fas fa-store"></i>
                                                <strong>Chi nhánh:</strong>
                                                <span><?= htmlspecialchars($appointment['spa_name']) ?></span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($appointment['spa_address'])): ?>
                                            <div class="info-row">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <strong>Địa chỉ:</strong>
                                                <span><?= htmlspecialchars($appointment['spa_address']) ?></span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="mt-3">
                                            <div class="price-tag">
                                                <i class="fas fa-tag"></i> <?= number_format($appointment['total_price'], 0, ',', '.') ?> VNĐ
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if (!empty($appointment['notes'])): ?>
                                    <div class="info-row mt-3" style="background: #f8f9fa; padding: 12px; border-radius: 8px;">
                                        <i class="fas fa-sticky-note"></i>
                                        <strong>Ghi chú:</strong>
                                        <span><?= htmlspecialchars($appointment['notes']) ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Action buttons -->
                                <?php if ($appointment['status'] === 'pending' || $appointment['status'] === 'confirmed'): ?>
                                    <div class="mt-4 d-flex gap-2 flex-wrap">
                                        <button class="btn btn-reschedule" onclick="rescheduleAppointment(<?= $appointment['id'] ?>)">
                                            <i class="fas fa-redo"></i> Đổi lịch
                                        </button>
                                        <button class="btn btn-cancel" onclick="cancelAppointment(<?= $appointment['id'] ?>)">
                                            <i class="fas fa-times"></i> Hủy lịch
                                        </button>
                                        <?php if (!empty($appointment['spa_phone'])): ?>
                                            <a href="tel:<?= htmlspecialchars($appointment['spa_phone']) ?>" class="btn btn-outline-primary" style="border-radius: 8px; padding: 10px 20px;">
                                                <i class="fas fa-phone"></i> Gọi spa
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>">
                                <i class="fas fa-chevron-left"></i> Trước
                            </a>
                        </li>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page + 1 ?>">
                                Sau <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function cancelAppointment(appointmentId) {
            if (confirm('Bạn có chắc muốn hủy lịch hẹn này?')) {
                fetch('<?= BASE_URL ?>/cancel-appointment/' + appointmentId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Đã hủy lịch hẹn thành công!');
                        location.reload();
                    } else {
                        alert('Lỗi: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra. Vui lòng thử lại.');
                });
            }
        }
        
        function rescheduleAppointment(appointmentId) {
            // Chuyển đến trang đặt lịch với ID dịch vụ
            window.location.href = '<?= BASE_URL ?>/booking?reschedule=' + appointmentId;
        }
    </script>
</body>
</html>