<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Lịch Hẹn - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .admin-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 0;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .admin-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            transition: transform 0.2s;
            border-left: 4px solid;
        }
        .stat-card:hover {
            transform: translateY(-3px);
        }
        .stat-card.total { border-left-color: #667eea; }
        .stat-card.pending { border-left-color: #ffc107; }
        .stat-card.confirmed { border-left-color: #28a745; }
        .stat-card.completed { border-left-color: #17a2b8; }
        .stat-card.cancelled { border-left-color: #dc3545; }
        .stat-card.revenue { border-left-color: #28a745; }
        .stat-card h3 {
            font-size: 2rem;
            margin: 0;
            font-weight: 700;
        }
        .stat-card p {
            margin: 5px 0 0;
            color: #6c757d;
            font-size: 0.9rem;
        }
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-block;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #d4edda; color: #155724; }
        .status-completed { background: #d1ecf1; color: #0c5460; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .appointment-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .appointment-table th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            border: none;
            padding: 15px;
        }
        .appointment-table td {
            padding: 15px;
            vertical-align: middle;
        }
        .appointment-table tr:hover {
            background: #f8f9fa;
        }
        .filter-box {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .service-image-thumb {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            background: #f0f0f0;
        }
        .customer-info strong {
            color: #2d3748;
            display: block;
        }
        .customer-info small {
            color: #718096;
        }
        .btn-action {
            padding: 5px 10px;
            font-size: 12px;
            margin: 2px;
        }
        .datetime-info {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }
        .datetime-info .date {
            font-weight: 600;
            color: #2d3748;
        }
        .datetime-info .time {
            color: #667eea;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="admin-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1><i class="fas fa-calendar-check"></i> Quản Lý Lịch Hẹn</h1>
                    <p style="margin: 5px 0 0; opacity: 0.9;">Xem và quản lý tất cả lịch hẹn của khách hàng</p>
                </div>
                <div>
                    <a href="<?php echo BASE_URL; ?>/admin" class="btn btn-light me-2">
                        <i class="fas fa-arrow-left"></i> Dashboard
                    </a>
                    <a href="<?php echo BASE_URL; ?>/admin/appointments" class="btn btn-outline-light">
                        <i class="fas fa-sync"></i> Làm mới
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Statistics -->
        <div class="row mb-4">
            <div class="col-md-2 col-6">
                <div class="stat-card total">
                    <h3 style="color: #667eea;"><?php echo $stats['total']; ?></h3>
                    <p><i class="fas fa-calendar"></i> Tổng lịch</p>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="stat-card pending">
                    <h3 style="color: #ffc107;"><?php echo $stats['pending']; ?></h3>
                    <p><i class="fas fa-hourglass-half"></i> Chờ xác nhận</p>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="stat-card confirmed">
                    <h3 style="color: #28a745;"><?php echo $stats['confirmed']; ?></h3>
                    <p><i class="fas fa-check"></i> Đã xác nhận</p>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="stat-card completed">
                    <h3 style="color: #17a2b8;"><?php echo $stats['completed']; ?></h3>
                    <p><i class="fas fa-check-double"></i> Hoàn thành</p>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="stat-card cancelled">
                    <h3 style="color: #dc3545;"><?php echo $stats['cancelled']; ?></h3>
                    <p><i class="fas fa-times"></i> Đã hủy</p>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="stat-card revenue">
                    <h3 style="color: #28a745; font-size: 1.3rem;">
                        <?php echo number_format($stats['revenue'], 0, ',', '.'); ?>
                    </h3>
                    <p><i class="fas fa-dollar-sign"></i> Doanh thu (VNĐ)</p>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-box">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-search"></i> Tìm kiếm</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Tên khách, SĐT, email..." 
                           value="<?php echo htmlspecialchars($searchFilter); ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label"><i class="fas fa-filter"></i> Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="">Tất cả</option>
                        <option value="pending" <?php echo ($statusFilter === 'pending') ? 'selected' : ''; ?>>Chờ xác nhận</option>
                        <option value="confirmed" <?php echo ($statusFilter === 'confirmed') ? 'selected' : ''; ?>>Đã xác nhận</option>
                        <option value="completed" <?php echo ($statusFilter === 'completed') ? 'selected' : ''; ?>>Hoàn thành</option>
                        <option value="cancelled" <?php echo ($statusFilter === 'cancelled') ? 'selected' : ''; ?>>Đã hủy</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label"><i class="fas fa-calendar"></i> Ngày</label>
                    <input type="date" name="date" class="form-control" value="<?php echo $dateFilter; ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-user-tie"></i> Kỹ thuật viên</label>
                    <select name="staff_id" class="form-select">
                        <option value="">Tất cả</option>
                        <?php foreach ($staffList as $staff): ?>
                            <option value="<?php echo $staff['id']; ?>" <?php echo ($staffFilter == $staff['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($staff['full_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="fas fa-filter"></i> Lọc
                    </button>
                    <a href="<?php echo BASE_URL; ?>/admin/appointments" class="btn btn-secondary">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Appointments Table -->
        <div class="appointment-table">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Khách hàng</th>
                            <th>Dịch vụ</th>
                            <th>KTV thực hiện</th>
                            <th>Ngày & Giờ</th>
                            <th>Giá tiền</th>
                            <th>Trạng thái</th>
                            <th>Ghi chú</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($appointments)): ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted py-5">
                                    <i class="fas fa-inbox" style="font-size: 4rem; opacity: 0.3;"></i>
                                    <p class="mt-3 mb-0">Không tìm thấy lịch hẹn nào</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($appointments as $apt): ?>
                                <tr>
                                    <td><strong>#<?php echo $apt['id']; ?></strong></td>
                                    <td class="customer-info">
                                        <strong><?php echo htmlspecialchars($apt['customer_name'] ?? 'N/A'); ?></strong>
                                        <small><i class="fas fa-phone"></i> <?php echo htmlspecialchars($apt['customer_phone'] ?? ''); ?></small><br>
                                        <small><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($apt['customer_email'] ?? ''); ?></small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <?php if (!empty($apt['service_image'])): ?>
                                                <img src="<?php echo BASE_URL . '/' . ltrim($apt['service_image'], '/'); ?>" 
                                                     class="service-image-thumb"
                                                     onerror="this.style.display='none'">
                                            <?php endif; ?>
                                            <div>
                                                <strong><?php echo htmlspecialchars($apt['service_name'] ?? 'N/A'); ?></strong>
                                                <?php if (!empty($apt['duration'])): ?>
                                                    <br><small class="text-muted">
                                                        <i class="far fa-clock"></i> <?php echo $apt['duration']; ?> phút
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if (!empty($apt['staff_name'])): ?>
                                            <strong><?php echo htmlspecialchars($apt['staff_name']); ?></strong>
                                            <br><small class="text-muted"><?php echo htmlspecialchars($apt['staff_phone'] ?? ''); ?></small>
                                        <?php else: ?>
                                            <span class="text-muted">Chưa phân công</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="datetime-info">
                                            <span class="date">
                                                <i class="far fa-calendar"></i> 
                                                <?php echo date('d/m/Y', strtotime($apt['appointment_date'])); ?>
                                            </span>
                                            <span class="time">
                                                <i class="far fa-clock"></i> 
                                                <?php echo date('H:i', strtotime($apt['appointment_time'])); ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <strong style="color: #667eea;">
                                            <?php echo number_format($apt['total_price'], 0, ',', '.'); ?> VNĐ
                                        </strong>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo $apt['status']; ?>">
                                            <?php
                                            $statusText = [
                                                'pending' => '⏳ Chờ xác nhận',
                                                'confirmed' => '✓ Đã xác nhận',
                                                'completed' => '✓✓ Hoàn thành',
                                                'cancelled' => '✗ Đã hủy'
                                            ];
                                            echo $statusText[$apt['status']] ?? $apt['status'];
                                            ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if (!empty($apt['notes'])): ?>
                                            <small title="<?php echo htmlspecialchars($apt['notes']); ?>">
                                                <?php echo htmlspecialchars(mb_substr($apt['notes'], 0, 30)); ?>
                                                <?php if (strlen($apt['notes']) > 30) echo '...'; ?>
                                            </small>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($apt['status'] === 'pending'): ?>
                                            <button class="btn btn-success btn-action" onclick="updateStatus(<?php echo $apt['id']; ?>, 'confirmed')" title="Xác nhận">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="btn btn-danger btn-action" onclick="updateStatus(<?php echo $apt['id']; ?>, 'cancelled')" title="Hủy">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        <?php elseif ($apt['status'] === 'confirmed'): ?>
                                            <button class="btn btn-info btn-action" onclick="updateStatus(<?php echo $apt['id']; ?>, 'completed')" title="Hoàn thành">
                                                <i class="fas fa-check-double"></i>
                                            </button>
                                            <button class="btn btn-danger btn-action" onclick="updateStatus(<?php echo $apt['id']; ?>, 'cancelled')" title="Hủy">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        <?php elseif ($apt['status'] === 'cancelled'): ?>
                                            <button class="btn btn-warning btn-action" onclick="updateStatus(<?php echo $apt['id']; ?>, 'pending')" title="Khôi phục">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        <?php endif; ?>
                                        
                                        <button class="btn btn-outline-danger btn-action" 
                                                onclick="deleteAppointment(<?php echo $apt['id']; ?>)" 
                                                title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="text-muted text-center mt-3">
            <small>Hiển thị <?php echo count($appointments); ?> lịch hẹn</small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateStatus(appointmentId, newStatus) {
            const statusNames = {
                'confirmed': 'xác nhận',
                'completed': 'hoàn thành',
                'cancelled': 'hủy',
                'pending': 'khôi phục'
            };
            
            if (!confirm(`Bạn có chắc muốn ${statusNames[newStatus]} lịch hẹn này?`)) return;
            
            fetch('<?php echo BASE_URL; ?>/admin/appointments/update-status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: appointmentId,
                    status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ ' + data.message);
                    location.reload();
                } else {
                    alert('❌ Lỗi: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Có lỗi xảy ra!');
            });
        }
        
        function deleteAppointment(appointmentId) {
            if (!confirm('⚠️ Bạn có chắc muốn XÓA lịch hẹn này?\nHành động này không thể hoàn tác!')) return;
            
            window.location.href = '<?php echo BASE_URL; ?>/admin/appointments/delete/' + appointmentId;
        }
    </script>
</body>
</html>