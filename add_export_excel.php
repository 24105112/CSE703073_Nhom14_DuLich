<?php
// 1. TẠO API XUẤT FILE EXCEL BẰNG PHP
$apiDir = __DIR__ . '/api';
if (!is_dir($apiDir)) mkdir($apiDir, 0777, true);

$exportCode = <<<'PHP'
<?php
// Thiết lập Header để trình duyệt hiểu đây là file tải về
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Bao_Cao_AccessTravel_T10.csv');

// Thêm ký tự BOM (Byte Order Mark) để mở bằng MS Excel không bị lỗi font tiếng Việt
echo "\xEF\xBB\xBF";

// Mở luồng ghi file
$output = fopen('php://output', 'w');

// Ghi dòng Tiêu đề cột
fputcsv($output, ['Mã Đơn', 'Tên Khách Hàng', 'Điểm Đến', 'Ngày Khởi Hành', 'Doanh Thu (VNĐ)', 'Trạng Thái', 'Yêu Cầu Y Tế Đặc Biệt']);

// Dữ liệu mẫu (Nếu có MySQL thật thì dùng vòng lặp fetch từ DB ra đây)
$mockData = [
    ['BK-089', 'Cô Hoàng Thị Lý', 'Du thuyền Trợ Năng 304', '22/10/2026', '4150000', 'Đã thanh toán', 'Cần 1 xe lăn, người dìu lên bậc'],
    ['BK-090', 'Gia đình Bác An', 'Khu nghỉ dưỡng Hội An', '25/10/2026', '1710000', 'Đã thanh toán', 'Yêu cầu phòng tầng trệt, cao huyết áp'],
    ['BK-091', 'Chú Trần Văn Hùng', 'Chùa Bái Đính - Lối riêng', '26/10/2026', '850000', 'Chờ thanh toán', 'Cần mượn xe lăn điện'],
    ['BK-092', 'Bác Phạm Thị Mai', 'Vinpearl Resort', '28/10/2026', '2500000', 'Đã thanh toán', 'Hỗ trợ y tá đi kèm 24/7']
];

// Ghi từng dòng dữ liệu vào file
foreach ($mockData as $row) {
    fputcsv($output, $row);
}

fclose($output);
exit;
?>
PHP;
file_put_contents($apiDir . '/export_excel.php', $exportCode);
echo "=== DA TAO API XUAT FILE EXCEL (export_excel.php) ===\n";

// 2. CHÈN NÚT "XUẤT EXCEL" VÀO TRANG TỔNG QUAN (ADMIN_DASHBOARD.HTML)
$dashboardFile = __DIR__ . '/frontend/admin_dashboard.html';
if (file_exists($dashboardFile)) {
    $html = file_get_contents($dashboardFile);
    
    // Kiểm tra xem đã có nút chưa
    if (strpos($html, 'Xuất Báo Cáo Excel') === false) {
        $btnHtml = <<<'HTML'
                <div style="display:flex; align-items:center; gap:15px;">
                    <div style="background:#e2e8f0; padding:8px 16px; border-radius:20px; font-size:13px; font-weight:700;">Admin: spep3233</div>
                    <a href="../api/export_excel.php" style="background:#10b981; color:#fff; padding:9px 18px; border-radius:8px; text-decoration:none; font-weight:700; font-size:14px; display:inline-flex; align-items:center; gap:8px; transition:0.2s; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">
                        <i class="fa fa-file-excel-o"></i> Xuất Báo Cáo Excel
                    </a>
                </div>
HTML;
        
        // Thay thế cục hiển thị Admin cũ bằng cục mới có thêm nút Excel
        $pattern = '/<div style="background:#e2e8f0; padding:8px 16px; border-radius:20px; font-size:13px; font-weight:700;">Admin: spep3233<\/div>/is';
        $html = preg_replace($pattern, $btnHtml, $html);
        
        file_put_contents($dashboardFile, $html);
        echo "=== DA CHEN NUT XUAT EXCEL VAO TRANG TONG QUAN ===\n";
    } else {
        echo "=== NUT XUAT EXCEL DA TON TAI! ===\n";
    }
}
?>
