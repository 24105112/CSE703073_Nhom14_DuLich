<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=cse703073_nhom14_dulich;charset=utf8mb4", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$cols = $pdo->query("SHOW COLUMNS FROM accessible_destinations")->fetchAll(PDO::FETCH_COLUMN);
$titleCol = in_array('title', $cols) ? 'title' : (in_array('name', $cols) ? 'name' : $cols[1]);

$rows = $pdo->query("SELECT id, $titleCol AS title FROM accessible_destinations ORDER BY id ASC")->fetchAll();

// Bảng giá thực tế theo phân khúc dịch vụ du lịch trợ năng (đơn vị: VNĐ)
$ sightseeingPrices = [180000, 220000, 250000, 290000, 320000, 350000, 390000, 420000, 450000, 480000];
$dayTourPrices      = [550000, 620000, 680000, 750000, 790000, 860000, 920000, 980000, 1150000, 1280000, 1350000, 1490000];
$resortPrices       = [1650000, 1890000, 2150000, 2450000, 2790000, 3150000, 3490000, 3850000, 4250000, 4690000];

$provinces = [
    'Ninh Bình', 'Hà Nội', 'Quảng Ninh', 'Đà Nẵng', 'Quảng Nam (Hội An)', 
    'Lâm Đồng (Đà Lạt)', 'Khánh Hòa (Nha Trang)', 'Thừa Thiên Huế', 
    'Hải Phòng (Cát Bà)', 'Lào Cai (Sa Pa)', 'Bà Rịa - Vũng Tàu', 'Kiên Giang (Phú Quốc)'
];

$upd = $pdo->prepare("
    UPDATE accessible_destinations 
    SET price = ?, address = ?, ramp_slope = ?, door_width = ?, has_wheelchair_access = ?, has_elevator = ?, available_slots = ?
    WHERE id = ?
");

foreach ($rows as $idx => $r) {
    $id = (int)$r['id'];
    $t  = mb_strtolower($r['title'], 'UTF-8');

    // Phân loại giá tự nhiên dựa theo tên địa điểm & mã ID để không bao giờ bị trùng lặp hàng loạt
    if (strpos($t, 'bảo tàng') !== false || strpos($t, 'văn miếu') !== false || strpos($t, 'chùa') !== false || strpos($t, 'đền') !== false || strpos($t, 'hồ') !== false || strpos($t, 'phố cổ') !== false) {
        $basePrice = $sightseeingPrices[($id * 3 + $idx) % count($sightseeingPrices)];
        // Nếu đi kèm gói xe điện + nhân viên hỗ trợ riêng
        if ($id % 3 === 0) $basePrice += 300000;
    } elseif (strpos($t, 'resort') !== false || strpos($t, 'khu nghỉ dưỡng') !== false || strpos($t, 'khách sạn') !== false || strpos($t, 'du thuyền') !== false || strpos($t, 'vinpearl') !== false) {
        $basePrice = $resortPrices[($id * 5 + $idx) % count($resortPrices)];
    } else {
        // Phối trộn đủ 3 phân khúc (Vé tham quan / Tour trong ngày / Nghỉ dưỡng) để ngay trang 1 đã có đủ mức giá
        $tier = $id % 3;
        if ($tier === 0) {
            $basePrice = $sightseeingPrices[($id * 7) % count($sightseeingPrices)];
        } elseif ($tier === 1) {
            $basePrice = $dayTourPrices[($id * 7) % count($dayTourPrices)];
        } else {
            $basePrice = $resortPrices[($id * 7) % count($resortPrices)];
        }
    }

    // Tạo độ lệch lẻ tự nhiên (VD: 680.000đ, 1.250.000đ, 2.490.000đ...) để 9 thẻ trên 1 trang có 9 mức giá khác hẳn nhau
    $variation = (($id * 17) % 9) * 10000;
    $finalPrice = $basePrice + $variation;

    $addr  = $provinces[($id + $idx) % count($provinces)];
    $slope = round(4.2 + (($id * 3) % 45) / 10, 1); // Từ 4.2% đến 8.6%
    $door  = 80 + (($id % 5) * 5);                  // 80cm, 85cm, 90cm, 95cm, 100cm
    $wheel = ($slope <= 8.0) ? 1 : (($id % 4 === 0) ? 0 : 1);
    $elev  = ($id % 5 === 0) ? 0 : 1;
    $slots = ($id === 1) ? 1 : (2 + (($id * 3) % 14)); // Giữ nguyên ID=1 còn 1 chỗ cuối

    $upd->execute([$finalPrice, $addr, $slope, $door, $wheel, $elev, $slots, $id]);
}

echo "=== DA CAP NHAT GIA CA DA DANG CHO TOAN BO " . count($rows) . " DIA DIEM! ===\n";
