<?php
header('Content-Type: application/json; charset=utf-8');
$pdo = new PDO("mysql:host=127.0.0.1;dbname=cse703073_nhom14_dulich;charset=utf8mb4", "root", "");
$destId = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$pdo->exec("UPDATE bookings SET status = 'cancelled' WHERE destination_id = $destId AND status = 'pending'");
$pdo->exec("UPDATE accessible_destinations SET available_slots = 1 WHERE id = $destId");
echo json_encode(['status' => 'success', 'message' => "Đã khôi phục địa điểm #$destId về trạng thái Còn 1 chỗ trống (available_slots = 1) để sẵn sàng test Race Condition!"], JSON_UNESCAPED_UNICODE);
