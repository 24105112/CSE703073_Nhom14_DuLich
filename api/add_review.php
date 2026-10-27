<?php
// api/add_review.php
session_start();
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
require_once __DIR__ . '/db.php';

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $tour_id = intval($input['tour_id'] ?? 0);
    $user_id = intval($input['user_id'] ?? ($_SESSION['user_id'] ?? 0));
    $so_sao = intval($input['so_sao'] ?? 5);
    $nhan_xet = trim($input['nhan_xet'] ?? '');

    if ($tour_id <= 0 || empty($nhan_xet)) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'error' => 'Vui lòng nhập nội dung đánh giá!'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($user_id <= 0) {
        http_response_code(401);
        echo json_encode(['status' => 'error', 'error' => 'Vui lòng đăng nhập trước khi đánh giá!'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($so_sao < 1 || $so_sao > 5) {
        $so_sao = 5;
    }

    $stmt = $pdo->prepare("INSERT INTO danh_gia_tro_nang (tour_id, nguoi_dung_id, so_sao, nhan_xet, tao_luc) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$tour_id, $user_id, $so_sao, $nhan_xet]);

    echo json_encode([
        'status' => 'success',
        'message' => 'Cảm ơn bạn! Đánh giá đã được đăng thành công.'
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'error' => 'Lỗi máy chủ: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
?>