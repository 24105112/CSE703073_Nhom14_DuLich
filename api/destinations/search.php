<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$host = '127.0.0.1';
$db   = 'cse703073_nhom14_dulich';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // 1. Tự động hoàn chỗ cho các đơn giữ chỗ quá hạn 15 phút (Expired Bookings)
    try {
        $pdo->exec("UPDATE accessible_destinations d
                    JOIN bookings b ON d.id = b.destination_id
                    SET d.available_slots = d.available_slots + b.quantity,
                        b.status = 'cancelled'
                    WHERE b.status = 'pending' AND b.expires_at < NOW()");
    } catch (Exception $ignore) {}

    // 2. Nhận tham số Lọc, Phân trang & Sắp xếp ở tầng Server (Nghiêm cấm lọc ở trình duyệt)
    $page           = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $limit          = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 9;
    $offset         = ($page - 1) * $limit;
    $keyword        = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
    $has_wheelchair = isset($_GET['has_wheelchair']) && $_GET['has_wheelchair'] !== '' ? (int)$_GET['has_wheelchair'] : null;
    $has_elevator   = isset($_GET['has_elevator']) && $_GET['has_elevator'] !== '' ? (int)$_GET['has_elevator'] : null;
    $max_slope      = isset($_GET['max_slope']) && $_GET['max_slope'] !== '' ? (float)$_GET['max_slope'] : null;
    $sort           = $_GET['sort'] ?? 'id_asc';

    $where = "WHERE 1=1";
    $params = [];

    if ($keyword !== '') {
        $where .= " AND (title LIKE ? OR address LIKE ?)";
        $params[] = "%$keyword%";
        $params[] = "%$keyword%";
    }
    if ($has_wheelchair === 1) {
        $where .= " AND has_wheelchair_access = ?";
        $params[] = 1;
    }
    if ($has_elevator === 1) {
        $where .= " AND has_elevator = ?";
        $params[] = 1;
    }
    if ($max_slope !== null && $max_slope > 0) {
        $where .= " AND ramp_slope <= ?";
        $params[] = $max_slope;
    }

    // Sắp xếp phía máy chủ
    $orderBy = "ORDER BY id ASC";
    if ($sort === 'price_asc')  $orderBy = "ORDER BY price ASC, id ASC";
    if ($sort === 'price_desc') $orderBy = "ORDER BY price DESC, id ASC";
    if ($sort === 'slots_asc')  $orderBy = "ORDER BY available_slots ASC, id ASC";

    // 3. Đếm tổng bản ghi phục vụ phân trang
    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM accessible_destinations $where");
    $countStmt->execute($params);
    $totalRecords = (int)$countStmt->fetchColumn();

    // 4. Truy vấn lấy dữ liệu trang hiện tại
    $sql = "SELECT * FROM accessible_destinations $where $orderBy LIMIT $limit OFFSET $offset";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll();

    $data = [];
    foreach ($rows as $r) {
        $data[] = [
            'id' => (int)$r['id'],
            'title' => $r['title'] ?? 'Điểm đến Du lịch Tiếp cận',
            'address' => $r['address'] ?? 'Việt Nam',
            'price' => (float)($r['price'] ?? 850000),
            'has_wheelchair_access' => isset($r['has_wheelchair_access']) ? (int)$r['has_wheelchair_access'] : 1,
            'has_elevator' => isset($r['has_elevator']) ? (int)$r['has_elevator'] : 1,
            'has_accessible_toilet' => isset($r['has_accessible_toilet']) ? (int)$r['has_accessible_toilet'] : 1,
            'ramp_slope' => isset($r['ramp_slope']) ? (float)$r['ramp_slope'] : 6.0,
            'door_width' => isset($r['door_width']) ? (int)$r['door_width'] : 85,
            'available_slots' => isset($r['available_slots']) ? (int)$r['available_slots'] : 10,
            'description' => $r['description'] ?? ''
        ];
    }

    echo json_encode([
        'status' => 'success',
        'total_records' => $totalRecords,
        'current_page' => $page,
        'total_pages' => max(1, (int)ceil($totalRecords / $limit)),
        'data' => $data
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
