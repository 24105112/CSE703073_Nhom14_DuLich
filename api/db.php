<?php
// api/db.php - Cấu hình bảo mật Buổi 9
ini_set('display_errors', 0); // TẮT HIỂN THỊ LỖI
ini_set('log_errors', 1);
error_reporting(E_ALL);

$host = getenv('DB_HOST') ?: 'localhost';
$dbname = getenv('DB_NAME') ?: 'cse703073_nhom14_dulich';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException $e) {
    error_log("[ERROR] Database Connection Failed: " . $e->getMessage()); // LƯU VÀO LOG
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Đã xảy ra lỗi kết nối hệ thống."]);
    exit();
}
?>