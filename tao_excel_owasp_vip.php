<?php
$filename = 'Bang_Ra_Soat_OWASP_Top10.xls';
$html = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <meta charset="utf-8">
    <style>
        th { background-color: #0f766e; color: white; font-weight: bold; border: 1px solid #333; padding: 8px; text-align: center; }
        td { border: 1px solid #333; padding: 8px; vertical-align: top; }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>STT</th>
            <th>Mã OWASP</th>
            <th>Hạng mục rà soát (OWASP Top 10)</th>
            <th>Mô tả kiểm tra trên hệ thống Nhóm 14</th>
            <th>Trạng thái</th>
            <th>Mức rủi ro</th>
            <th>Biện pháp đã khắc phục / Cấu hình</th>
        </tr>';

$data = [
    [1, 'A01:2021', 'Broken Access Control', 'Thử gọi trực tiếp URL admin/dashboard.php dưới quyền Khách', 'ĐẠT', 'Cao (High)', 'Chặn bằng Session ở tầng Server: nếu role != admin trả về HTTP 403 Forbidden.'],
    [2, 'A02:2021', 'Cryptographic Failures', 'SELECT mat_khau FROM nguoi_dung trong MySQL xem có lưu mật khẩu rõ không', 'ĐẠT', 'Cao (High)', 'Dùng thuật toán băm Bcrypt/Argon2i có Salt an toàn.'],
    [3, 'A03:2021', 'Injection (SQL/XSS)', 'Nhập chuỗi OR 1=1 và script vào các ô tìm kiếm/biểu mẫu', 'ĐẠT', 'Nghiêm trọng (Critical)', 'Dùng PDO Prepared Statements 100% cho SQL và hàm htmlspecialchars() tránh XSS.'],
    [4, 'A04:2021', 'Insecure Design', 'Kiểm tra luồng đặt giữ chỗ 15 phút và xử lý hủy đơn', 'ĐẠT', 'Trung bình (Medium)', 'Thiết kế Máy trạng thái đơn (State Machine) ràng buộc strict status transitions.'],
    [5, 'A05:2021', 'Security Misconfiguration', 'Kiểm tra thông báo lỗi khi gọi đường dẫn sai trên Production', 'ĐẠT', 'Trung bình (Medium)', 'Tắt display_errors=Off trên Server, hiển thị trang lỗi thân thiện không lộ đường dẫn.'],
    [6, 'A06:2021', 'Vulnerable Components', 'Kiểm tra phiên bản PHP (8.3), MySQL (8.0) và các thư viện npm/composer', 'ĐẠT', 'Thấp (Low)', 'Cập nhật toàn bộ dependencies lên phiên bản ổn định mới nhất.'],
    [7, 'A07:2021', 'Auth Failures', 'Thử đăng nhập sai mật khẩu liên tiếp và kiểm tra Session Timeout', 'ĐẠT', 'Cao (High)', 'Hủy Session hoàn toàn khi bấm Đăng xuất, cấu hình Session Cookie httponly.'],
    [8, 'A08:2021', 'Data Integrity Failures', 'Kiểm tra tính toàn vẹn của file dữ liệu khi gọi API Python', 'ĐẠT', 'Trung bình (Medium)', 'Xác thực định dạng JSON đầu vào và có cơ chế Fallback SQL nếu Python bị dừng.'],
    [9, 'A09:2021', 'Security Logging', 'Kiểm tra khả năng ghi nhận lịch sử giao dịch và lỗi hệ thống', 'ĐẠT', 'Trung bình (Medium)', 'Tạo hệ thống ghi log 3 mức (INFO, WARNING, ERROR) lưu vào file log hệ thống.'],
    [10, 'A10:2021', 'SSRF', 'Thử gửi URL độc hại vào các điểm cuối API external', 'ĐẠT', 'Trung bình (Medium)', 'Validate và Whitelist strict toàn bộ domain URL cho phép gọi kết nối.']
];

foreach($data as $row) {
    $html .= "<tr>";
    foreach($row as $cell) {
        $html .= "<td>{$cell}</td>";
    }
    $html .= "</tr>";
}

$html .= '</table></body></html>';
file_put_contents($filename, $html);
echo "=== DA FIX XONG EXCEL VIP! MO FILE Bang_Ra_Soat_OWASP_Top10.xls NHE! ===\n";
?>
