<?php require_once ROOT_PATH . '/Views/admin/header.php'; ?>

<div class="container mt-4">
    <h2><i class="fas fa-edit"></i> Chỉnh sửa danh mục</h2>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo BASE_URL; ?>/admin/edit-category/<?php echo $category['id']; ?>">
        <div class="form-group">
            <label for="name">Tên danh mục <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="<?php echo htmlspecialchars($category['name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($category['description']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="display_order">Thứ tự hiển thị</label>
            <input type="number" class="form-control" id="display_order" name="display_order" 
                   value="<?php echo $category['display_order']; ?>" min="0">
        </div>

        <div class="form-group">
            <label for="status">Trạng thái</label>
            <select class="form-control" id="status" name="status">
                <option value="active" <?php echo $category['status'] === 'active' ? 'selected' : ''; ?>>Hoạt động</option>
                <option value="inactive" <?php echo $category['status'] === 'inactive' ? 'selected' : ''; ?>>Vô hiệu</option>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <a href="<?php echo BASE_URL; ?>/admin/categories" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Cập nhật danh mục
            </button>
        </div>
    </form>
</div>

<?php require_once ROOT_PATH . '/Views/admin/footer.php'; ?>