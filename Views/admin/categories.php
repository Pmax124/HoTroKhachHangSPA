<?php require_once ROOT_PATH . '/Views/admin/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-folder"></i> Quản lý danh mục</h2>
        <a href="<?php echo BASE_URL; ?>/admin/add-category" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm danh mục mới
        </a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> Thao tác thành công!
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($_GET['error']); ?>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tên danh mục</th>
                            <th>Mô tả</th>
                            <th>Thứ tự</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?php echo $category['id']; ?></td>
                                <td><strong><?php echo htmlspecialchars($category['name']); ?></strong></td>
                                <td><?php echo htmlspecialchars(mb_substr($category['description'], 0, 80)) . (mb_strlen($category['description']) > 80 ? '...' : ''); ?></td>
                                <td><?php echo $category['display_order']; ?></td>
                                <td>
                                    <?php if ($category['status'] === 'active'): ?>
                                        <span class="badge badge-success">
                                            <i class="fas fa-check"></i> Hoạt động
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-times"></i> Vô hiệu
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($category['created_at'])); ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo BASE_URL; ?>/admin/edit-category/<?php echo $category['id']; ?>" 
                                           class="btn btn-sm btn-warning" 
                                           title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="deleteCategory(<?php echo $category['id']; ?>, '<?php echo htmlspecialchars($category['name']); ?>')"
                                                title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <p>Chưa có danh mục nào. <a href="<?php echo BASE_URL; ?>/admin/add-category">Thêm danh mục đầu tiên</a></p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function deleteCategory(id, name) {
    if (confirm('Bạn có chắc chắn muốn xóa danh mục "' + name + '"?\n\nLưu ý: Chỉ có thể xóa danh mục không có dịch vụ nào.')) {
        fetch('<?php echo BASE_URL; ?>/admin/delete-category/' + id, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Đã xóa danh mục thành công!');
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
</script>

<?php require_once ROOT_PATH . '/Views/admin/footer.php'; ?>