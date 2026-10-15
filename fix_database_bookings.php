<?php
$host = 'localhost';$db   = 'cse703073_nhom14_dulich';
$user = 'root';$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass);$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Chọn database
    $pdo->exec("USE `$db`");
    
    // Xóa bảng Booking cũ bị sai cấu trúc (nếu có)
    $pdo->exec("DROP TABLE IF EXISTS `Booking`");
    
    // Tạo bảng bookings chuẩn cho API book.php
    $sql = "CREATE TABLE IF NOT EXISTS `bookings` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `destination_id` int(11) NOT NULL,
        `customer_name` varchar(255) NOT NULL,
        `customer_phone` varchar(20) NOT NULL,
        `customer_email` varchar(255) DEFAULT NULL,
        `booking_date` date NOT NULL,
        `special_requests` text DEFAULT NULL,
        `status` varchar(50) DEFAULT 'pending',
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    
    $pdo->exec($sql);
    echo "=== DA FIX XONG DATABASE! BANG 'bookings' DA SAN SANG! ===\n";
} catch (PDOException $e) {
    echo "Loi: " . $e->getMessage() . "\n";
}
?>
