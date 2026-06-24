<?php
$pageTitle = "Quản lý Nhân viên";
$currentPage = "staff";
require_once ROOT_PATH . DS . 'Views' . DS . 'admin' . DS . 'partials' . DS . 'sidebar.php';
?>

<style>
    /* CSS riêng cho trang staff (nếu cần) */
    .avatar-thumb {
        width: 45px; 
        height: 45px; 
        border-radius: 50%; 
        object-fit: cover; 
        border: 2px solid #e2e8f0;
    }
    .status-badge { 
        padding: 5px 10px; 
        border-radius: 20px; 
        font-size: 12px; 
        font-weight: 600; 
    }
    .status-active { background: #dcfce7; color: #166534; }
    .status-inactive { background: #fee2e2; color: #991b1b; }
    .action-btns { display: flex; gap: 10px; }
    .btn-edit { color: #d97706; text-decoration: none; font-weight: 500; }
    .btn-delete { color: #dc2626; text-decoration: none; font-weight: 500; }
</style>

<div class="page-header">
    <div>
        <h1><i class="fas fa-user-tie" style="color: #667eea;"></i> Quản lý Nhân viên</h1>
        <div class="breadcrumb">
            <a href="<?php echo BASE_URL; ?>/admin">Admin</a> / Nhân viên
        </div>
    </div>
    <a href="<?php echo BASE_URL; ?>/admin/add-staff" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm nhân viên
    </a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert <?php echo $_GET['msg'] === 'success' ? 'alert-success' : 'alert-error'; ?>">
        <i class="fas fa-<?php echo $_GET['msg'] === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
        <?php echo $_GET['msg'] === 'success' ? 'Thêm nhân viên thành công!' : 'Cập nhật thông tin thành công!'; ?>
    </div>
<?php endif; ?>

<div class="content-box">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th width="80">Ảnh</th>
                    <th>Tên nhân viên</th>
                    <th>Chức vụ</th>
                    <th>Chuyên môn</th>
                    <th width="100">Đánh giá</th>
                    <th width="100">Trạng thái</th>
                    <th width="150">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($staffList)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #94a3b8;">
                            <i class="fas fa-users" style="font-size: 48px; margin-bottom: 10px; display: block;"></i>
                            Chưa có nhân viên nào
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($staffList as $s): ?>
                    <tr>
                        <td>
                            <?php if (!empty($s['avatar'])): ?>
                                <img src="<?php echo BASE_URL . '/' . ltrim($s['avatar'], '/'); ?>" 
                                     alt="<?php echo htmlspecialchars($s['full_name']); ?>" 
                                     class="avatar-thumb">
                            <?php else: ?>
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($s['full_name']); ?>&background=3b82f6&color=fff" 
                                     alt="<?php echo htmlspecialchars($s['full_name']); ?>" 
                                     class="avatar-thumb">
                            <?php endif; ?>
                        </td>
                        <td><strong><?php echo htmlspecialchars($s['full_name']); ?></strong></td>
                        <td><?php echo htmlspecialchars($s['position']); ?></td>
                        <td><?php echo htmlspecialchars($s['specialization']); ?></td>
                        <td><span style="color: #f59e0b;">⭐ <?php echo number_format($s['rating'], 1); ?></span></td>
                        <td>
                            <span class="status-badge <?php echo ($s['status'] ?? 'active') === 'active' ? 'status-active' : 'status-inactive'; ?>">
                                <?php echo ($s['status'] ?? 'active') === 'active' ? 'Hoạt động' : 'Nghỉ việc'; ?>
                            </span>
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="<?php echo BASE_URL; ?>/admin/edit-staff/<?php echo $s['id']; ?>" class="btn-edit">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <a href="<?php echo BASE_URL; ?>/admin/delete-staff/<?php echo $s['id']; ?>" 
                                   class="btn-delete"
                                   onclick="return confirm('Xóa nhân viên \'<?php echo htmlspecialchars($s['full_name']); ?>\'?')">
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

<div class="admin-footer">
    <p>&copy; <?php echo date('Y'); ?> Spa Luxury Admin Panel. All rights reserved.</p>
</div>

<?php require_once ROOT_PATH . DS . 'Views' . DS . 'admin' . DS . 'partials' . DS . 'footer.php'; ?>