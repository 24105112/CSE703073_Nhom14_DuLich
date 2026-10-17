<?php
require_once 'db.php';
header('Content-Type: application/json; charset=UTF-8');

try {
    $sql = "SELECT * FROM accessible_destinations WHERE 1=1";
    $params = [];

    // Lọc theo từ khóa (Tên/Địa điểm)
    if (!empty($_GET['q'])) {
        $sql .= " AND (title LIKE :q OR address LIKE :q)";
        $params[':q'] = '%' . trim($_GET['q']) . '%';
    }

    // Lọc theo tiện ích (Checkbox)
    if (isset($_GET['wheelchair']) && $_GET['wheelchair'] === 'true') {
        $sql .= " AND has_wheelchair_access = 1";
    }
    if (isset($_GET['elevator']) && $_GET['elevator'] === 'true') {
        $sql .= " AND (description LIKE '%thang máy%' OR description LIKE '%xe điện%')";
    }

    // Sắp xếp (Server Sort)
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
    if ($sort === 'price_asc') {
        $sql .= " ORDER BY price ASC";
    } elseif ($sort === 'price_desc') {
        $sql .= " ORDER BY price DESC";
    } elseif ($sort === 'rating') {
        $sql .= " ORDER BY rating DESC";
    } else {
        $sql .= " ORDER BY id DESC"; // Mặc định mới nhất
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $results = $stmt->fetchAll();

    echo json_encode(["status" => "success", "data" => $results]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}