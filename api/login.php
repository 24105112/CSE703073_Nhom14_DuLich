<?php
session_start();
error_reporting(0); // Tắt hiển thị cảnh báo PHP rác
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $username = trim($input['username'] ?? '');
    $password = trim($input['password'] ?? '');

    if ($username === '' || $password === '') {
        @ob_clean();
        http_response_code(400);
        echo json_encode(['status' => 'error', 'error' => 'Vui lòng nhập tài khoản và mật khẩu!'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $pdo = new PDO("mysql:host=127.0.0.1;dbname=cse703073_nhom14_dulich;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // Tìm user theo username
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'] ?? 'user';
        $_SESSION['full_name'] = $user['full_name'] ?? $user['username'];

        @ob_clean(); // Xóa rác BOM ẩn
        echo json_encode([
            'status' => 'success',
            'user' => [
                'id' => $user['id'],
                'username' => $user['username'],
                'full_name' => $user['full_name'] ?? $user['username'],
                'role' => $user['role'] ?? 'user',
                'mobility_profile' => $user['mobility_profile'] ?? 'Người cao tuổi'
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
