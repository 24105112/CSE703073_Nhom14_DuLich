<?php
// api/get_tours.php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
require_once __DIR__ . '/db.php';

try {
    $keyword = trim($_GET['keyword'] ?? '');
    
    $sql = "SELECT t.*, 
            COALESCE(SUM(l.so_cho_kha_dung), 0) AS tong_cho_con,
            COALESCE(AVG(r.so_sao), 5.0) AS danh_gia_sao,
            COUNT(r.id) AS so_luot_danh_gia
            FROM san_pham_tour t
            LEFT JOIN lich_khoi_hanh l ON t.id = l.tour_id
            LEFT JOIN danh_gia_tro_nang r ON t.id = r.tour_id
            WHERE t.trang_thai = 'active'";
    
    $params = [];
    if (!empty($keyword)) {
        $sql .= " AND (t.ten_tour LIKE ? OR t.dia_diem LIKE ?)";
        $params[] = "%$keyword%";
        $params[] = "%$keyword%";
    }

    $sql .= " GROUP BY t.id ORDER BY t.id ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'data' => $tours], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'error' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
?>