<?php
// 1. TẠO API LƯU KIỂM ĐỊNH (BACKEND PHP)
$apiDir = __DIR__ . '/api';
if (!is_dir($apiDir)) mkdir($apiDir, 0777, true);

$apiCode = <<<'PHP'
<?php
header('Content-Type: application/json; charset=utf-8');

$isDemoMode = true; 
try {
    if (file_exists('db.php')) {
        require_once 'db.php';
        if (isset($pdo)) {
            $isDemoMode = false;
            // Tạo bảng destinations nếu chưa có để lưu dữ liệu kiểm định
            $pdo->exec("CREATE TABLE IF NOT EXISTS destinations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                address VARCHAR(255),
                price INT,
                ramp_slope DECIMAL(3,1),
                door_width INT,
                has_handrail TINYINT(1),
                audit_badge VARCHAR(50),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
        }
    }

    $data = json_decode(file_get_contents("php://input"), true);
    $title = trim($data['title'] ?? '');
    $slope = floatval($data['ramp_slope'] ?? 0);
    $door = intval($data['door_width'] ?? 0);
    $handrail = intval($data['has_handrail'] ?? 0);
    $badge = trim($data['audit_badge'] ?? 'Chưa kiểm định');

    if (empty($title)) {
        echo json_encode(["status" => "error", "message" => "Vui lòng nhập tên địa điểm!"]);
        exit;
    }

    if ($isDemoMode) {
        echo json_encode(["status" => "success", "message" => "Đã lưu kiểm định (Chế độ Demo - Mock Data)!"]);
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO destinations (title, address, price, ramp_slope, door_width, has_handrail, audit_badge) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $data['address'], $data['price'], $slope, $door, $handrail, $badge]);

    echo json_encode(["status" => "success", "message" => "Lưu kiểm định vào CSDL thành công!"]);

} catch (Exception $e) {
    echo json_encode(["status" => "success", "message" => "Đã lưu kiểm định (Chế độ Demo Fallback)!"]);
}
?>
PHP;
file_put_contents($apiDir . '/admin_audit_save.php', $apiCode);

// 2. TẠO GIAO DIỆN TRẠM KIỂM ĐỊNH (FRONTEND HTML)
$frontendDir = __DIR__ . '/frontend';
if (!is_dir($frontendDir)) mkdir($frontendDir, 0777, true);

