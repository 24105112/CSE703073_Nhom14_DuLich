<?php
// Tự động tạo thư mục API
@mkdir(__DIR__ . '/api/bookings', 0777, true);
@mkdir(__DIR__ . '/api/admin', 0777, true);
@mkdir(__DIR__ . '/api/destinations', 0777, true);

// 1. CẬP NHẬT CSDL: Tạo bảng `bookings` cho V3 lưu đơn đặt chỗ
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=cse703073_nhom14_dulich;charset=utf8mb4", "root", "", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $pdo->exec("CREATE TABLE IF NOT EXISTS bookings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NULL,
        destination_id INT NOT NULL,
        quantity INT DEFAULT 1,
        total_price DECIMAL(15,2) DEFAULT 0,
        status VARCHAR(20) DEFAULT 'pending',
        special_note TEXT,
        expires_at DATETIME,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Ghi đè api/book.php để tương thích bảng bookings mới
    $bookPhp = <<<'PHP'
<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=cse703073_nhom14_dulich;charset=utf8mb4", "root", "", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $input = json_decode(file_get_contents('php://input'), true);$destId = (int)($input['destination_id'] ?? 0);$qty = (int)($input['quantity'] ?? 1);$pdo->beginTransaction();
    $stmt =$pdo->prepare("SELECT price, available_slots FROM accessible_destinations WHERE id = ? FOR UPDATE");
    $stmt->execute([$destId]);
    $dest =$stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$dest \vert{}\vert{}$dest['available_slots'] < $qty) {$pdo->rollBack(); @ob_clean();
        echo json_encode(['status' => 'error', 'error' => 'Hết chỗ trống theo thời gian thực!']); exit;
    }
    
    $pdo->prepare("UPDATE accessible_destinations SET available_slots = available_slots - ? WHERE id = ?")->execute([$qty,$destId]);
    
    $totalPrice =$qty * (float)$dest['price'];$expiresAt = date('Y-m-d H:i:s', time() + 15 * 60);
    $note = $input['special_note'] ?? '';
    
    $ins =$pdo->prepare("INSERT INTO bookings (destination_id, quantity, total_price, status, special_note, expires_at) VALUES (?, ?, ?, 'pending', ?, ?)");
    $ins->execute([$destId, $qty,$totalPrice, $note, $expiresAt]);$bookingId = $pdo->lastInsertId();$pdo->commit();
    @ob_clean();
    echo json_encode(['status' => 'success', 'booking_id' => $bookingId, 'expires_at' =>$expiresAt]);
} catch(Exception $e) {
    if ($pdo->inTransaction())$pdo->rollBack();
    @ob_clean(); http_response_code(500); echo json_encode(['status' => 'error', 'error' => $e->getMessage()]);
}
PHP;
    file_put_contents(__DIR__ . '/api/book.php', $bookPhp);

} catch(Exception $e) { echo "Lỗi DB: " . $e->getMessage(); }

