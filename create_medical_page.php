<?php
$frontendDir = __DIR__ . '/frontend';

// 1. TẠO TRANG QUẢN LÝ Y TẾ (ADMIN_MEDICAL.HTML)
$htmlCode = <<<'HTML'
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Y tế | AccessTravel Admin</title>
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
        
        /* Table Styles */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #f1f5f9; color: #475569; font-weight: 700; text-align: left; padding: 14px 16px; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 16px; border-bottom: 1px solid #e2e8f0; font-size: 14px; vertical-align: middle; }
        tr:hover { background: #f8fafc; }
        
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-block; }
        .badge-warning { background: #fef3c7; color: #d97706; }
        .badge-success { background: #dcfce7; color: #166534; }
        
        .req-tag { background: #e0e7ff; color: #4f46e5; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px; margin-right: 5px; margin-bottom: 5px;}
        
        .btn-action { background: #0ea5e9; color: #fff; border: none; padding: 8px 14px; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 13px; transition: 0.2s; }
        .btn-action:hover { background: #0284c7; }
        .btn-done { background: #e2e8f0; color: #64748b; cursor: not-allowed; }

        /* Modal Styles */
        .modal { position: fixed; top:0; left:0; width:100%; height:100%; background:rgba(15,23,42,0.6); display:none; align-items:center; justify-content:center; z-index:9999; }
        .modal.show { display:flex; }
        .modal-content { background:#fff; width:450px; border-radius:12px; padding:25px; box-shadow:0 20px 25px -5px rgba(0,0,0,0.1); }
        .modal select { width:100%; padding:10px; margin:15px 0; border:1px solid #cbd5e1; border-radius:8px; font-size:14px; }
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
            <a href="admin_medical.html" class="menu-item active"><i class="fa fa-heartbeat fa-fw"></i> Quản lý Y tế & Hỗ trợ</a>
            <a href="#" class="menu-item"><i class="fa fa-cog fa-fw"></i> Cài đặt</a>
            <a href="index.html" class="btn-logout"><i class="fa fa-sign-out fa-fw"></i> Thoát về Trang chủ</a>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="header">
                <h2 style="margin:0; font-size: 24px;">Phân Bổ Nhân Sự Y Tế & Xe Lăn 🩺</h2>
                <div style="background:#e2e8f0; padding:8px 16px; border-radius:20px; font-size:13px; font-weight:700;">Admin: spep3233</div>
            </div>

            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Mã Đơn</th>
                            <th>Khách hàng / Điểm đến</th>
                            <th>Yêu cầu Hỗ trợ (Thể trạng)</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="booking-list">
                        <tr>
                            <td><strong>#BK-089</strong></td>
                            <td>
                                <div style="font-weight:700;">Cô Hoàng Thị Lý</div>
                                <div style="font-size:12px; color:#64748b; margin-top:4px;">Tới: Du thuyền Trợ Năng 304</div>
                            </td>
                            <td>
                                <span class="req-tag"><i class="fa fa-wheelchair"></i> Cần 1 xe lăn đẩy tay</span>
                                <span class="req-tag" style="background:#fce7f3; color:#be185d;"><i class="fa fa-user-md"></i> Cần người dìu lên bậc</span>
                            </td>
                            <td><span class="badge badge-warning" id="status-089">Chờ phân bổ</span></td>
                            <td><button class="btn-action" id="btn-089" onclick="openModal('BK-089')"><i class="fa fa-user-plus"></i> Điều phối</button></td>
                        </tr>
                        <tr>
                            <td><strong>#BK-090</strong></td>
                            <td>
                                <div style="font-weight:700;">Gia đình Bác An</div>
                                <div style="font-size:12px; color:#64748b; margin-top:4px;">Tới: Khu nghỉ dưỡng Hội An</div>
                            </td>
                            <td>
                                <span class="req-tag" style="background:#dcfce7; color:#166534;"><i class="fa fa-bed"></i> Yêu cầu phòng tầng trệt</span>
                                <span class="req-tag"><i class="fa fa-medkit"></i> Lưu ý: Tiền sử cao huyết áp</span>
                            </td>
                            <td><span class="badge badge-success">Đã duyệt y tế</span></td>
                            <td><button class="btn-action btn-done" disabled><i class="fa fa-check"></i> Hoàn tất</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Phân Bổ -->
    <div class="modal" id="assignModal">
        <div class="modal-content">
            <h3 style="margin-top:0; color:#0f172a;">Điều phối Hỗ trợ cho đơn <span id="modal-order-id" style="color:#0ea5e9;"></span></h3>
            <p style="font-size:14px; color:#64748b;">Chọn nhân viên hoặc trang thiết bị y tế phù hợp với thể trạng của khách hàng.</p>
            
            <label style="font-weight:700; font-size:13px; display:block; margin-top:15px;">Chọn Nhân viên Hỗ trợ:</label>
            <select id="staffSelect">
                <option value="">-- Click để chọn nhân sự --</option>
                <option value="y-ta-lan">Y tá Nguyễn Thị Lan (Chuyên môn sơ cứu)</option>
                <option value="nv-tuan">NV Lê Anh Tuấn (Đẩy xe lăn / Khuân vác)</option>
                <option value="nv-hoa">NV Trần Hoa (Chăm sóc người cao tuổi)</option>
            </select>

            <div style="display:flex; gap:10px; margin-top:20px;">
                <button onclick="closeModal()" style="flex:1; padding:10px; border-radius:8px; border:1px solid #cbd5e1; background:#fff; font-weight:700; cursor:pointer;">Hủy</button>
                <button onclick="confirmAssign()" style="flex:1; padding:10px; border-radius:8px; border:none; background:#0f766e; color:#fff; font-weight:700; cursor:pointer;">Xác nhận Phân bổ</button>
            </div>
        </div>
    </div>

    <script>
        let currentOrder = '';

        function openModal(orderId) {
            currentOrder = orderId;
            document.getElementById('modal-order-id').innerText = '#' + orderId;
            document.getElementById('assignModal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('assignModal').classList.remove('show');
            document.getElementById('staffSelect').value = '';
        }

        function confirmAssign() {
            const staff = document.getElementById('staffSelect').value;
            if(!staff) {
                alert("Vui lòng chọn nhân viên hỗ trợ!");
                return;
            }
            
            // Đổi trạng thái hiển thị
            const statusBadge = document.getElementById('status-' + currentOrder.split('-')[1]);
            const actionBtn = document.getElementById('btn-' + currentOrder.split('-')[1]);
            
            if(statusBadge && actionBtn) {
                statusBadge.className = 'badge badge-success';
                statusBadge.innerText = 'Đã phân bổ NV';
                
                actionBtn.className = 'btn-action btn-done';
                actionBtn.innerHTML = '<i class="fa fa-check"></i> Hoàn tất';
                actionBtn.disabled = true;
            }
            
            closeModal();
        }
    </script>
</body>
</html>
HTML;
file_put_contents($frontendDir . '/admin_medical.html', $htmlCode);
echo "=== DA TAO TRANG QUAN LY Y TE (admin_medical.html) ===\n";

// 2. CẬP NHẬT LINK MENU TRONG CÁC TRANG ADMIN CŨ
$filesToUpdate = [
    $frontendDir . '/admin_dashboard.html',
    $frontendDir . '/admin_auditor.html'
];

foreach ($filesToUpdate as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Tìm và thay thế dòng "(Sắp ra mắt)" thành link thật
        $pattern = '/<a href="#" class="menu-item"><i class="fa fa-heartbeat fa-fw"><\/i> Quản lý Y tế \(Sắp ra mắt\)<\/a>/is';
        $replacement = '<a href="admin_medical.html" class="menu-item"><i class="fa fa-heartbeat fa-fw"></i> Quản lý Y tế & Hỗ trợ</a>';
        
        $newContent = preg_replace($pattern, $replacement, $content);
        file_put_contents($file, $newContent);
        echo "=== DA CAP NHAT LINK MENU TRONG: " . basename($file) . " ===\n";
    }
}
?>
