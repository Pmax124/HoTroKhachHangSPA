<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản - Spa Luxury</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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
        max-width: 500px;
    }
    .auth-header {
        text-align: center;
        margin-bottom: 30px;
    }
    .auth-header i {
        font-size: 50px;
        color: #667eea;
        margin-bottom: 15px;
    }
    .auth-header h1 {
        color: #2d3748;
        margin: 0 0 10px;
        font-size: 28px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #2d3748;
    }
    .form-group input, .form-group select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 15px;
        transition: border-color 0.3s;
    }
    .form-group input:focus, .form-group select:focus {
        outline: none;
        border-color: #667eea;
    }
    .btn-primary {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.3s;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
    }
    .auth-footer {
        text-align: center;
        margin-top: 20px;
        color: #718096;
    }
    .auth-footer a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
    }
    .alert {
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .alert-error {
        background: #fed7d7;
        color: #742a2a;
        border: 1px solid #fc8181;
    }
    .alert-success {
        background: #c6f6d5;
        color: #22543d;
        border: 1px solid #9ae6b4;
    }
    .password-strength {
        margin-top: 5px;
        font-size: 12px;
    }
    .strength-weak { color: #f56565; }
    .strength-medium { color: #ed8936; }
    .strength-strong { color: #48bb78; }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-header">
                <i class="fas fa-user-plus"></i>
                <h1>Đăng ký tài khoản</h1>
                <p>Tạo tài khoản để đặt lịch nhanh chóng</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Đăng ký thành công! Vui lòng đăng nhập.
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo BASE_URL; ?>/register">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Họ và tên *</label>
                    <input type="text" name="full_name" required placeholder="Nguyễn Văn A">
                </div>

                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email *</label>
                    <input type="email" name="email" required placeholder="example@email.com">
                </div>

                <div class="form-group">
                    <label><i class="fas fa-phone"></i> Số điện thoại *</label>
                    <input type="tel" name="phone" required placeholder="0901234567">
                </div>

                <div class="form-group">
                    <label><i class="fas fa-venus-mars"></i> Giới tính</label>
                    <select name="gender">
                        <option value="female">Nữ</option>
                        <option value="male">Nam</option>
                        <option value="other">Khác</option>
                    </select>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Mật khẩu *</label>
                    <input type="password" name="password" id="password" required 
                           placeholder="Ít nhất 6 ký tự" minlength="6"
                           onkeyup="checkPasswordStrength()">
                    <div class="password-strength" id="passwordStrength"></div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Xác nhận mật khẩu *</label>
                    <input type="password" name="confirm_password" required 
                           placeholder="Nhập lại mật khẩu">
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fas fa-user-plus"></i> Đăng ký
                </button>
            </form>

            <div class="auth-footer">
                Đã có tài khoản? <a href="<?php echo BASE_URL; ?>/login">Đăng nhập ngay</a>
            </div>
        </div>
    </div>

    <script>
    function checkPasswordStrength() {
        const password = document.getElementById('password').value;
        const strengthDiv = document.getElementById('passwordStrength');
        
        if (password.length < 6) {
            strengthDiv.innerHTML = '<span class="strength-weak">Mật khẩu quá ngắn</span>';
        } else if (password.length < 10) {
            strengthDiv.innerHTML = '<span class="strength-medium">Mật khẩu trung bình</span>';
        } else {
            strengthDiv.innerHTML = '<span class="strength-strong">Mật khẩu mạnh</span>';
        }
    }
    </script>
</body>
</html>