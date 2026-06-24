<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($service) ? 'Chỉnh sửa Dịch vụ' : 'Thêm Dịch vụ Mới'; ?> - Admin</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; background: #f7fafc; }
        
        .admin-wrapper { display: flex; min-height: 100vh; }
        
        /* Sidebar (giống services_list) */
        .admin-sidebar {
            width: 260px;
            background: linear-gradient(180deg, #2d3748 0%, #1a202c 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
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
            display: flex; align-items: center; padding: 14px 20px;
            color: #e2e8f0; text-decoration: none; transition: all 0.3s;
            border-left: 4px solid transparent;
        }
        .admin-menu li a:hover, .admin-menu li a.active {
            background: rgba(102, 126, 234, 0.1); color: white; border-left-color: #667eea;
        }
        .admin-menu li a i { margin-right: 12px; width: 20px; text-align: center; }
        
        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: 260px;
            padding: 30px;
        }
        
        .admin-header {
            background: white;
            padding: 20px 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .admin-header h1 { font-size: 28px; color: #2d3748; margin: 0 0 5px; }
        .admin-breadcrumb { color: #718096; font-size: 14px; }
        .admin-breadcrumb a { color: #667eea; text-decoration: none; }
        
        .btn-back {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 20px; background: #edf2f7; color: #4a5568;
            border-radius: 8px; text-decoration: none; font-weight: 500;
            transition: all 0.3s; margin-bottom: 20px;
        }
        .btn-back:hover { background: #e2e8f0; transform: translateX(-3px); }
        
        .form-container {
            background: white;
            border-radius: 12px;
            padding: 35px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .form-section {
            margin-bottom: 30px;
            padding-bottom: 25px;
            border-bottom: 1px solid #e2e8f0;
        }
        .form-section:last-child { border-bottom: none; }
        .section-title {
            font-size: 18px;
            color: #2d3748;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-title i { color: #667eea; }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #4a5568;
            font-size: 14px;
        }
        .form-group label .required { color: #e53e3e; }
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }
        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        textarea.form-control { min-height: 100px; resize: vertical; }
        .help-text {
            font-size: 13px;
            color: #718096;
            margin-top: 5px;
        }
        
        .image-upload-area {
            border: 2px dashed #cbd5e0;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            background: #f7fafc;
            transition: all 0.3s;
        }
        .image-upload-area:hover {
            border-color: #667eea;
            background: #f0f4ff;
        }
        .image-upload-area i {
            font-size: 48px;
            color: #cbd5e0;
            margin-bottom: 15px;
        }
        .image-upload-area input[type="file"] {
            display: none;
        }
        .btn-upload {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-upload:hover { background: #5568d3; }
        
        .preview-images {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        .preview-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #e2e8f0;
        }
        .preview-item img {
            width: 100%;
            height: 100px;
            object-fit: cover;
        }
        .preview-item .badge-main {
            position: absolute;
            top: 5px;
            left: 5px;
            background: #48bb78;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            padding-top: 25px;
            border-top: 1px solid #e2e8f0;
        }
        .btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
        .btn-cancel {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 30px;
            background: #edf2f7;
            color: #4a5568;
            border-radius: 8px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-cancel:hover { background: #e2e8f0; }
        
        .admin-footer {
            margin-top: 40px;
            padding: 20px 30px;
            background: white;
            border-radius: 12px;
            text-align: center;
            color: #718096;
            font-size: 14px;
        }
        
        @media (max-width: 768px) {
            .form-row { grid-template-columns: 1fr; }
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
                <h1><i class="fas fa-<?php echo isset($service) ? 'edit' : 'plus'; ?>" style="color: #667eea;"></i> 
                    <?php echo isset($service) ? 'Chỉnh sửa Dịch vụ' : 'Thêm Dịch vụ Mới'; ?>
                </h1>
                <div class="admin-breadcrumb">
                    <a href="<?php echo BASE_URL; ?>/admin">Admin</a> / 
                    <a href="<?php echo BASE_URL; ?>/admin/services">Dịch vụ</a> / 
                    <?php echo isset($service) ? 'Chỉnh sửa' : 'Thêm mới'; ?>
                </div>
            </div>

            <a href="<?php echo BASE_URL; ?>/admin/services" class="btn-back">
                <i class="fas fa-arrow-left"></i> Quay lại danh sách
            </a>

            <!-- Form -->
            <div class="form-container">
                <form method="POST" enctype="multipart/form-data">
                    <!-- Thông tin cơ bản -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Thông tin cơ bản
                        </h3>
                        
                        <div class="form-group">
                            <label>Tên dịch vụ <span class="required">*</span></label>
                            <input type="text" name="name" class="form-control" 
                                   value="<?php echo htmlspecialchars($service['name'] ?? ''); ?>" 
                                   placeholder="Ví dụ: Massage body thư giãn" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Mô tả chi tiết</label>
                            <textarea name="description" class="form-control" 
                                      placeholder="Mô tả chi tiết về dịch vụ..."><?php echo htmlspecialchars($service['description'] ?? ''); ?></textarea>
                        </div>
                    </div>

                    <!-- Giá và thời gian -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-clock"></i>
                            Thời gian & Giá cả
                        </h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Thời gian (phút) <span class="required">*</span></label>
                                <input type="number" name="duration" class="form-control" 
                                       value="<?php echo $service['duration'] ?? 60; ?>" 
                                       min="15" step="15" required>
                                <div class="help-text">Ví dụ: 60, 90, 120 phút</div>
                            </div>
                            
                            <div class="form-group">
                                <label>Danh mục</label>
                                <select name="category_id" class="form-control">
                                    <option value="">-- Không chọn --</option>
                                    <?php 
                                    // Load categories nếu có
                                    if (isset($categories) && !empty($categories)):
                                        foreach ($categories as $cat): 
                                    ?>
                                    <option value="<?php echo $cat['id']; ?>" 
                                            <?php echo ($service['category_id'] ?? '') == $cat['id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </option>
                                    <?php 
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Giá gốc (VNĐ) <span class="required">*</span></label>
                                <input type="number" name="price" class="form-control" 
                                       value="<?php echo $service['price'] ?? 0; ?>" 
                                       min="0" step="1000" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Giá khuyến mãi (VNĐ)</label>
                                <input type="number" name="discount_price" class="form-control" 
                                       value="<?php echo $service['discount_price'] ?? ''; ?>" 
                                       min="0" step="1000" 
                                       placeholder="Để trống nếu không có KM">
                                <div class="help-text">Để trống nếu không có khuyến mãi</div>
                            </div>
                        </div>
                    </div>

                    <!-- Lợi ích và đối tượng -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-check-circle"></i>
                            Lợi ích & Đối tượng
                        </h3>
                        
                        <div class="form-group">
                            <label>Lợi ích</label>
                            <textarea name="benefits" class="form-control" 
                                      placeholder="Nhập mỗi lợi ích trên một dòng...&#10;Ví dụ:&#10;- Giảm stress&#10;- Thư giãn cơ bắp&#10;- Cải thiện tuần hoàn máu"><?php echo htmlspecialchars($service['benefits'] ?? ''); ?></textarea>
                            <div class="help-text">Nhập mỗi lợi ích trên một dòng</div>
                        </div>

                        <div class="form-group">
                            <label>Phù hợp với</label>
                            <textarea name="suitable_for" class="form-control" 
                                      placeholder="Đối tượng phù hợp sử dụng dịch vụ..."><?php echo htmlspecialchars($service['suitable_for'] ?? ''); ?></textarea>
                        </div>
                    </div>

                    <!-- Hình ảnh -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-images"></i>
                            Hình ảnh dịch vụ
                        </h3>
                        
                        <div class="image-upload-area" onclick="document.getElementById('imageInput').click()">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <h3>Chọn hoặc kéo thả hình ảnh vào đây</h3>
                            <p style="color: #718096; margin: 10px 0;">Hỗ trợ: JPG, PNG, WEBP (Tối đa 5MB/file)</p>
                            <input type="file" name="images[]" id="imageInput" multiple accept="image/*" 
                                   onchange="previewImages(this)">
                            <span class="btn-upload">
                                <i class="fas fa-folder-open"></i> Chọn hình ảnh
                            </span>
                        </div>
                        
                        <!-- Preview new images -->
                        <div id="imagePreview" class="preview-images"></div>

                        <!-- Current images -->
                        <?php if (isset($service) && !empty($service['images'])): ?>
                        <div style="margin-top: 20px;">
                            <label style="font-weight: 600; color: #4a5568;">Hình ảnh hiện tại:</label>
                            <div class="preview-images">
                                <?php foreach ($service['images'] as $img): ?>
                                <div class="preview-item">
                                    <img src="<?php echo BASE_URL . '/' . ltrim($img['image_path'], '/'); ?>">
                                    <?php if ($img['is_main']): ?>
                                    <span class="badge-main"><i class="fas fa-star"></i> Ảnh chính</span>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Actions -->
                    <div class="form-actions">
                        <a href="<?php echo BASE_URL; ?>/admin/services" class="btn-cancel">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-save"></i> <?php echo isset($service) ? 'Cập nhật' : 'Tạo mới'; ?> dịch vụ
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="admin-footer">
                <p>&copy; <?php echo date('Y'); ?> Spa Luxury Admin Panel. All rights reserved.</p>
            </div>
        </main>
    </div>

    <script>
    function previewImages(input) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        
        if (input.files) {
            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'preview-item';
                    div.innerHTML = `
                        <img src="${e.target.result}">
                        ${index === 0 ? '<span class="badge-main"><i class="fas fa-star"></i> Ảnh chính</span>' : ''}
                    `;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }
    }

    // Auto-format number inputs
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value) {
                this.value = parseInt(this.value).toLocaleString('vi-VN');
            }
        });
        input.addEventListener('focus', function() {
            if (this.value) {
                this.value = this.value.replace(/,/g, '');
            }
        });
    });
    </script>
</body>
</html>