<?php
// api/healthz.php - API Kiem tra suc khoe he thong (Buoi 9)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require_once 'db.php';

try {
    // Kiểm tra kết nối CSDL và đếm tổng số tour
    $stmt = $pdo->query("SELECT COUNT(*) FROM accessible_destinations");
    $total = $stmt->fetchColumn();
    
    http_response_code(200);
    echo json_encode([
        "status" => "ok",
        "timestamp" => date("Y-m-d H:i:s"),
        "database" => "connected",
        "total_records" => (int)$total,
        "environment" => "production"
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Database connection error"
    ]);
}
?>
