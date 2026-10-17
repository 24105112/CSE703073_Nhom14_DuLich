<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=cse703073_nhom14_dulich;charset=utf8mb4", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// 1. Xóa dòng bị id = 0 (nếu có) và bật AUTO_INCREMENT cho cột id
$pdo->exec("DELETE FROM accessible_destinations WHERE id = 0");
try {
    $pdo->exec("ALTER TABLE accessible_destinations MODIFY COLUMN id INT NOT NULL AUTO_INCREMENT");
} catch (Exception $e) {}

$cols = $pdo->query("SHOW COLUMNS FROM accessible_destinations")->fetchAll(PDO::FETCH_COLUMN);
$titleCol = in_array('title', $cols) ? 'title' : (in_array('name', $cols) ? 'name' : $cols[1]);

// 2. Lấy danh sách dòng mẫu hiện có và chèn thêm bằng vòng lặp kèm ID rõ ràng
$sampleRows = $pdo->query("SELECT $titleCol AS t, price FROM accessible_destinations LIMIT 50")->fetchAll(PDO::FETCH_ASSOC);
$maxId = (int)$pdo->query("SELECT COALESCE(MAX(id), 105) FROM accessible_destinations")->fetchColumn();
$count = (int)$pdo->query("SELECT COUNT(*) FROM accessible_destinations")->fetchColumn();

$ins = $pdo->prepare("INSERT INTO accessible_destinations (id, $titleCol, address, price, available_slots, has_wheelchair_access, has_elevator, has_accessible_toilet, ramp_slope, door_width) VALUES (?, ?, ?, ?, ?, 1, 1, 1, ?, ?)");

$provinces = ['Hà Nội', 'Quảng Ninh', 'Hải Phòng', 'Đà Nẵng', 'Ninh Bình', 'Quảng Nam', 'Lâm Đồng', 'Khánh Hòa'];
$idx = 0;

while ($count < 305) {
    $maxId++;
    $base = $sampleRows[$idx % count($sampleRows)];
    $newTitle = $base['t'] . " - Cơ sở Trợ năng " . $maxId;
    $addr = $provinces[$maxId % count($provinces)];
    $price = round((450000 + (($maxId * 70000) % 1200000)), -4);
    $slots = 3 + ($maxId % 12);
    $slope = round(5.0 + (($maxId % 4) * 0.8), 1);
    $door = 80 + (($maxId % 3) * 5);

    $ins->execute([$maxId, $newTitle, $addr, $price, $slots, $slope, $door]);
    $count++;
    $idx++;
}

// 3. Đặt địa điểm ID = 1 về đúng 1 chỗ trống để test tranh chấp M2
$pdo->exec("UPDATE accessible_destinations SET available_slots = 1, address = 'Ninh Bình', has_wheelchair_access = 1, has_elevator = 1, ramp_slope = 5.5 WHERE id = 1");

echo "=== THANH CONG 100%: TONG SO BAN GHI = $count ===\n";
