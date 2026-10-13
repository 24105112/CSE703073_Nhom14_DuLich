<?php
error_reporting(0); // Silenciar advertencias
date_default_timezone_set('Asia/Ho_Chi_Minh'); // Zona horaria de Vietnam
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=cse703073_nhom14_dulich;charset=utf8mb4", "root", "", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $input = json_decode(file_get_contents('php://input'), true);
    $destId = (int)($input['destination_id'] ?? 0);
    $qty = (int)($input['quantity'] ?? 1);

    $pdo->beginTransaction();
    
    $stmt = $pdo->prepare("SELECT price, available_slots FROM accessible_destinations WHERE id = ? FOR UPDATE");
    $stmt->execute([$destId]);
    $dest = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$dest || $dest['available_slots'] < $qty) {
        $pdo->rollBack(); 
        @ob_clean();
        echo json_encode(['status' => 'error', 'error' => 'Hết chỗ trống theo thời gian thực!'], JSON_UNESCAPED_UNICODE); 
        exit;
    }

    $pdo->prepare("UPDATE accessible_destinations SET available_slots = available_slots - ? WHERE id = ?")->execute([$qty, $destId]);

    $totalPrice = $qty * (float)$dest['price'];
    $expiresAt = date('Y-m-d H:i:s', time() + 15 * 60);
    $note = $input['special_note'] ?? '';

    $ins = $pdo->prepare("INSERT INTO bookings (destination_id, quantity, total_price, status, special_note, expires_at) VALUES (?, ?, ?, 'pending', ?, ?)");
    $ins->execute([$destId, $qty, $totalPrice, $note, $expiresAt]);
    $bookingId = $pdo->lastInsertId();

    $pdo->commit();
    @ob_clean();
    echo json_encode(['status' => 'success', 'booking_id' => $bookingId, 'expires_at' => $expiresAt]);

} catch(Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) $pdo->rollBack();
    @ob_clean(); 
    http_response_code(500); 
    echo json_encode(['status' => 'error', 'error' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
