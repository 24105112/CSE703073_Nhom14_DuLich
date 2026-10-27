<?php
// api/get_analytics.php - Đọc kết quả phân tích Python AI
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

// Đường dẫn ưu tiên file JSON vừa được Python xuất ra
$path1 = __DIR__ . '/analytics_result.json';
$path2 = __DIR__ . '/../{CSE703073_B03_Nhom14_DuLich/api/analytics_result.json';

if (file_exists($path1)) {
    echo file_get_contents($path1);
} elseif (file_exists($path2)) {
    echo file_get_contents($path2);
} else {
    echo json_encode([
        'status' => 'error',
        'error' => 'Chưa tìm thấy file analytics_result.json!'
    ], JSON_UNESCAPED_UNICODE);
}
?>