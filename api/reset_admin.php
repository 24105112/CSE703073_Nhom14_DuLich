<?php
// Kết nối database (sửa lại tên db cho khớp với máy của nhóm)
$conn = new mysqli('localhost', 'root', '', 'CSE703073_Nhom14_DuLich');

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Tạo tài khoản admin mới với mật khẩu: admin123
$username = 'admin_moi';
$password = md5('admin123'); // Mã hóa MD5

$sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'admin') 
        ON DUPLICATE KEY UPDATE password='$password'";

if ($conn->query(queryString: $sql) === TRUE) {
    echo "<h3>Đã cấp lại quyền Admin thành công!</h3>";
    echo "Tài khoản: <b>admin_moi</b><br>";
    echo "Mật khẩu: <b>admin123</b><br>";
    echo "<a href='frontend/login.html'>Quay lại trang đăng nhập</a>";
} else {
    echo "Lỗi: " . $conn->error;
}
$conn->close();
?>