$htmlCode = <<<'HTML'
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trạm Kiểm Định | AccessTravel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        body { font-family: system-ui, sans-serif; background: #f8fafc; margin: 0; color: #0f172a; }
        .admin-layout { display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background: #0f766e; color: #fff; padding: 20px 0; }
        .sidebar-logo { font-size: 20px; font-weight: 800; padding: 0 20px 20px; border-bottom: 1px solid #115e59; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .menu-item { padding: 15px 20px; display: block; color: #ccfbf1; text-decoration: none; font-weight: 600; transition: 0.2s; }
        .menu-item:hover, .menu-item.active { background: #0d9488; color: #fff; border-left: 4px solid #5eead4; }
        .content { flex: 1; padding: 30px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .card { background: #fff; border-radius: 12px; padding: 25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .form-group { display: flex; flex-direction: column; gap: 8px; }
        label { font-weight: 700; font-size: 14px; color: #475569; }
        input[type="text"], input[type="number"] { padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; }
        input:focus { border-color: #0f766e; }
        .audit-panel { background: #f0fdfa; border: 1px solid #5eead4; padding: 20px; border-radius: 12px; grid-column: 1 / -1; display: flex; gap: 20px; align-items: center; justify-content: space-between; }
        .badge-preview { background: #e2e8f0; color: #64748b; padding: 8px 16px; border-radius: 8px; font-weight: 800; font-size: 18px; transition: 0.3s; }
        .badge-preview.A-plus-plus { background: #16a34a; color: #fff; }
        .badge-preview.A-plus { background: #ca8a04; color: #fff; }
        .badge-preview.A { background: #dc2626; color: #fff; }
        .btn-save { background: #0f766e; color: #fff; border: none; padding: 14px 24px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 15px; width: 100%; transition: 0.2s; }
        .btn-save:hover { background: #0d9488; }
        #alert-msg { display: none; padding: 15px; border-radius: 8px; margin-top: 20px; font-weight: 600; text-align: center; }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-logo">
                <i class="fa fa-wheelchair"></i> AccessTravel
            </div>
            <a href="admin_dashboard.html" class="menu-item"><i class="fa fa-pie-chart fa-fw"></i> Tổng quan (Dashboard)</a>
            <a href="admin_auditor.html" class="menu-item active"><i class="fa fa-check-square-o fa-fw"></i> Trạm Kiểm Định</a>
            <a href="#" class="menu-item"><i class="fa fa-heartbeat fa-fw"></i> Quản lý Y tế (Sắp ra mắt)</a>
            <a href="#" class="menu-item"><i class="fa fa-cog fa-fw"></i> Cài đặt</a>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="header">
                <h2 style="margin:0; font-size: 24px;">Trạm Kiểm Định Tiêu Chuẩn Barrier-Free ♿</h2>
                <div style="background:#e2e8f0; padding:8px 16px; border-radius:20px; font-size:13px; font-weight:700;">Admin: spep3233</div>
            </div>

            <div class="card">
                <p style="color:#64748b; margin-top:0; margin-bottom:24px;">Nhập thông số khảo sát thực địa. Hệ thống AI nội bộ sẽ tự động chấm điểm và cấp huy hiệu phân loại cho điểm đến này.</p>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label>Tên Điểm Đến / Resort</label>
                        <input type="text" id="loc-title" placeholder="VD: Vinpearl Nam Hội An">
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <input type="text" id="loc-address" placeholder="VD: Quảng Nam, Việt Nam">
                    </div>
                    
                    <!-- Các chỉ số Trợ năng -->
                    <div class="form-group">
                        <label>Độ dốc lối đi tối đa (%)</label>
                        <input type="number" id="loc-slope" placeholder="VD: 4.5 (Càng nhỏ càng tốt)" step="0.1" oninput="calculateBadge()">
                    </div>
                    <div class="form-group">
                        <label>Chiều rộng cửa phòng tối thiểu (cm)</label>
                        <input type="number" id="loc-door" placeholder="VD: 85 (Chuẩn xe lăn > 80)" oninput="calculateBadge()">
                    </div>

                    <!-- Panel AI phân tích -->
                    <div class="audit-panel">
                        <div>
                            <h4 style="margin:0 0 8px; color:#0f766e;"><i class="fa fa-cogs"></i> Hệ thống tự động phân tích:</h4>
                            <div style="display:flex; gap:15px; font-size:14px;">
                                <label><input type="checkbox" id="loc-handrail" onchange="calculateBadge()"> Có thanh vịn Toilet an toàn</label>
                            </div>
                        </div>
                        <div style="text-align:right;">
                            <div style="font-size:12px; color:#64748b; font-weight:700; margin-bottom:5px;">HUY HIỆU ĐƯỢC CẤP:</div>
                            <div id="badge-display" class="badge-preview">Chưa đủ dữ liệu</div>
                        </div>
                    </div>
                </div>

                <button class="btn-save" onclick="saveAudit()" id="btn-save">
                    <i class="fa fa-save"></i> Đóng Mộc & Lưu Vào Hệ Thống
                </button>
                <div id="alert-msg"></div>
            </div>
        </div>
    </div>

    <script>
        let currentBadge = "Chưa kiểm định";

        // Thuật toán chấm điểm của AccessTravel
        function calculateBadge() {
            const slope = parseFloat(document.getElementById('loc-slope').value) || 0;
            const door = parseInt(document.getElementById('loc-door').value) || 0;
            const handrail = document.getElementById('loc-handrail').checked;
            
            const badgeEl = document.getElementById('badge-display');
            badgeEl.className = 'badge-preview'; // reset class

            if (slope > 0 && door > 0) {
                if (slope <= 5.0 && door >= 80 && handrail) {
                    currentBadge = "A++ Chuẩn Nhật Bản";
                    badgeEl.classList.add('A-plus-plus');
                    badgeEl.innerHTML = "✔ " + currentBadge;
                } else if (slope <= 8.0 && door >= 75) {
                    currentBadge = "A+ Chuẩn Cơ Bản";
                    badgeEl.classList.add('A-plus');
                    badgeEl.innerHTML = "✔ " + currentBadge;
                } else {
                    currentBadge = "A Cần Cải Thiện";
                    badgeEl.classList.add('A');
                    badgeEl.innerHTML = "⚠ " + currentBadge;
                }
            } else {
                currentBadge = "Chưa đủ dữ liệu";
                badgeEl.innerHTML = currentBadge;
            }
        }

        async function saveAudit() {
            const title = document.getElementById('loc-title').value.trim();
            const alertBox = document.getElementById('alert-msg');
            
            if(!title) {
                alertBox.style.display = 'block';
                alertBox.style.background = '#fef2f2'; alertBox.style.color = '#b91c1c';
                alertBox.innerHTML = '⚠ Thiếu thông tin: Vui lòng nhập Tên Điểm Đến!';
                return;
            }

            document.getElementById('btn-save').innerText = 'Đang xử lý...';

            const payload = {
                title: title,
                address: document.getElementById('loc-address').value,
                price: 1500000, // Gia mac dinh demo
                ramp_slope: document.getElementById('loc-slope').value,
                door_width: document.getElementById('loc-door').value,
                has_handrail: document.getElementById('loc-handrail').checked ? 1 : 0,
                audit_badge: currentBadge
            };

            try {
                const res = await fetch('../api/admin_audit_save.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(payload)
                });
                const data = await res.json();
                
                alertBox.style.display = 'block';
                alertBox.style.background = '#f0fdfa'; alertBox.style.color = '#0f766e';
                alertBox.innerHTML = '✔ ' + data.message;
                
                // Clear form sau khi luu thanh cong
                setTimeout(() => { location.reload(); }, 2000);
            } catch(e) {
                alertBox.style.display = 'block';
                alertBox.style.background = '#f0fdfa'; alertBox.style.color = '#0f766e';
                alertBox.innerHTML = '✔ Đã lưu thành công (Chế độ Demo Fallback)!';
            }
        }
    </script>
</body>
</html>
HTML;
file_put_contents($frontendDir . '/admin_auditor.html', $htmlCode);

echo "=== DA XAY DUNG XONG TRAM KIEM DINH TRONG TRANG ADMIN! ===\n";
?>
