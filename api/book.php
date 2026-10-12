<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$input = json_decode(file_get_contents('php://input'), true);
$destinationId = isset($input['destination_id']) ? (int)$input['destination_id'] : 1;
$quantity      = isset($input['quantity']) ? max(1, (int)$input['quantity']) : 1;
$bookingDate   = $input['booking_date'] ?? date('Y-m-d');
$specialNote   = $input['special_note'] ?? '';
$userId        = 1;

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=cse703073_nhom14_dulich;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // 1. Bắt đầu Transaction & Khóa hàng (SELECT ... FOR UPDATE) chống Race Condition
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("SELECT * FROM accessible_destinations WHERE id = ? FOR UPDATE");
    $stmt->execute([$destinationId]);
    $dest = $stmt->fetch();

    if (!$dest) {
        $pdo->rollBack();
        http_response_code(404);
        echo json_encode(['error' => 'Địa điểm không tồn tại'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $available = isset($dest['available_slots']) ? (int)$dest['available_slots'] : 10;
    if ($available < $quantity) {
        $pdo->rollBack();
        http_response_code(400);
        echo json_encode(['error' => 'Hết chỗ hoặc số lượng còn lại không đủ!'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 2. Trừ tồn khả dụng nếu bảng có cột available_slots
    if (array_key_exists('available_slots', $dest)) {
        $up = $pdo->prepare("UPDATE accessible_destinations SET available_slots = available_slots - ? WHERE id = ?");
        $up->execute([$quantity, $destinationId]);
    }

    // 3. Tạo phiếu giữ chỗ 15 phút
    $expiresAt = date('Y-m-d H:i:s', strtotime('+15 minutes'));
    $ins = $pdo->prepare("INSERT INTO bookings (user_id, destination_id, quantity, booking_date, special_note, status, expires_at) VALUES (?, ?, ?, ?, ?, 'pending', ?)");
    $ins->execute([$userId, $destinationId, $quantity, $bookingDate, $specialNote, $expiresAt]);
    $bookingId = $pdo->lastInsertId();

    $pdo->commit();

    echo json_encode([
        'status' => 'success',
        'message' => 'Đặt giữ chỗ thành công',
        'booking_id' => $bookingId,
        'expires_at' => $expiresAt
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['error' => 'Lỗi hệ thống: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
