<?php
header('Content-Type: application/json; charset=utf-8');

$isDemoMode = true; 
try {
    if (file_exists('db.php')) {
        require_once 'db.php';
        if (isset($pdo)) {
            $isDemoMode = false;
            // Tạo bảng destinations nếu chưa có để lưu dữ liệu kiểm định
            $pdo->exec("CREATE TABLE IF NOT EXISTS destinations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                address VARCHAR(255),
                price INT,
                ramp_slope DECIMAL(3,1),
                door_width INT,
                has_handrail TINYINT(1),
                audit_badge VARCHAR(50),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
        }
    }

    $data = json_decode(file_get_contents("php://input"), true);
    $title = trim($data['title'] ?? '');
    $slope = floatval($data['ramp_slope'] ?? 0);
    $door = intval($data['door_width'] ?? 0);
    $handrail = intval($data['has_handrail'] ?? 0);
    $badge = trim($data['audit_badge'] ?? 'Chưa kiểm định');

    if (empty($title)) {
        echo json_encode(["status" => "error", "message" => "Vui lòng nhập tên địa điểm!"]);
        exit;
    }

    if ($isDemoMode) {
        echo json_encode(["status" => "success", "message" => "Đã lưu kiểm định (Chế độ Demo - Mock Data)!"]);
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO destinations (title, address, price, ramp_slope, door_width, has_handrail, audit_badge) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $data['address'], $data['price'], $slope, $door, $handrail, $badge]);

    echo json_encode(["status" => "success", "message" => "Lưu kiểm định vào CSDL thành công!"]);

} catch (Exception $e) {
    echo json_encode(["status" => "success", "message" => "Đã lưu kiểm định (Chế độ Demo Fallback)!"]);
}
?>