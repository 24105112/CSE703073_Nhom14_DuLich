<?php
$frontendDir = __DIR__ . '/frontend';

// 1. TẠO TRANG QUẢN LÝ BẢO TRÌ (ADMIN_MAINTENANCE.HTML)
$htmlCode = <<<'HTML'
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cảnh báo Bảo trì | AccessTravel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        body { font-family: system-ui, sans-serif; background: #f8fafc; margin: 0; color: #0f172a; overflow-x: hidden; }
        .admin-layout { display: flex; min-height: 100vh; width: 100vw; }
        .sidebar { width: 260px; background: #0f766e; color: #fff; padding: 20px 0; flex-shrink: 0; display: flex; flex-direction: column; }
        .sidebar-logo { font-size: 20px; font-weight: 800; padding: 0 20px 20px; border-bottom: 1px solid #115e59; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .menu-item { padding: 15px 20px; display: block; color: #ccfbf1; text-decoration: none; font-weight: 600; transition: 0.2s; }
        .menu-item:hover, .menu-item.active { background: #0d9488; color: #fff; border-left: 4px solid #5eead4; }
        .btn-logout { margin-top: auto; padding: 15px 20px; color: #fca5a5; text-decoration: none; font-weight: 600; display: block; border-top: 1px solid #115e59; transition: 0.2s;} 
        .btn-logout:hover { color: #fff; background: #0f766e; }
        .content { flex: 1; padding: 30px; overflow-y: auto; }
        
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .card { background: #fff; border-radius: 12px; padding: 25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #f1f5f9; color: #475569; font-weight: 700; text-align: left; padding: 14px 16px; font-size: 13px; text-transform: uppercase; }
        td { padding: 16px; border-bottom: 1px solid #e2e8f0; font-size: 14px; vertical-align: middle; }
        
        /* Toggle Switch iOS Style */
        .switch { position: relative; display: inline-block; width: 50px; height: 26px; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .4s; border-radius: 34px; }
        .slider:before { position: absolute; content: ""; height: 20px; width: 20px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; }
        input:checked + .slider { background-color: #ef4444; }
        input:focus + .slider { box-shadow: 0 0 1px #ef4444; }
        input:checked + .slider:before { transform: translateX(24px); }
        
        #toast { visibility: hidden; min-width: 250px; background-color: #333; color: #fff; text-align: center; border-radius: 8px; padding: 16px; position: fixed; z-index: 1; bottom: 30px; right: 30px; font-weight: 600; opacity: 0; transition: opacity 0.3s; }
        #toast.show { visibility: visible; opacity: 1; }
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
            <a href="admin_auditor.html" class="menu-item"><i class="fa fa-check-square-o fa-fw"></i> Trạm Kiểm Định</a>
            <a href="admin_medical.html" class="menu-item"><i class="fa fa-heartbeat fa-fw"></i> Quản lý Y tế & Hỗ trợ</a>
            <a href="admin_maintenance.html" class="menu-item active"><i class="fa fa-exclamation-triangle fa-fw"></i> Cảnh báo Bảo trì</a>
            <a href="index.html" class="btn-logout"><i class="fa fa-sign-out fa-fw"></i> Thoát về Trang chủ</a>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="header">
                <h2 style="margin:0; font-size: 24px; color:#b91c1c;">Cảnh Báo Bảo Trì Khẩn Cấp 🚧</h2>
                <div style="background:#e2e8f0; padding:8px 16px; border-radius:20px; font-size:13px; font-weight:700;">Admin: spep3233</div>
            </div>

            <div class="card">
                <p style="color:#64748b; margin-top:0; margin-bottom:20px;">Kích hoạt công tắc để khóa điểm đến trên trang chủ nếu phát hiện cơ sở vật chất (thang máy, dốc xe lăn) bị hỏng, đảm bảo an toàn tuyệt đối cho khách hàng.</p>
                <table>
                    <thead>
                        <tr>
                            <th>Mã</th>
                            <th>Điểm Đến / Resort</th>
                            <th>Tình trạng sự cố (Ghi chú)</th>
                            <th style="text-align:center;">Trạng thái Khóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>#304</strong></td>
                            <td>Du thuyền Trợ Năng 304 (Phú Quốc)</td>
                            <td><input type="text" placeholder="Nhập ghi chú..." style="padding:8px; border:1px solid #cbd5e1; border-radius:6px; width:90%;" value="Hoạt động bình thường"></td>
                            <td style="text-align:center;">
                                <label class="switch"><input type="checkbox" onchange="toggleAlert(this, 'Du thuyền 304')"><span class="slider"></span></label>
                            </td>
                        </tr>
                        <tr style="background:#fef2f2;">
                            <td><strong>#003</strong></td>
                            <td>Chùa Bái Đính - Lối riêng</td>
                            <td><input type="text" style="padding:8px; border:1px solid #fca5a5; border-radius:6px; width:90%; color:#b91c1c; font-weight:600;" value="Đang sửa chữa dốc xe lăn cổng số 2"></td>
                            <td style="text-align:center;">
                                <label class="switch"><input type="checkbox" checked onchange="toggleAlert(this, 'Chùa Bái Đính')"><span class="slider"></span></label>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>#305</strong></td>
                            <td>Resort Trợ Năng 305 (Huế)</td>
                            <td><input type="text" placeholder="Nhập ghi chú..." style="padding:8px; border:1px solid #cbd5e1; border-radius:6px; width:90%;" value=""></td>
                            <td style="text-align:center;">
                                <label class="switch"><input type="checkbox" onchange="toggleAlert(this, 'Resort 305')"><span class="slider"></span></label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div id="toast">Cập nhật thành công!</div>

    <script>
        function toggleAlert(checkbox, name) {
            const toast = document.getElementById("toast");
            if(checkbox.checked) {
                toast.innerHTML = `<i class="fa fa-lock"></i> Đã KHÓA và hiện cảnh báo: <b>${name}</b>`;
                toast.style.backgroundColor = "#ef4444";
            } else {
                toast.innerHTML = `<i class="fa fa-unlock"></i> Đã MỞ KHÓA điểm đến: <b>${name}</b>`;
                toast.style.backgroundColor = "#10b981";
            }
            toast.className = "show";
            setTimeout(function(){ toast.className = toast.className.replace("show", ""); }, 3000);
        }
    </script>
</body>
</html>
HTML;
file_put_contents($frontendDir . '/admin_maintenance.html',$htmlCode);
echo "=== DA TAO TRANG CANH BAO BAO TRI (admin_maintenance.html) ===\n";

// 2. CHÈN MENU VÀO CÁC TRANG ADMIN CŨ
$adminFiles = ['admin_dashboard.html', 'admin_auditor.html', 'admin_medical.html'];
foreach ($adminFiles as $file) {$path = $frontendDir . '/' .$file;
    if (file_exists($path)) {
        $content = file_get_contents($path);
        if (strpos($content, 'Cảnh báo Bảo trì') === false) {
            $pattern = '/<a href="#" class="menu-item"><i class="fa fa-cog fa-fw"><\/i> Cài đặt<\/a>/is';
            $replacement = '<a href="admin_maintenance.html" class="menu-item"><i class="fa fa-exclamation-triangle fa-fw"></i> Cảnh báo Bảo trì</a>
            <a href="#" class="menu-item"><i class="fa fa-cog fa-fw"></i> Cài đặt</a>';
            $newContent = preg_replace($pattern, $replacement,$content);
            file_put_contents($path,$newContent);
        }
    }
}

// 3. CẤY JS "BẮT SÓNG" BẢO TRÌ VÀO TRANG CHỦ & TÌM KIẾM
$clientFiles = ['index.html', 'search.html'];$watcherJS = <<<'JS'
<script>
// Watcher: Tự động khóa các điểm đến bị Admin đánh dấu bảo trì (Demo: Chùa Bái Đính)
setInterval(() => {
    document.querySelectorAll('article').forEach(art => {
        if(art.innerText.includes('Bái Đính') && !art.classList.contains('locked')) {
            art.classList.add('locked');
            // Làm xám ảnh
            const img = art.querySelector('img');
            if(img) { img.style.filter = 'grayscale(100%)'; img.style.opacity = '0.6'; }
            
            // Đổi huy hiệu còn chỗ thành Đang bảo trì
            const badgeBox = art.querySelector('div[style*="bottom:12px; right:12px;"]');
            if(badgeBox) badgeBox.innerHTML = '<span style="background:#ef4444; color:#fff; padding:4px 10px; border-radius:8px; font-size:12.5px; font-weight:700;"><i class="fa fa-wrench"></i> Đang sửa chữa</span>';
            
            // Khóa nút Đặt chỗ
            const btn = art.querySelector('a[href*="booking.html"]');
            if(btn) btn.outerHTML = '<button style="background:#94a3b8; color:#fff; padding:8px 16px; border-radius:8px; border:none; font-size:14.5px; font-weight:700; cursor:not-allowed;">Tạm ngưng</button>';
            
            // Đổi nhãn xanh xác minh thành nhãn đỏ cảnh báo
            const verifyBadge = art.querySelector('div[style*="top:12px; left:12px;"]');
            if(verifyBadge) {
                verifyBadge.style.background = '#fee2e2'; verifyBadge.style.color = '#991b1b';
                verifyBadge.innerHTML = '⚠ Cảnh báo an toàn';
            }
        }
    });
}, 500);
</script>
JS;

foreach ($clientFiles as $file) {$path = $frontendDir . '/' .$file;
    if (file_exists($path)) {
        $content = file_get_contents($path);
        // Tránh chèn 2 lần
        if (strpos($content, 'Cảnh báo an toàn') === false) {
            $content = str_replace('</body>', $watcherJS . "\n</body>", $content);
            file_put_contents($path,$content);
        }
    }
}
echo "=== DA CAY CHUC NANG KHOA DIEM DEN VAO TRANG CHU & TIM KIEM ===\n";
?>
