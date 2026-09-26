<?php
session_start();
require_once '../db.php'; // Chỉnh lại đường dẫn file kết nối DB cho đúng

try {
    // 1. CƠ CHẾ TỰ HẾT HIỆU LỰC GIỮ CHỖ (EXPIRED BOOKINGS)
    $sqlRelease = "
        UPDATE accessible_destinations d
        JOIN bookings b ON d.id = b.destination_id
        SET d.available_slots = d.available_slots + b.quantity,
            b.status = 'cancelled'
        WHERE b.status = 'pending' AND b.expires_at < NOW()";
    $pdo->exec($sqlRelease);

    // 2. NHẬN THAM SỐ TÌM KIẾM TỪ URL
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $offset = ($page - 1) * $limit;
    $keyword = $_GET['keyword'] ?? '';
    $has_wheelchair = $_GET['has_wheelchair'] ?? null;

    // 3. TẠO CÂU TRUY VẤN
    $sql = "SELECT id, title, address, price, has_wheelchair_access, available_slots 
            FROM accessible_destinations 
            WHERE 1=1";
    $params = [];

    if (!empty($keyword)) {
        $sql .= " AND (title LIKE ? OR address LIKE ?)";
        $params[] = "%$keyword%";
        $params[] = "%$keyword%";
    }

    if ($has_wheelchair !== null) {
        $sql .= " AND has_wheelchair_access = ?";
        $params[] = (int)$has_wheelchair;
    }

    // 4. ĐẾM TỔNG SỐ BẢN GHI CHO PHÂN TRANG
    $countSql = "SELECT COUNT(*) FROM (" . $sql . ") AS total_table";
    $stmtCount = $pdo->prepare($countSql);
    $stmtCount->execute($params);
    $totalRecords = $stmtCount->fetchColumn();

    // 5. THỰC THI TRUY VẤN CÓ LIMIT OFFSET
    $sql .= " ORDER BY id DESC LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;

    $stmt = $pdo->prepare($sql);
    foreach ($params as $key => $val) {
        $type = is_int($val) ? PDO::PARAM_INT : PDO::PARAM_STR;
        $stmt->bindValue($key + 1, $val, $type);
    }
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 6. TRẢ KẾT QUẢ VỀ GIAO DIỆN
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'status' => 'success',
        'total_records' => $totalRecords,
        'current_page' => $page,
        'total_pages' => ceil($totalRecords / $limit),
        'data' => $data
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>