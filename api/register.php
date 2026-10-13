<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$input = json_decode(file_get_contents('php://input'), true);
$fullName = trim($input['full_name'] ?? '');
$username = trim($input['username'] ?? '');
$password = trim($input['password'] ?? '');
$phone = trim($input['phone'] ?? '');
$email = trim($input['email'] ?? '');
$mobility = trim($input['mobility_profile'] ?? 'Người cao tuổi');

if ($fullName === '' || $username === '' || $password === '') {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'error' => 'Vui lòng điền đầy đủ Họ tên, Tên đăng nhập và Mật khẩu!'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=cse703073_nhom14_dulich;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // Check trùng username
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        http_response_code(409);
        echo json_encode(['status' => 'error', 'error' => 'Tên đăng nhập này đã có người sử dụng!'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Mã hóa mật khẩu & Lưu tất cả thông tin vào MySQL
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $ins = $pdo->prepare("INSERT INTO users (username, password_hash, role, full_name, phone, email, mobility_profile) VALUES (?, ?, 'user', ?, ?, ?, ?)");
    $ins->execute([$username, $hash, $fullName, $phone, $email, $mobility]);

    $newId = (int)$pdo->lastInsertId();
    $_SESSION['user_id'] = $newId;
    $_SESSION['username'] = $username;
    $_SESSION['role'] = 'user';
    $_SESSION['full_name'] = $fullName;

    echo json_encode([
        'status' => 'success',
        'user' => [
            'id' => $newId,
            'username' => $username,
            'full_name' => $fullName,
            'role' => 'user',
            'mobility_profile' => $mobility
        ]
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'error' => 'Lỗi máy chủ MySQL: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
