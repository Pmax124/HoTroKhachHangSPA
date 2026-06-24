<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Spa Luxury</title>
    
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .admin-layout { display: flex; min-height: 100vh; }
       
        .admin-menu { 
            list-style: none; 
            padding: 0; 
            margin: 20px 0; 
        }
        .admin-menu li a { 
            display: block; 
            padding: 12px 20px; 
            color: #e2e8f0; 
            text-decoration: none;
            transition: all 0.3s;
        }
        .admin-menu li a:hover, .admin-menu li a.active { 
            background: #4a5568; 
            color: white; 
        }
        .admin-menu li a i { margin-right: 10px; width: 20px; }
        .admin-content { 
            flex: 1; 
            background: #f7fafc; 
            padding: 30px;
            margin-left: 250px;
        }
        .admin-header { 
            background: white; 
            padding: 20px 30px; 
            border-radius: 10px; 
            margin-bottom: 30px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .stat-card-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .stat-card-icon.blue { background: #eef2ff; color: #667eea; }
        .stat-card-icon.green { background: #f0fff4; color: #48bb78; }
        .stat-card-icon.yellow { background: #fffaf0; color: #ed8936; }
        .stat-card-icon.purple { background: #faf5ff; color: #9f7aea; }
        .stat-card-value {
            font-size: 28px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 5px;
        }
        .stat-card-label {
            color: #718096;
            font-size: 14px;
        }
        .recent-table {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        table { width: 100%; border-collapse: collapse; }
        table th, table td { 
            padding: 12px; 
            text-align: left; 
            border-bottom: 1px solid #e2e8f0; 
        }
        table th { 
            font-weight: 600; 
            color: #4a5568; 
            background: #f7fafc; 
        }
        .status-badge { 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: 600; 
        }
        .status-pending { background: #fefcbf; color: #744210; }
        .status-confirmed { background: #c6f6d5; color: #22543d; }
        .status-completed { background: #eef2ff; color: #434190; }
        .status-cancelled { background: #fed7d7; color: #742a2a; }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <!-- 2. GỌI FILE SIDEBAR TẠI ĐÂY -->
        <?php require_once ROOT_PATH . DS . 'Views' . DS . 'admin' . DS . 'partials' . DS . 'sidebar.php'; ?>
        </aside>

        <!-- Main Content -->
        <main class="admin-content">
            <?php
                    $pageTitle = "Quản lý Nhân viên";
                    $currentPage = "staff"; 
                    require_once ROOT_PATH . DS . 'Views' . DS . 'admin' . DS . 'partials' . DS . 'sidebar.php';
                    ?>

            <div class="admin-header">
                <h1>Tổng quan</h1>
                <div>
                    Xin chào, <strong><?php echo htmlspecialchars($_SESSION['admin_name']); ?></strong>
                </div>
            </div>

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-card-value"><?php echo $stats['total_customers']; ?></div>
                            <div class="stat-card-label">Khách hàng</div>
                        </div>
                        <div class="stat-card-icon blue">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-card-value"><?php echo $stats['total_appointments']; ?></div>
                            <div class="stat-card-label">Tổng đặt lịch</div>
                        </div>
                        <div class="stat-card-icon green">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-card-value"><?php echo $stats['pending_appointments']; ?></div>
                            <div class="stat-card-label">Chờ xác nhận</div>
                        </div>
                        <div class="stat-card-icon yellow">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-card-value"><?php echo number_format($stats['total_revenue'], 0, ',', '.'); ?>₫</div>
                            <div class="stat-card-label">Doanh thu</div>
                        </div>
                        <div class="stat-card-icon purple">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Appointments -->
            <div class="recent-table">
                <h3>Đặt lịch gần đây</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Khách hàng</th>
                            <th>Dịch vụ</th>
                            <th>Nhân viên</th>
                            <th>Ngày giờ</th>
                            <th>Trạng thái</th>
                            <th>Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentAppointments as $apt): ?>
                        <tr>
                            <td>#<?php echo $apt['id']; ?></td>
                            <td><?php echo htmlspecialchars($apt['customer_name'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($apt['service_name'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($apt['staff_name'] ?? 'Chưa phân công'); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($apt['appointment_date'] . ' ' . $apt['appointment_time'])); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo $apt['status']; ?>">
                                    <?php
                                    $statusText = [
                                        'pending' => 'Chờ xác nhận',
                                        'confirmed' => 'Đã xác nhận',
                                        'completed' => 'Hoàn thành',
                                        'cancelled' => 'Đã hủy'
                                    ];
                                    echo $statusText[$apt['status']] ?? $apt['status'];
                                    ?>
                                </span>
                            </td>
                            <td><?php echo number_format($apt['total_price'], 0, ',', '.'); ?>₫</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>