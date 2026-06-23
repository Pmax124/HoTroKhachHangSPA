    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="footer-logo">
                        <i class="fas fa-spa"></i>
                        <span>Spa Luxury</span>
                    </div>
                    <p>Địa chỉ chăm sóc sắc đẹp và thư giãn hàng đầu. Chúng tôi cam kết mang đến cho bạn trải nghiệm tuyệt vời nhất.</p>
                    <div class="footer-social">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                
                <div class="footer-col">
                    <h4>Dịch vụ</h4>
                    <ul>
                        <li><a href="<?php echo BASE_URL; ?>/services#massage">Massage</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/services#skincare">Chăm sóc da</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/services#body">Spa body</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/services#hair">Gội đầu dưỡng sinh</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Liên kết</h4>
                    <ul>
                        <li><a href="<?php echo BASE_URL; ?>/about">Về chúng tôi</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/services">Dịch vụ</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/booking">Đặt lịch</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/contact">Liên hệ</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Liên hệ</h4>
                    <ul class="footer-contact">
                        <li><i class="fas fa-map-marker-alt"></i> 123 Nguyễn Văn A, Quận 1, TP.HCM</li>
                        <li><i class="fas fa-phone"></i> 1900 1234</li>
                        <li><i class="fas fa-envelope"></i> info@spaluxury.com</li>
                        <li><i class="fas fa-clock"></i> 8:00 - 21:00 (T2-CN)</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2026 Spa Luxury. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="<?php echo BASE_URL; ?>/public/js/main.js"></script>
    
    <script>
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.style.display = 'none';
            });
        }
    });
    </script>
</body>
</html>