<?php
// api/search_tours.php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
require_once __DIR__ . '/db.php';

try {
    $keyword = trim($_GET['keyword'] ?? '');
    $accessibility = trim($_GET['accessibility'] ?? 'all');
    $price_range = trim($_GET['price_range'] ?? 'all');
    $category_id = intval($_GET['category_id'] ?? 0);

    $sql = "SELECT t.*, 
            COALESCE(SUM(l.so_cho_kha_dung), 0) AS tong_cho_con,
            COALESCE(AVG(r.so_sao), 5.0) AS danh_gia_sao,
            COUNT(r.id) AS so_luot_danh_gia
            FROM san_pham_tour t
            LEFT JOIN lich_khoi_hanh l ON t.id = l.tour_id
            LEFT JOIN danh_gia_tro_nang r ON t.id = r.tour_id
            LEFT JOIN tour_tro_nang ttn ON t.id = ttn.tour_id
            WHERE t.trang_thai = 'active'";

    $params = [];

    // Lọc theo từ khóa (tên tour hoặc địa điểm)
    if (!empty($keyword)) {
        $sql .= " AND (t.ten_tour LIKE ? OR t.dia_diem LIKE ?)";
        $params[] = "%$keyword%";
        $params[] = "%$keyword%";
    }

    // Lọc theo danh mục (du thuyền, resort, sinh thái)
    if ($category_id > 0) {
        $sql .= " AND t.danh_muc_id = ?";
        $params[] = $category_id;
    }

    // Lọc theo ngân sách giá
    if ($price_range === 'low') {
        $sql .= " AND t.gia_tien < 1000000";
    } elseif ($price_range === 'mid') {
        $sql .= " AND t.gia_tien BETWEEN 1000000 AND 3000000";
    } elseif ($price_range === 'high') {
        $sql .= " AND t.gia_tien > 3000000";
    }

    // Lọc theo tiêu chuẩn trợ năng kiểm định
    if ($accessibility === 'elevator') {
        $sql .= " AND ttn.tro_nang_id = 2"; // Thang máy buồng rộng
    } elseif ($accessibility === 'slope') {
        $sql .= " AND ttn.tro_nang_id = 1"; // Độ dốc an toàn < 8%
    } elseif ($accessibility === 'wc') {
        $sql .= " AND ttn.tro_nang_id = 3"; // WC tay vịn
    }

    $sql .= " GROUP BY t.id ORDER BY t.id ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'data' => $tours, 'total' => count($tours)], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'error' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
?>