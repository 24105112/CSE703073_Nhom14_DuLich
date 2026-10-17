<?php
$filename = 'Bang_Ra_Soat_OWASP_Top10.csv';
$fp = fopen($filename, 'w');

// Thêm ký tự BOM để Excel đọc tiếng Việt không bị lỗi font
fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

$data = [
    ['STT', 'Mã OWASP', 'Hạng mục rà soát (OWASP Top 10)', 'Mô tả kiểm tra trên hệ thống Nhóm 14', 'Trạng thái', 'Mức rủi ro', 'Biện pháp đã khắc phục / Cấu hình'],
    [1, 'A01:2021', 'Broken Access Control (Kiểm soát truy cập bị vỡ)', 'Thử gọi trực tiếp URL admin/dashboard.php dưới quyền Khách', 'ĐẠT', 'Cao (High)', 'Chặn bằng Session ở tầng Server: nếu role != admin trả về HTTP 403 Forbidden.'],
    [2, 'A02:2021', 'Cryptographic Failures (Lỗi mã hóa dữ liệu)', 'SELECT mat_khau FROM nguoi_dung trong MySQL xem có lưu mật khẩu rõ không', 'ĐẠT', 'Cao (High)', 'Dùng thuật toán băm Bcrypt/Argon2i có Salt an toàn.'],
    [3, 'A03:2021', 'Injection (Lỗi tiêm nhiễm SQL/XSS)', 'Nhập chuỗi OR 1=1 và script vào các ô tìm kiếm/biểu mẫu', 'ĐẠT', 'Nghiêm trọng (Critical)', 'Dùng PDO Prepared Statements 100% cho SQL và hàm htmlspecialchars() tránh XSS.'],
    [4, 'A04:2021', 'Insecure Design (Thiết kế không an toàn)', 'Kiểm tra luồng đặt giữ chỗ 15 phút và xử lý hủy đơn', 'ĐẠT', 'Trung bình (Medium)', 'Thiết kế Máy trạng thái đơn (State Machine) ràng buộc strict status transitions.'],
    [5, 'A05:2021', 'Security Misconfiguration (Cấu hình bảo mật sai)', 'Kiểm tra thông báo lỗi khi gọi đường dẫn sai trên Production', 'ĐẠT', 'Trung bình (Medium)', 'Tắt display_errors=Off trên Server, hiển thị trang lỗi thân thiện không lộ đường dẫn.'],
    [6, 'A06:2021', 'Vulnerable and Outdated Components (Thành phần lỗi thời)', 'Kiểm tra phiên bản PHP (8.3), MySQL (8.0) và các thư viện npm/composer', 'ĐẠT', 'Thấp (Low)', 'Cập nhật toàn bộ dependencies lên phiên bản ổn định mới nhất.'],
    [7, 'A07:2021', 'Identification and Authentication Failures (Lỗi xác thực)', 'Thử đăng nhập sai mật khẩu liên tiếp và kiểm tra Session Timeout', 'ĐẠT', 'Cao (High)', 'Hủy Session hoàn toàn khi bấm Đăng xuất, cấu hình Session Cookie httponly.'],
    [8, 'A08:2021', 'Software and Data Integrity Failures (Lỗi toàn vẹn dữ liệu)', 'Kiểm tra tính toàn vẹn của file dữ liệu khi gọi API Python', 'ĐẠT', 'Trung bình (Medium)', 'Xác thực định dạng JSON đầu vào và có cơ chế Fallback SQL nếu Python bị dừng.'],
    [9, 'A09:2021', 'Security Logging and Monitoring Failures (Lỗi ghi log/giám sát)', 'Kiểm tra khả năng ghi nhận lịch sử giao dịch và lỗi hệ thống', 'ĐẠT', 'Trung bình (Medium)', 'Tạo hệ thống ghi log 3 mức (INFO, WARNING, ERROR) lưu vào file log hệ thống.'],
    [10, 'A10:2021', 'Server-Side Request Forgery (SSRF)', 'Thử gửi URL độc hại vào các điểm cuối API external', 'ĐẠT', 'Trung bình (Medium)', 'Validate và Whitelist strict toàn bộ domain URL cho phép gọi kết nối.']
];

foreach ($data as $row) {
    fputcsv($fp, $row);
}
fclose($fp);
echo "=== DA TAO XONG FILE EXCEL OWASP TOP 10! KTRA TRONG FOLDER NHE CHIEN THAN! ===\n";
?>
