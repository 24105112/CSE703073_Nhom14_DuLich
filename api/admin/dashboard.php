<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=cse703073_nhom14_dulich;charset=utf8mb4", "root", "", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $rev =$pdo->query("SELECT COALESCE(SUM(total_price), 0) FROM bookings WHERE status = 'paid'")->fetchColumn();
    $bk =$pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
    $tours =$pdo->query("SELECT COUNT(*) FROM accessible_destinations")->fetchColumn();
    $slots =$pdo->query("SELECT SUM(available_slots) FROM accessible_destinations")->fetchColumn() ?: 100;
    $occ = round((1 - ($slots / ($tours * 20))) * 100, 1);

    $statusData =$pdo->query("SELECT status, COUNT(*) as count FROM bookings GROUP BY status")->fetchAll(PDO::FETCH_KEY_PAIR);
    $topDest =$pdo->query("SELECT d.title, COUNT(b.id) as total_orders FROM accessible_destinations d LEFT JOIN bookings b ON d.id = b.destination_id GROUP BY d.id ORDER BY total_orders DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

    @ob_clean();
    echo json_encode([
        'status' => 'success',
        'metrics' => ['total_revenue' => (float)$rev, 'total_bookings' => (int)$bk, 'total_tours' => (int)$tours, 'occupancy_rate' =>$occ . '%'],
        'charts' => ['status_distribution' => ['pending' => $statusData['pending'] ?? 0, 'paid' =>$statusData['paid'] ?? 0, 'cancelled' => $statusData['cancelled'] ?? 0], 'top_destinations' =>$topDest]
    ]);
} catch(Exception $e) { @ob_clean(); echo json_encode(['status' => 'error', 'message' =>$e->getMessage()]); }