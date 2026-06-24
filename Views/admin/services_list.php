<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Dịch vụ - Admin</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; background: #f7fafc; }
        
        /* Admin Layout */
        .admin-wrapper { display: flex; min-height: 100vh; }
        
        /* Sidebar */
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
        
        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: 260px;
            padding: 30px;
        }
        
        /* Header */
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
        
        /* Content Box */
        .content-box {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        /* Alert */
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
        
        /* Table */
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
        
        /* Footer */
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
                <li><a href="<?php echo BASE_URL; ?>/admin">
                    <i class="fas fa-home"></i> Tổng quan
                </a></li>
                <li><a href="<?php echo BASE_URL; ?>/admin/services" class="active">
                    <i class="fas fa-spa"></i> Dịch vụ
                </a></li>
                <li><a href="<?php echo BASE_URL; ?>/admin/categories">
                    <i class="fas fa-folder"></i> Danh mục
                </a></li>
                <li><a href="<?php echo BASE_URL; ?>/admin/appointments">
                    <i class="fas fa-calendar"></i> Đặt lịch
                </a></li>
                <li><a href="<?php echo BASE_URL; ?>/admin/customers">
                    <i class="fas fa-users"></i> Khách hàng
                </a></li>
                <li><a href="<?php echo BASE_URL; ?>/admin/staff">
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
            <!-- Header -->
            <div class="admin-header">
                <div>
                    <h1><i class="fas fa-spa" style="color: #667eea;"></i> Quản lý Dịch vụ</h1>
                    <div class="admin-breadcrumb">
                        <a href="<?php echo BASE_URL; ?>/admin">Admin</a> / Dịch vụ
                    </div>
                </div>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <a href="<?php echo BASE_URL; ?>/admin" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                    <a href="<?php echo BASE_URL; ?>/admin/add-service" class="btn-add">
                        <i class="fas fa-plus"></i> Thêm dịch vụ
                    </a>
                </div>
            </div>

            <?php if (isset($_GET['msg'])): ?>
                <div class="alert <?php echo $_GET['msg'] === 'success' ? 'alert-success' : 'alert-error'; ?>">
                    <i class="fas fa-<?php echo $_GET['msg'] === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                    <?php echo $_GET['msg'] === 'success' ? 'Thêm dịch vụ thành công!' : 'Cập nhật dịch vụ thành công!'; ?>
                </div>
            <?php endif; ?>

            <!-- Content -->
            <div class="content-box">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th width="80">Ảnh</th>
                                <th>Tên dịch vụ</th>
                                <th>Giá</th>
                                <th>Danh mục</th>
                                <th width="100">Trạng thái</th>
                                <th width="180">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($services)): ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 40px; color: #a0aec0;">
                                        <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 10px; display: block;"></i>
                                        Chưa có dịch vụ nào
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($services as $s): 
                                    $mainImage = null;
                                    if (!empty($s['images'])) {
                                        foreach ($s['images'] as $img) {
                                            if ($img['is_main']) {
                                                $mainImage = $img['image_path'];
                                                break;
                                            }
                                        }
                                        if (!$mainImage && !empty($s['images'][0]['image_path'])) {
                                            $mainImage = $s['images'][0]['image_path'];
                                        }
                                    }
                                ?>
                                <tr>
                                    <td>
                                        <?php if ($mainImage): ?>
                                            <img src="<?php echo BASE_URL . '/' . ltrim($mainImage, '/'); ?>" 
                                                 alt="<?php echo htmlspecialchars($s['name']); ?>" 
                                                 class="thumb">
                                        <?php else: ?>
                                            <div class="no-image"><i class="fas fa-image"></i></div>
                                        <?php endif; ?>
                                    </td>
                                    <td><strong><?php echo htmlspecialchars($s['name']); ?></strong></td>
                                    <td>
                                        <?php if ($s['discount_price']): ?>
                                            <span style="text-decoration: line-through; color: #a0aec0; font-size: 13px;">
                                                <?php echo number_format($s['price'], 0, ',', '.'); ?>₫
                                            </span><br>
                                            <strong style="color: #e53e3e;">
                                                <?php echo number_format($s['discount_price'], 0, ',', '.'); ?>₫
                                            </strong>
                                        <?php else: ?>
                                            <?php echo number_format($s['price'], 0, ',', '.'); ?>₫
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($s['category_name'] ?? 'Chưa phân loại'); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo ($s['status'] ?? 'active') === 'active' ? 'active' : 'inactive'; ?>">
                                            <?php echo ($s['status'] ?? 'active') === 'active' ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="<?php echo BASE_URL; ?>/admin/edit-service/<?php echo $s['id']; ?>" 
                                               class="btn-action btn-edit">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                            <a href="<?php echo BASE_URL; ?>/admin/delete-service/<?php echo $s['id']; ?>" 
                                               class="btn-action btn-delete"
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa dịch vụ \'<?php echo htmlspecialchars($s['name']); ?>\'?')">
                                                <i class="fas fa-trash"></i> Xóa
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer -->
            <div class="admin-footer">
                <p>&copy; <?php echo date('Y'); ?> Spa Luxury Admin Panel. All rights reserved.</p>
            </div>
        </main>
    </div>
</body>
</html>