// 2. NHIỆM VỤ V3 (TRUNG ANH): API THANH TOÁN SANDBOX (api/bookings/pay.php)
$payPhp = <<<'PHP'
<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=cse703073_nhom14_dulich;charset=utf8mb4", "root", "", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
    $input = json_decode(file_get_contents('php://input'), true);$bookingId = isset($input['booking_id']) ? (int)$input['booking_id'] : 0;
    $action =$input['action'] ?? 'pay'; // pay hoặc cancel

    if (!$bookingId) { @ob_clean(); http_response_code(400); echo json_encode(['status' => 'error', 'message' => 'Thiếu thông tin mã đặt chỗ']); exit; }

    $pdo->beginTransaction();
    $stmt =$pdo->prepare("SELECT id, destination_id, quantity, status FROM bookings WHERE id = ? FOR UPDATE");
    $stmt->execute([$bookingId]);
    $booking =$stmt->fetch();

    if (!$booking) {$pdo->rollBack(); @ob_clean(); http_response_code(404); echo json_encode(['status' => 'error', 'message' => 'Đơn đặt chỗ không tồn tại']); exit; }
    if ($booking['status'] === 'paid' || $booking['status'] === 'cancelled') {$pdo->rollBack(); @ob_clean(); http_response_code(400); echo json_encode(['status' => 'error', 'message' => 'Đơn hàng này đã được xử lý ('.$booking['status'].')!']); exit;
    }

    if ($action === 'cancel') {
        $pdo->prepare("UPDATE accessible_destinations SET available_slots = available_slots + ? WHERE id = ?")->execute([$booking['quantity'], $booking['destination_id']]);$pdo->prepare("UPDATE bookings SET status = 'cancelled' WHERE id = ?")->execute([$bookingId]);$pdo->commit();
        @ob_clean(); echo json_encode(['status' => 'success', 'message' => 'Đã HỦY thanh toán. Số suất hỗ trợ đã được hoàn lại kho.']); exit;
    }

    $pdo->prepare("UPDATE bookings SET status = 'paid' WHERE id = ?")->execute([$bookingId]);$pdo->commit();
    @ob_clean(); echo json_encode(['status' => 'success', 'message' => 'Thanh toán Sandbox (MoMo/VNPay) thành công!']);
} catch(Exception $e) {
    if (isset($pdo) && $pdo->inTransaction())$pdo->rollBack();
    @ob_clean(); http_response_code(500); echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
PHP;
file_put_contents(__DIR__ . '/api/bookings/pay.php', $payPhp);

// 3. NHIỆM VỤ V3 (TRUNG ANH): API DASHBOARD (api/admin/dashboard.php)
$dashPhp = <<<'PHP'
<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=cse703073_nhom14_dulich;charset=utf8mb4", "root", "", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $rev =$pdo->query("SELECT COALESCE(SUM(total_price), 0) FROM bookings WHERE status = 'paid'")->fetchColumn();
    $bk =$pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
    $tours =$pdo->query("SELECT COUNT(*) FROM accessible_destinations")->fetchColumn();
    $slots =$pdo->query("SELECT SUM(available_slots) FROM accessible_destinations")->fetchColumn() ?: 100;
    $occ = round((1 - ($slots / ($tours * 20))) * 100, 1);

    $statusData =$pdo->query("SELECT status, COUNT(*) as count FROM bookings GROUP BY status")->fetchAll(PDO::FETCH_KEY_PAIR);
    $topDest =$pdo->query("SELECT d.title, COUNT(b.id) as total_orders FROM accessible_destinations d LEFT JOIN bookings b ON d.id = b.destination_id GROUP BY d.id ORDER BY total_orders DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

    @ob_clean();
    echo json_encode([
        'status' => 'success',
        'metrics' => ['total_revenue' => (float)$rev, 'total_bookings' => (int)$bk, 'total_tours' => (int)$tours, 'occupancy_rate' =>$occ . '%'],
        'charts' => ['status_distribution' => ['pending' => $statusData['pending'] ?? 0, 'paid' =>$statusData['paid'] ?? 0, 'cancelled' => $statusData['cancelled'] ?? 0], 'top_destinations' =>$topDest]
    ]);
} catch(Exception $e) { @ob_clean(); echo json_encode(['status' => 'error', 'message' =>$e->getMessage()]); }
PHP;
file_put_contents(__DIR__ . '/api/admin/dashboard.php', $dashPhp);

// 4. NHIỆM VỤ V3 (TRUNG ANH): API PYTHON FALLBACK (api/destinations/recommend.php)
$recPhp = <<<'PHP'
<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
$tourId = isset($_GET['tour_id']) ? (int)$_GET['tour_id'] : 1;
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=cse703073_nhom14_dulich;charset=utf8mb4", "root", "", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
    $stmt =$pdo->prepare("SELECT id, title, price, has_wheelchair_access FROM accessible_destinations WHERE id != ? AND has_wheelchair_access = 1 ORDER BY id DESC LIMIT 3");
    $stmt->execute([$tourId]);
    $data =$stmt->fetchAll();
    @ob_clean();
    echo json_encode(['status' => 'success', 'source' => 'sql_fallback', 'message' => 'Python Service is down. Using SQL Fallback.', 'data' => $data]);
} catch (Exception $e) { @ob_clean(); echo json_encode(['status' => 'error']); }
PHP;
file_put_contents(__DIR__ . '/api/destinations/recommend.php', $recPhp);

// 5. NHIỆM VỤ V4 (XUÂN HOÀN): TÍCH HỢP NÚT THANH TOÁN VÀO TRANG frontend/booking.html
$bookingPath = __DIR__ . '/frontend/booking.html';
if (file_exists($bookingPath)) {
    $html = file_get_contents($bookingPath);
    // Bổ sung hàm processPayment và cập nhật StartCountdown để hiển thị nút
    $jsToInject = <<<'JS'
        async function processPayment(bookingId, action) {
            if (!confirm(action === 'pay' ? '💳 Xác nhận thanh toán Sandbox (MoMo/VNPay)?' : '❌ Chắc chắn hủy giữ chỗ?')) return;
            try {
                const res = await fetch('../api/bookings/pay.php', {
                    method: 'POST', headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ booking_id: bookingId, action: action })
                });
                const data = await res.json();
                if(res.ok && data.status === 'success') {
                    alert('🎉 ' + data.message);
                    document.getElementById('countdownBanner').style.display = 'none';
                    checkMatchingServices(); // Tải lại danh sách
                } else alert('Lỗi: ' + data.message);
            } catch(e) { alert('Lỗi kết nối Server thanh toán!'); }
        }
