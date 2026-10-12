<?php
session_start();
// Xóa tất cả các biến session
session_unset();
// Hủy session
session_destroy();

header('Content-Type: application/json; charset=utf-8');
echo json_encode(["status" => "success", "message" => "Đăng xuất thành công!"]);
?>