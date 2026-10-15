<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') { http_response_code(200); exit(); }
require_once 'db.php';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 6;
$offset = ($page - 1) * $limit;
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$hasWheelchair = isset($_GET['has_wheelchair']) ? (int)$_GET['has_wheelchair'] : 0;
try {
    $where = ["1=1"]; $params = [];
    if ($keyword !== '') { $where[] = "(title LIKE ? OR address LIKE ?)"; $params[] = "%$keyword%"; $params[] = "%$keyword%"; }
    if ($hasWheelchair === 1) { $where[] = "has_wheelchair_access = 1"; }
    $whereSql = implode(" AND ", $where);
    
    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM accessible_destinations WHERE $whereSql");
    $countStmt->execute($params);
    $totalItems = $countStmt->fetchColumn();
    $totalPages = ceil($totalItems / $limit) ?: 1;
    
    $sql = "SELECT id, title, address, price, available_slots, has_wheelchair_access, has_elevator, has_audio_guide FROM accessible_destinations WHERE $whereSql ORDER BY id DESC LIMIT $limit OFFSET $offset";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['status' => 'success', 'page' => $page, 'limit' => $limit, 'total_items' => (int)$totalItems, 'total_pages' => (int)$totalPages, 'data' => $items], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) { 
    http_response_code(500); 
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()], JSON_UNESCAPED_UNICODE); 
}