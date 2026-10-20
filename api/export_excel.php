<?php
// Báo cho trình duyệt biết đây là file Excel dạng XLS
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Bao_Cao_AccessTravel_T10.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Tạo cấu trúc bảng HTML giả lập Excel (chiêu thức code cực hay để format Excel bằng PHP thuần)
$html = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
$html .= '<head><meta charset="utf-8"></head><body>';
$html .= '<table border="1" style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 11pt;">';

// Dòng Tiêu đề tổng của báo cáo
$html .= '<tr><th colspan="7" style="font-size: 16pt; padding: 15px; background-color: #f8fafc; color: #0f766e; text-align: center; text-transform: uppercase;">BÁO CÁO THỐNG KÊ ĐƠN ĐẶT CHỖ Y TẾ - ACCESSTRAVEL</th></tr>';

// Dòng Header các cột (Có tô nền xanh, chữ trắng, in đậm)
$html .= '<tr style="background-color: #0f766e; color: #ffffff; font-weight: bold; text-align: center;">';
$html .= '<th style="padding: 12px; width: 100px;">Mã Đơn</th>';
$html .= '<th style="padding: 12px; width: 200px;">Tên Khách Hàng</th>';
$html .= '<th style="padding: 12px; width: 250px;">Điểm Đến</th>';
$html .= '<th style="padding: 12px; width: 150px;">Ngày Khởi Hành</th>';
$html .= '<th style="padding: 12px; width: 150px;">Doanh Thu (VNĐ)</th>';
$html .= '<th style="padding: 12px; width: 150px;">Trạng Thái</th>';
$html .= '<th style="padding: 12px; width: 300px;">Yêu Cầu Y Tế Đặc Biệt</th>';
$html .= '</tr>';

// Dữ liệu
$mockData = [
    ['BK-089', 'Cô Hoàng Thị Lý', 'Du thuyền Trợ Năng 304', '22/10/2026', '4.150.000', 'Đã thanh toán', 'Cần 1 xe lăn, người dìu lên bậc'],
    ['BK-090', 'Gia đình Bác An', 'Khu nghỉ dưỡng Hội An', '25/10/2026', '1.710.000', 'Đã thanh toán', 'Yêu cầu phòng tầng trệt, cao huyết áp'],
    ['BK-091', 'Chú Trần Văn Hùng', 'Chùa Bái Đính - Lối riêng', '26/10/2026', '850.000', 'Chờ thanh toán', 'Cần mượn xe lăn điện'],
    ['BK-092', 'Bác Phạm Thị Mai', 'Vinpearl Resort', '28/10/2026', '2.500.000', 'Đã thanh toán', 'Hỗ trợ y tá đi kèm 24/7']
];

foreach ($mockData as $row) {
    $html .= '<tr>';
    foreach ($row as $index => $cell) {
        // Riêng cột Doanh Thu (index = 4) thì căn lề phải cho chuẩn quy tắc kế toán
        $align = ($index == 4) ? 'right' : 'left';
        $html .= '<td style="padding: 8px; text-align: ' . $align . '; vertical-align: middle;">' . htmlspecialchars($cell) . '</td>';
    }
    $html .= '</tr>';
}

$html .= '</table></body></html>';

// Xuất thẳng file Excel
echo $html;
?>
