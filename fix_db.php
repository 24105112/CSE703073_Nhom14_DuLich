<?php
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=cse703073_nhom14_dulich;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    // Đảm bảo bảng users tồn tại
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY)");
    
    // Bổ sung tất cả các cột nếu bảng cũ bị thiếu
    $cols = $pdo->query("SHOW COLUMNS FROM users")->fetchAll(PDO::FETCH_COLUMN);
    if (!in_array('username', $cols)) $pdo->exec("ALTER TABLE users ADD COLUMN username VARCHAR(50) UNIQUE");
    if (!in_array('password_hash', $cols)) $pdo->exec("ALTER TABLE users ADD COLUMN password_hash VARCHAR(255)");
    if (!in_array('role', $cols)) $pdo->exec("ALTER TABLE users ADD COLUMN role VARCHAR(20) DEFAULT 'user'");
    if (!in_array('full_name', $cols)) $pdo->exec("ALTER TABLE users ADD COLUMN full_name VARCHAR(100)");
    if (!in_array('phone', $cols)) $pdo->exec("ALTER TABLE users ADD COLUMN phone VARCHAR(20)");
    if (!in_array('email', $cols)) $pdo->exec("ALTER TABLE users ADD COLUMN email VARCHAR(100)");
    if (!in_array('mobility_profile', $cols)) $pdo->exec("ALTER TABLE users ADD COLUMN mobility_profile VARCHAR(255)");
    
    // Bơm sẵn 2 tài khoản mẫu (admin/123456 và user/123456) để Giảng viên test Đăng nhập nhanh
    $hash = password_hash('123456', PASSWORD_DEFAULT);
    $pdo->exec("INSERT IGNORE INTO users (username, password_hash, role, full_name) VALUES ('admin', '$hash', 'admin', 'Quản trị viên')");
    $pdo->exec("INSERT IGNORE INTO users (username, password_hash, role, full_name) VALUES ('user', '$hash', 'user', 'Thành viên AccessTravel')");

    echo "=== DA FIX LOI DATABASE USERS VA TAO TAI KHOAN MAU! ===\n";
} catch (Exception $e) {
    echo "Loi: " . $e->getMessage();
}
?>
