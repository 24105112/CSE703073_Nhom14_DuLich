<?php
require 'db.php';
header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->email) && !empty($data->password)) {
    // Băm mật khẩu bằng Bcrypt
    $hashed_password = password_hash($data->password, PASSWORD_BCRYPT);
    $role = 'user'; // Mặc định tài khoản mới là user thường

    $stmt = $pdo->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
    if ($stmt->execute([$data->email, $hashed_password, $role])) {
        echo json_encode(["status" => "success", "message" => "Đăng ký thành công!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi đăng ký."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Vui lòng nhập đủ email và password."]);
}
?>