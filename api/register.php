<?php
// api/register.php
session_start();
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $fullName = trim($input['ho_ten'] ?? '');
    $email    = trim($input['email'] ?? '');
    $password = trim($input['mat_khau'] ?? '');

    if ($fullName === '' || $email === '' || $password === '') {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'error' => 'Vui lòng điền đầy đủ họ tên, email và mật khẩu!'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    require_once __DIR__ . '/db.php';

    // 1. Kiểm tra email đã tồn tại trong bảng nguoi_dung chưa
    $stmtCheck = $pdo->prepare("SELECT id FROM nguoi_dung WHERE email = ? LIMIT 1");
    $stmtCheck->execute([$email]);
    if ($stmtCheck->fetch()) {
        http_response_code(409);
        echo json_encode(['status' => 'error', 'error' => 'Email này đã được đăng ký tài khoản!'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 2. Băm mật khẩu bằng Bcrypt có muối (Chuẩn Mốc M1 Buổi 5)
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // 3. Chèn vào CSDL bảng nguoi_dung với vai trò mặc định là khach_hang
    $stmtInsert = $pdo->prepare("INSERT INTO nguoi_dung (ho_ten, email, mat_khau, vai_tro) VALUES (?, ?, ?, 'khach_hang')");
    $stmtInsert->execute([$fullName, $email, $passwordHash]);

    echo json_encode([
        'status' => 'success',
        'message' => 'Đăng ký tài khoản thành công! Bạn có thể đăng nhập ngay.'
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'error' => 'Lỗi máy chủ CSDL: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
?>