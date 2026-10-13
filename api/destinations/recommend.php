<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
$tourId = isset($_GET['tour_id']) ? (int)$_GET['tour_id'] : 1;
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=cse703073_nhom14_dulich;charset=utf8mb4", "root", "", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
    $stmt =$pdo->prepare("SELECT id, title, price, has_wheelchair_access FROM accessible_destinations WHERE id != ? AND has_wheelchair_access = 1 ORDER BY id DESC LIMIT 3");
    $stmt->execute([$tourId]);
    $data =$stmt->fetchAll();
    @ob_clean();
    echo json_encode(['status' => 'success', 'source' => 'sql_fallback', 'message' => 'Python Service is down. Using SQL Fallback.', 'data' => $data]);
} catch (Exception $e) { @ob_clean(); echo json_encode(['status' => 'error']); }