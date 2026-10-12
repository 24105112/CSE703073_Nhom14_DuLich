<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$input = json_decode(file_get_contents('php://input'), true);
$destinationId = isset($input['destination_id']) ? (int)$input['destination_id'] : 1;
$quantity      = isset($input['quantity']) ? max(1, (int)$input['quantity']) : 1;
$bookingDate   = $input['booking_date'] ?? date('Y-m-d');
$specialNote   = $input['special_note'] ?? '';
$userId        = $_SESSION['user_id'] ?? ($input['user_id'] ?? 1);

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=cse703073_nhom14_dulich;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // 1. BẮT ĐẦU GIAO DỊCH (TRANSACTION)
    $pdo->beginTransaction();

    // 2. ĐỌC VÀ KHÓA HÀNG ĐỘC QUYỀN (SELECT ... FOR UPDATE)
    // Mọi phiên khác cùng đặt địa điểm này sẽ phải xếp hàng chờ đến khi COMMIT hoàn tất
    $stmt = $pdo->prepare("SELECT id, title, available_slots FROM accessible_destinations WHERE id = ? FOR UPDATE");
    $stmt->execute([$destinationId]);
    $destination = $stmt->fetch();

    if (!$destination) {
        $pdo->rollBack();
        http_response_code(404);
        echo json_encode(['status' => 'error', 'error' => 'Địa điểm không tồn tại'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 3. KIỂM TRA TỒN KHẢ DỤNG
    if ((int)$destination['available_slots'] < $quantity) {
        $pdo->rollBack();
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'error' => 'Hết chỗ hoặc số lượng còn lại không đủ! (Đã bị khách khác đặt trước)',
            'remaining_slots' => (int)$destination['available_slots']
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 4. TRỪ TỒN KHẢ DỤNG TRONG CSDL
    $updateStmt = $pdo->prepare("UPDATE accessible_destinations SET available_slots = available_slots - ? WHERE id = ?");
    $updateStmt->execute([$quantity, $destinationId]);

    // 5. TẠO PHIẾU GIỮ CHỖ CÓ THỜI HẠN 15 PHÚT (900 GIÂY)
    $expiresAt = date('Y-m-d H:i:s', time() + 900);
    $bookingStmt = $pdo->prepare("INSERT INTO bookings (user_id, destination_id, quantity, booking_date, special_note, status, expires_at) VALUES (?, ?, ?, ?, ?, 'pending', ?)");
    $bookingStmt->execute([$userId, $destinationId, $quantity, $bookingDate, $specialNote, $expiresAt]);
    $bookingId = (int)$pdo->lastInsertId();

    // 6. HOÀN TẤT GIAO DỊCH & GIẢI PHÓNG KHÓA FOR UPDATE
    $pdo->commit();

    echo json_encode([
        'status' => 'success',
        'message' => 'Đặt giữ chỗ thành công! Đơn được giữ trong 15 phút.',
        'booking_id' => $bookingId,
        'destination_title' => $destination['title'],
        'remaining_slots' => (int)$destination['available_slots'] - $quantity,
        'expires_at' => $expiresAt
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['status' => 'error', 'error' => 'Lỗi hệ thống: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}

