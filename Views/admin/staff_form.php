<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($staff) ? 'Sửa Nhân viên' : 'Thêm Nhân viên'; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reuse CSS */
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
        .admin-main { flex: 1; padding: 30px; background: #f7fafc; }
        .form-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); max-width: 800px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        .btn-submit { background: #667eea; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar ... -->
       
       <?php require_once ROOT_PATH . DS . 'Views' . DS . 'admin' . DS . 'partials' . DS . 'footer.php'; ?>
       
        <main class="admin-main">
            <div class="form-container">
                <h2><?php echo isset($staff) ? 'Sửa thông tin nhân viên' : 'Thêm nhân viên mới'; ?></h2>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Tên nhân viên</label>
                        <input type="text" name="full_name" class="form-control" value="<?php echo $staff['full_name'] ?? ''; ?>" required>
                    </div>
                    
                    <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $staff['email'] ?? ''; ?>">
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $staff['phone'] ?? ''; ?>">
                        </div>
                    </div>

                    <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label>Chức vụ</label>
                            <input type="text" name="position" class="form-control" value="<?php echo $staff['position'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Kinh nghiệm (năm)</label>
                            <input type="number" name="experience_years" class="form-control" value="<?php echo $staff['experience_years'] ?? 0; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Chuyên môn (Mô tả ngắn)</label>
                        <textarea name="specialization" class="form-control"><?php echo $staff['specialization'] ?? ''; ?></textarea>
                    </div>

                    <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label>Đánh giá (1-5)</label>
                            <input type="number" step="0.1" name="rating" class="form-control" value="<?php echo $staff['rating'] ?? 5.0; ?>">
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select name="status" class="form-control">
                                <option value="active" <?php echo ($staff['status'] ?? 'active') == 'active' ? 'selected' : ''; ?>>Hoạt động</option>
                                <option value="inactive" <?php echo ($staff['status'] ?? '') == 'inactive' ? 'selected' : ''; ?>>Nghỉ việc</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Ảnh đại diện</label>
                        <input type="file" name="avatar" class="form-control" accept="image/*">
                        <?php if (isset($staff['avatar'])): ?>
                            <img src="<?php echo BASE_URL . '/' . ltrim($staff['avatar'], '/'); ?>" style="width: 80px; margin-top: 10px; border-radius: 50%;">
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn-submit">Lưu thông tin</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>