JS;
    if (strpos($html, 'processPayment') === false) {
        $html = str_replace('async function handleBookingSubmit',$jsToInject . "\n        async function handleBookingSubmit", $html);
    }
    
    // Cập nhật banner đếm ngược
    $newBannerHTML = 'banner.innerHTML = `✅ <strong>Đặt lịch thành công! Mã đơn: #${bookingId}</strong> (Đang chờ thanh toán)<br>' .
                     '⏳ Giữ chỗ còn lại: <strong style="color:#b45309; font-size:20px;">${m} phút ${s < 10 ? \'0\' + s : s} giây</strong><br>' .
                     '<div style="margin-top:14px; display:flex; gap:10px;">' .
                     '<button type="button" onclick="processPayment(${bookingId}, \'pay\')" class="btn btn-primary" style="background:#16a34a; border:none; padding:8px 16px; border-radius:8px; font-weight:700;">💳 Thanh toán Sandbox</button>' .
                     '<button type="button" onclick="processPayment(${bookingId}, \'cancel\')" class="btn btn-outline" style="border-color:#dc2626; color:#dc2626; padding:8px 16px; border-radius:8px; font-weight:700;">❌ Hủy đơn</button>' .
                     '</div>`;';
                     
    $html = preg_replace('/banner\.innerHTML = `✅.*?`;/s', $newBannerHTML,$html);
    file_put_contents($bookingPath,$html);
}

// 6. NHIỆM VỤ V4 (XUÂN HOÀN): ADMIN DASHBOARD (frontend/admin_dashboard.html)
$adminHtml = <<<'HTML'
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | AccessTravel M3</title>
    <link rel="stylesheet" href="css/tokens.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background: #f1f5f9; padding: 24px; font-family: system-ui, sans-serif; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .grid-4 { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 24px; }
        .kpi-card { background: #fff; border-radius: 16px; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 16px; }
        .kpi-icon { width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #fff; }
        .kpi-val { font-size: 24px; font-weight: 900; color: #0f172a; margin-bottom: 4px; }
        .kpi-lbl { font-size: 14px; color: #64748b; font-weight: 600; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        .chart-card { background: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .chart-card h3 { font-size: 16px; color: #334155; margin-bottom: 20px; }
        @media (max-width: 768px) { .grid-2 { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="color:#0f766e; font-size:24px; font-weight:900;">📈 Bảng Điều Khiển Quản Trị</h1>
        <a href="index.html" style="color:#334155; text-decoration:none; font-weight:700; background:#fff; padding:10px 20px; border-radius:10px; box-shadow:0 2px 4px rgba(0,0,0,0.05);">🏠 Về Trang Chủ</a>
    </div>

    <div class="grid-4">
        <div class="kpi-card">
            <div class="kpi-icon" style="background:#0ea5e9;">💰</div>
            <div>
                <div class="kpi-lbl">Tổng Doanh Thu</div>
                <div class="kpi-val" id="kpiRevenue">0 đ</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon" style="background:#10b981;">📝</div>
            <div>
                <div class="kpi-lbl">Tổng Đơn Đặt Chỗ</div>
                <div class="kpi-val" id="kpiBookings">0</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon" style="background:#8b5cf6;">🗺️</div>
            <div>
                <div class="kpi-lbl">Tổng Số Tour Trợ Năng</div>
                <div class="kpi-val" id="kpiTours">0</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon" style="background:#f59e0b;">🔥</div>
            <div>
                <div class="kpi-lbl">Tỷ Lệ Lấp Đầy</div>
                <div class="kpi-val" id="kpiOcc">0%</div>
            </div>
        </div>
    </div>

    <div class="grid-2">
        <div class="chart-card">
            <h3>📊 Trạng Thái Thanh Toán Đơn Hàng</h3>
            <div style="height:300px; display:flex; justify-content:center;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
        <div class="chart-card">
            <h3>🏆 Top 5 Điểm Đến Được Yêu Thích Nhất</h3>
            <div style="height:300px;">
                <canvas id="topChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        async function loadDashboard() {
            try {
                const res = await fetch('../api/admin/dashboard.php');
                const data = await res.json();
                
                document.getElementById('kpiRevenue').innerText = Number(data.metrics.total_revenue).toLocaleString('vi-VN') + ' đ';
                document.getElementById('kpiBookings').innerText = data.metrics.total_bookings;
                document.getElementById('kpiTours').innerText = data.metrics.total_tours;
                document.getElementById('kpiOcc').innerText = data.metrics.occupancy_rate;

                new Chart(document.getElementById('statusChart').getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['⏳ Chờ thanh toán', '✅ Đã thanh toán', '❌ Đã hủy'],
                        datasets: [{
                            data: [data.charts.status_distribution.pending, data.charts.status_distribution.paid, data.charts.status_distribution.cancelled],
                            backgroundColor: ['#f59e0b', '#10b981', '#ef4444']
                        }]
                    }
                });

                const topLabels = data.charts.top_destinations.map(d => d.title.substring(0, 15) + '...');
                const topVals = data.charts.top_destinations.map(d => d.total_orders);
                new Chart(document.getElementById('topChart').getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: topLabels,
                        datasets: [{ label: 'Số lượng đơn', data: topVals, backgroundColor: '#0ea5e9', borderRadius: 6 }]
                    },
                    options: { maintainAspectRatio: false }
                });
            } catch (err) { console.error('Lỗi tải Admin Dashboard:', err); }
        }
        loadDashboard();
    </script>
</body>
</html>
HTML;
file_put_contents(__DIR__ . '/frontend/admin_dashboard.html', $adminHtml);
echo "=== DA HOAN THANH NHIEM VU M3 (BUOI 7) CHO V3 VA V4! ===\n";
?>
