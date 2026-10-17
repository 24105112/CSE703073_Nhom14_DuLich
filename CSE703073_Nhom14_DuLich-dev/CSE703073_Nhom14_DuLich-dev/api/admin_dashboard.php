<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// Middleware Phân quyền: Kiểm tra nếu không phải admin thì chặn luôn (Mã lỗi 403)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "403 Forbidden: Bạn không có quyền truy cập trang quản trị."]);
    exit();
}

echo json_encode(["status" => "success", "message" => "Chào mừng Admin, đây là dữ liệu quản trị mật."]);
?>