<?php
/**
 * Tạo URL asset (CSS, JS, images)
 * @param string $path Đường dẫn tương đối từ public/
 * @return string URL đầy đủ
 */
function asset($path) {
    return BASE_URL . '/public/' . ltrim($path, '/');
}

/**
 * Tạo URL route
 * @param string $path Đường dẫn route
 * @return string URL đầy đủ
 */
function url($path = '') {
    return BASE_URL . '/' . ltrim($path, '/');
}

/**
 * Format số tiền VNĐ
 * @param float|int $amount Số tiền
 * @return string Đã format
 */
function format_money($amount) {
    return number_format($amount, 0, ',', '.') . '₫';
}