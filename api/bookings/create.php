<?php
session_start();
require_once '../../db.php'; // Chỉnh lại đường dẫn file kết nối DB cho đúng

header('Content-Type: application/json; charset=utf-8');
$input = json_decode(file_get_contents('php://input'), true);

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Vui lòng đăng nhập để đặt chỗ']);
    exit;
}

$userId = $_SESSION['user_id'];
$destinationId = $input['destination_id'] ?? 0;
$quantity = (int)($input['quantity'] ?? 1);

try {
    // 1. BẮT ĐẦU GIAO DỊCH (TRANSACTION)
    $pdo->beginTransaction();

    // 2. ĐỌC VÀ KHÓA HÀNG (FOR UPDATE) để chặn người khác tranh mua
    $stmt = $pdo->prepare("SELECT available_slots FROM accessible_destinations WHERE id = ? FOR UPDATE");
    $stmt->execute([$destinationId]);
    $destination = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$destination) {
        $pdo->rollBack();
        http_response_code(404);
        echo json_encode(['error' => 'Địa điểm không tồn tại']);
        exit;
    }

    // 3. KIỂM TRA TỒN KHẢ DỤNG
    if ($destination['available_slots'] < $quantity) {
        $pdo->rollBack();
        http_response_code(400);
        echo json_encode(['error' => 'Hết chỗ hoặc số lượng còn lại không đủ']);
        exit;
    }

    // 4. TRỪ TỒN KHẢ DỤNG
    $updateStmt = $pdo->prepare("UPDATE accessible_destinations SET available_slots = available_slots - ? WHERE id = ?");
    $updateStmt->execute([$quantity, $destinationId]);

    // 5. TẠO PHIẾU GIỮ CHỖ CÓ THỜI HẠN (15 PHÚT)
    $expiresAt = date('Y-m-d H:i:s', strtotime('+15 minutes'));
    $bookingStmt = $pdo->prepare("INSERT INTO bookings (user_id, destination_id, quantity, status, expires_at) VALUES (?, ?, ?, 'pending', ?)");
    $bookingStmt->execute([$userId, $destinationId, $quantity, $expiresAt]);
    $bookingId = $pdo->lastInsertId();

    // 6. HOÀN TẤT GIAO DỊCH
    $pdo->commit();

    echo json_encode([
        'status' => 'success',
        'message' => 'Đặt giữ chỗ thành công',
        'booking_id' => $bookingId,
        'expires_at' => $expiresAt
    ]);
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['error' => 'Lỗi hệ thống: ' . $e->getMessage()]);
}
?>