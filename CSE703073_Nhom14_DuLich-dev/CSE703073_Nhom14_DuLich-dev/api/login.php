<?php
session_start();
require 'db.php';
header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->email) && !empty($data->password)) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$data->email]);
    $user = $stmt->fetch();

    if ($user && password_verify($data->password, $user['password'])) {
        // Lưu phiên đăng nhập
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        
        echo json_encode(["status" => "success", "message" => "Đăng nhập thành công!", "role" => $user['role']]);
    } else {
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "Sai email hoặc mật khẩu."]);
    }
}
?>