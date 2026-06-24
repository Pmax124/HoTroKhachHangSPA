<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Spa Luxury</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Giữ nguyên style cũ nhưng ẩn tab đi */
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }
        .auth-box {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            width: 100%;
            max-width: 450px;
        }
        .auth-header { text-align: center; margin-bottom: 30px; }
        .auth-header i { font-size: 50px; color: #667eea; margin-bottom: 15px; }
        .auth-header h1 { color: #2d3748; margin: 0 0 10px; font-size: 28px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #2d3748; }
        .form-group input {
            width: 100%; padding: 12px 15px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 15px;
        }
        .form-group input:focus { outline: none; border-color: #667eea; }
        .btn-primary {
            width: 100%; padding: 14px; background: linear-gradient(135deg, #667eea, #764ba2);
            color: white; border: none; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer;
        }
        .btn-primary:hover { transform: translateY(-2px); }
        .auth-footer { text-align: center; margin-top: 20px; color: #718096; }
        .auth-footer a { color: #667eea; text-decoration: none; font-weight: 600; }
        .alert { padding: 12px 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-error { background: #fed7d7; color: #742a2a; border: 1px solid #fc8181; }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-header">
                <i class="fas fa-spa"></i>
                <h1>Đăng nhập</h1>
                <p>Hệ thống quản lý Spa Luxury</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Form đăng nhập chung -->
            <form method="POST" action="<?php echo BASE_URL; ?>/login">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Email hoặc Tên đăng nhập</label>
                    <input type="text" name="identifier" required placeholder="Nhập email (khách) hoặc username (admin)">
                </div>

                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Mật khẩu</label>
                    <input type="password" name="password" required placeholder="Nhập mật khẩu">
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Đăng nhập
                </button>
            </form>

            <div class="auth-footer">
                Chưa có tài khoản khách hàng? <a href="<?php echo BASE_URL; ?>/register">Đăng ký ngay</a>
            </div>
        </div>
    </div>
</body>
</html>