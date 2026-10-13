<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=cse703073_nhom14_dulich;charset=utf8mb4", "root", "", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
    $input = json_decode(file_get_contents('php://input'), true);$bookingId = isset($input['booking_id']) ? (int)$input['booking_id'] : 0;
    $action =$input['action'] ?? 'pay'; // pay hoặc cancel

    if (!$bookingId) { @ob_clean(); http_response_code(400); echo json_encode(['status' => 'error', 'message' => 'Thiếu thông tin mã đặt chỗ']); exit; }

    $pdo->beginTransaction();
    $stmt =$pdo->prepare("SELECT id, destination_id, quantity, status FROM bookings WHERE id = ? FOR UPDATE");
    $stmt->execute([$bookingId]);
    $booking =$stmt->fetch();

    if (!$booking) {$pdo->rollBack(); @ob_clean(); http_response_code(404); echo json_encode(['status' => 'error', 'message' => 'Đơn đặt chỗ không tồn tại']); exit; }
    if ($booking['status'] === 'paid' || $booking['status'] === 'cancelled') {$pdo->rollBack(); @ob_clean(); http_response_code(400); echo json_encode(['status' => 'error', 'message' => 'Đơn hàng này đã được xử lý ('.$booking['status'].')!']); exit;
    }

    if ($action === 'cancel') {
        $pdo->prepare("UPDATE accessible_destinations SET available_slots = available_slots + ? WHERE id = ?")->execute([$booking['quantity'], $booking['destination_id']]);$pdo->prepare("UPDATE bookings SET status = 'cancelled' WHERE id = ?")->execute([$bookingId]);$pdo->commit();
        @ob_clean(); echo json_encode(['status' => 'success', 'message' => 'Đã HỦY thanh toán. Số suất hỗ trợ đã được hoàn lại kho.']); exit;
    }

    $pdo->prepare("UPDATE bookings SET status = 'paid' WHERE id = ?")->execute([$bookingId]);$pdo->commit();
    @ob_clean(); echo json_encode(['status' => 'success', 'message' => 'Thanh toán Sandbox (MoMo/VNPay) thành công!']);
} catch(Exception $e) {
    if (isset($pdo) && $pdo->inTransaction())$pdo->rollBack();
    @ob_clean(); http_response_code(500); echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}