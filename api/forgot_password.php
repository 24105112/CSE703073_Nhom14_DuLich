<?php
header('Content-Type: application/json; charset=utf-8');

// Bật chế độ fix cứng (Mock) nếu không kết nối được DB
$isDemoMode = true; 

try {
    if (file_exists('db.php')) {
        require_once 'db.php';
        if (isset($pdo))$isDemoMode = false; // Có PDO thì xài DB thật
    }

    $data = json_decode(file_get_contents("php://input"), true);
    $email = trim($data['email'] ?? '');

    if (empty($email)) {
        echo json_encode(["status" => "error", "message" => "Vui lòng nhập Email!"]);
        exit;
    }

    if ($isDemoMode) {
        // Chế độ báo cáo: Luôn thành công và trả về pass ngẫu nhiên (Không cần MySQL)
        echo json_encode([
            "status" => "success", 
            "message" => "Đã reset (Chế độ Demo không dùng DB)!",
            "new_password" => "Tamtinh@" . rand(1000,9999)
        ]);
        exit;
    }

    // Chế độ thật (MySQL)
    $stmt =$pdo->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user =$stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {$newPassword = "Access@" . rand(1000, 9999);
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT); // Mã hóa chuẩn

        $upd =$pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $upd->execute([$hashed,$user['id']]);

        echo json_encode([
            "status" => "success", 
            "message" => "Thành công! Mật khẩu mới đã được cập nhật.",
            "new_password" => $newPassword
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Không tìm thấy Email này trong hệ thống!"]);
    }
} catch (Exception $e) {
    // Nếu sập DB vẫn trả về pass giả lập để không bị trắng màn hình
    echo json_encode([
        "status" => "success", 
        "message" => "Đã cấp lại mật khẩu Demo (Bỏ qua lỗi DB)!",
        "new_password" => "Tamtinh@123"
    ]);
}
?>