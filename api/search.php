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

    // 1. Đảm bảo bảng bookings luôn tồn tại để không gây lỗi truy vấn
    $pdo->exec("CREATE TABLE IF NOT EXISTS bookings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL DEFAULT 1,
        destination_id INT NOT NULL,
        quantity INT NOT NULL DEFAULT 1,
        booking_date DATE DEFAULT NULL,
        special_note TEXT DEFAULT NULL,
        status VARCHAR(20) NOT NULL DEFAULT 'pending',
        expires_at DATETIME NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 2. Tự động giải phóng các đơn giữ chỗ quá hạn 15 phút (bọc try-catch an toàn)
    try {
        $pdo->exec("UPDATE accessible_destinations d
                    JOIN bookings b ON d.id = b.destination_id
                    SET d.available_slots = d.available_slots + b.quantity,
                        b.status = 'cancelled'
                    WHERE b.status = 'pending' AND b.expires_at < NOW()");
    } catch (Exception $ignore) {}

    // 3. Nhận tham số phân trang & bộ lọc từ giao diện
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 9;
    $offset = ($page - 1) * $limit;
    $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
    $has_wheelchair = isset($_GET['has_wheelchair']) && $_GET['has_wheelchair'] !== '' ? (int)$_GET['has_wheelchair'] : null;

    // 4. Lấy danh sách các cột thực tế đang có trong bảng accessible_destinations
    $colsStmt = $pdo->query("SHOW COLUMNS FROM accessible_destinations");
    $columns = $colsStmt->fetchAll(PDO::FETCH_COLUMN);

    $titleCol = in_array('title', $columns) ? 'title' : (in_array('name', $columns) ? 'name' : $columns[1]);
    $addrCol  = in_array('address', $columns) ? 'address' : (in_array('location', $columns) ? 'location' : $titleCol);
    $wheelCol = in_array('has_wheelchair_access', $columns) ? 'has_wheelchair_access' : null;

    $where = "WHERE 1=1";
    $params = [];

    if ($keyword !== '') {
        $where .= " AND ($titleCol LIKE ? OR $addrCol LIKE ?)";
        $params[] = "%$keyword%";
        $params[] = "%$keyword%";
    }
    if ($has_wheelchair === 1 && $wheelCol !== null) {
        $where .= " AND $wheelCol = 1";
    }

    // 5. Đếm tổng số bản ghi
    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM accessible_destinations $where");
    $countStmt->execute($params);
    $totalRecords = (int)$countStmt->fetchColumn();

    // 6. Truy vấn dữ liệu phân trang ở tầng Server
    $sql = "SELECT * FROM accessible_destinations $where ORDER BY id ASC LIMIT $limit OFFSET $offset";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll();

    // Chuẩn hóa tên trường trả về cho Frontend
    $data = [];
    foreach ($rows as $r) {
        $data[] = [
            'id' => $r['id'] ?? 1,
            'title' => $r['title'] ?? ($r['name'] ?? 'Điểm đến Du lịch Tiếp cận'),
            'address' => $r['address'] ?? ($r['location'] ?? 'Việt Nam'),
            'price' => $r['price'] ?? ($r['price_per_person'] ?? 850000),
            'has_wheelchair_access' => isset($r['has_wheelchair_access']) ? (int)$r['has_wheelchair_access'] : 1,
            'available_slots' => $r['available_slots'] ?? ($r['capacity'] ?? 15),
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
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
