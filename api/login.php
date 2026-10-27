<?php
// api/login.php
session_start();
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

try {
    $input = json_decode(file_get_contents('php://input'), true);
    // Nhận username hoặc email
    $username = trim($input['username'] ?? $input['email'] ?? '');
    $password = trim($input['password'] ?? $input['mat_khau'] ?? '');

    if ($username === '' || $password === '') {
        @ob_clean();
        http_response_code(400);
        echo json_encode(['status' => 'error', 'error' => 'Vui lòng nhập tài khoản và mật khẩu!'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Kết nối CSDL thông qua db.php hoặc PDO trực tiếp
    require_once __DIR__ . '/db.php';

    // Tìm kiếm trong bảng nguoi_dung theo email
    $stmt = $pdo->prepare("SELECT * FROM nguoi_dung WHERE email = ? LIMIT 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['mat_khau'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['vai_tro'];
        $_SESSION['full_name'] = $user['ho_ten'];

        @ob_clean();
        echo json_encode([
            'status' => 'success',
            'user' => [
                'id' => $user['id'],
                'full_name' => $user['ho_ten'],
                'email' => $user['email'],
                'role' => $user['vai_tro']
            ]
        ], JSON_UNESCAPED_UNICODE);
    } else {
        @ob_clean();
        http_response_code(401);
        echo json_encode(['status' => 'error', 'error' => 'Sai tài khoản hoặc mật khẩu!'], JSON_UNESCAPED_UNICODE);
    }
} catch (Exception $e) {
    @ob_clean();
    http_response_code(500);
    echo json_encode(['status' => 'error', 'error' => 'Lỗi máy chủ CSDL: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
?>