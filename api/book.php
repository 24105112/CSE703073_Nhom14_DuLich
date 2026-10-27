<?php
// api/book.php - Xử lý đặt chỗ và chống tranh chấp đồng thời (Mốc M2)
session_start();
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
require_once __DIR__ . '/db.php';

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $tour_id = intval($input['tour_id'] ?? 0);
    $lich_id = intval($input['lich_id'] ?? 0);
    $so_luong = intval($input['so_luong'] ?? 1);
    $user_id = intval($input['user_id'] ?? ($_SESSION['user_id'] ?? 0));

    if ($tour_id <= 0 || $lich_id <= 0 || $so_luong <= 0) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'error' => 'Thông tin đặt tour không hợp lệ!'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Nếu chưa đăng nhập, gán tạm User ID = 1 để quá trình test mượt mà
    if ($user_id <= 0) {
        $user_id = 1;
    }

    // 1. BẮT ĐẦU TRANSACTION
    $pdo->beginTransaction();

    // 2. KHÓA HÀNG BẰNG FOR UPDATE TRÊN MYSQL
    $stmtLich = $pdo->prepare("SELECT id, ngay_khoi_hanh, so_cho_kha_dung FROM lich_khoi_hanh WHERE id = ? FOR UPDATE");
    $stmtLich->execute([$lich_id]);
    $lich = $stmtLich->fetch(PDO::FETCH_ASSOC);

    if (!$lich) {
        $pdo->rollBack();
        http_response_code(404);
        echo json_encode(['status' => 'error', 'error' => 'Không tìm thấy lịch khởi hành đã chọn!'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 3. KIỂM TRA TỒN KHO KHẢ DỤNG
    if ($lich['so_cho_kha_dung'] < $so_luong) {
        $pdo->rollBack();
        http_response_code(409); // Conflict
        echo json_encode([
            'status' => 'error',
            'error' => 'Rất tiếc! Số suất khả dụng còn lại (' . $lich['so_cho_kha_dung'] . ' suất) không đủ đáp ứng yêu cầu của bạn.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 4. LẤY GIÁ TIỀN TỪ BẢNG san_pham_tour (KHÔNG DÙNG accessible_destinations)
    $stmtTour = $pdo->prepare("SELECT ten_tour, gia_tien FROM san_pham_tour WHERE id = ?");
    $stmtTour->execute([$tour_id]);
    $tour = $stmtTour->fetch(PDO::FETCH_ASSOC);

    if (!$tour) {
        $pdo->rollBack();
        http_response_code(404);
        echo json_encode(['status' => 'error', 'error' => 'Không tìm thấy thông tin tour!'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $tong_tien = floatval($tour['gia_tien']) * $so_luong;

    // 5. TRỪ SUẤT TRONG KHO
    $stmtUpdate = $pdo->prepare("UPDATE lich_khoi_hanh SET so_cho_kha_dung = so_cho_kha_dung - ? WHERE id = ?");
    $stmtUpdate->execute([$so_luong, $lich_id]);

    // 6. TẠO MÃ ĐƠN HÀNG VÀO BẢNG don_dat_cho
    $ma_don = 'AT' . date('YmdHis') . rand(100, 999);
    $thoi_han = date('Y-m-d H:i:s', strtotime('+15 minutes'));

    $stmtDon = $pdo->prepare("INSERT INTO don_dat_cho (ma_don, nguoi_dung_id, lich_id, so_luong_ve, tong_tien, trang_thai, thoi_han_giu_cho) VALUES (?, ?, ?, ?, ?, 'cho_thanh_toan', ?)");
    $stmtDon->execute([$ma_don, $user_id, $lich_id, $so_luong, $tong_tien, $thoi_han]);

    // 7. HOÀN TẤT TRANSACTION
    $pdo->commit();

    echo json_encode([
        'status' => 'success',
        'message' => 'Giữ chỗ thành công! Đơn hàng được bảo lưu trong 15 phút.',
        'order' => [
            'ma_don' => $ma_don,
            'tour' => $tour['ten_tour'],
            'ngay_di' => $lich['ngay_khoi_hanh'],
            'so_ve' => $so_luong,
            'tong_tien' => number_format($tong_tien, 0, ',', '.') . ' VND',
            'thoi_han' => $thoi_han
        ]
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['status' => 'error', 'error' => 'Lỗi máy chủ CSDL: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
?>