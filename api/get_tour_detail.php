<?php
// api/get_tour_detail.php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
require_once __DIR__ . '/db.php';

$id = intval($_GET['id'] ?? 1);

try {
    // 1. Lấy thông tin tour
    $stmt = $pdo->prepare("SELECT * FROM san_pham_tour WHERE id = ?");
    $stmt->execute([$id]);
    $tour = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$tour) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'error' => 'Không tìm thấy tour này!'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 2. Lấy lịch khởi hành còn suất
    $stmtLich = $pdo->prepare("SELECT * FROM lich_khoi_hanh WHERE tour_id = ? AND so_cho_kha_dung > 0 ORDER BY ngay_khoi_hanh ASC");
    $stmtLich->execute([$id]);
    $lich = $stmtLich->fetchAll(PDO::FETCH_ASSOC);

    // 3. Lấy tiêu chuẩn trợ năng
    $stmtTN = $pdo->prepare("SELECT t.*, tn.chi_tiet_kiem_dinh FROM tieu_chuan_tro_nang t JOIN tour_tro_nang tn ON t.id = tn.tro_nang_id WHERE tn.tour_id = ?");
    $stmtTN->execute([$id]);
    $troNang = $stmtTN->fetchAll(PDO::FETCH_ASSOC);

    // 4. Lấy danh sách bình luận thực tế
    $stmtReviews = $pdo->prepare("SELECT r.*, u.ho_ten FROM danh_gia_tro_nang r JOIN nguoi_dung u ON r.nguoi_dung_id = u.id WHERE r.tour_id = ? ORDER BY r.tao_luc DESC");
    $stmtReviews->execute([$id]);
    $reviews = $stmtReviews->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'tour' => $tour,
        'lich' => $lich,
        'tro_nang' => $troNang,
        'reviews' => $reviews
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'error' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
?>