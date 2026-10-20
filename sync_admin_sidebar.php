<?php
$dashboardFile = __DIR__ . '/frontend/admin_dashboard.html';

if(file_exists($dashboardFile)) {
    $html = file_get_contents($dashboardFile);
    
    // Kiểm tra xem đã có sidebar chưa để tránh chèn đè 2 lần
    if(strpos($html, 'class="admin-layout"') === false) {
        
        // 1. Bơm CSS cho Layout và Sidebar
        $cssInjection = <<<'CSS'
<link href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" rel="stylesheet">
<style>
    body { margin: 0; background: #f8fafc; overflow-x: hidden; }
    .admin-layout { display: flex; min-height: 100vh; width: 100vw; }
    .sidebar { width: 260px; background: #0f766e; color: #fff; padding: 20px 0; flex-shrink: 0; display: flex; flex-direction: column; }
    .sidebar-logo { font-size: 20px; font-weight: 800; padding: 0 20px 20px; border-bottom: 1px solid #115e59; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
    .menu-item { padding: 15px 20px; display: block; color: #ccfbf1; text-decoration: none; font-weight: 600; transition: 0.2s; }
    .menu-item:hover, .menu-item.active { background: #0d9488; color: #fff; border-left: 4px solid #5eead4; }
    .btn-logout { margin-top: auto; padding: 15px 20px; color: #fca5a5; text-decoration: none; font-weight: 600; display: block; border-top: 1px solid #115e59; transition: 0.2s;} 
    .btn-logout:hover { color: #fff; background: #0f766e; }
    .content { flex: 1; padding: 30px; overflow-y: auto; background: #f8fafc; }
</style>
CSS;
        $html = str_replace('</head>', $cssInjection . "\n</head>", $html);

        // 2. Bọc toàn bộ nội dung cũ của trang Tổng quan vào cục Layout mới
        preg_match('/<body[^>]*>(.*?)<\/body>/is', $html, $matches);
        if(isset($matches[1])) {
            $oldBodyContent = $matches[1];
            
            $newBodyContent = <<<'HTML'
<div class="admin-layout">
    <!-- Sidebar Menu cố định -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <i class="fa fa-wheelchair"></i> AccessTravel
        </div>
        <a href="admin_dashboard.html" class="menu-item active"><i class="fa fa-pie-chart fa-fw"></i> Tổng quan (Dashboard)</a>
        <a href="admin_auditor.html" class="menu-item"><i class="fa fa-check-square-o fa-fw"></i> Trạm Kiểm Định</a>
        <a href="#" class="menu-item"><i class="fa fa-heartbeat fa-fw"></i> Quản lý Y tế (Sắp ra mắt)</a>
        <a href="#" class="menu-item"><i class="fa fa-cog fa-fw"></i> Cài đặt</a>
        
        <a href="index.html" class="btn-logout"><i class="fa fa-sign-out fa-fw"></i> Thoát về Trang chủ</a>
    </div>

    <!-- Nội dung cũ của trang Dashboard sẽ nằm ở đây -->
    <div class="content">
HTML . $oldBodyContent . <<<'HTML'
    </div>
</div>
HTML;
            
            // Thay thế body cũ bằng body mới
            $html = preg_replace('/(<body[^>]*>).*?(<\/body>)/is', "$1\n" . $newBodyContent . "\n$2", $html);
            
            file_put_contents($dashboardFile, $html);
            echo "=== DA DONG BO GIAO DIEN MENU BEN TRAI CHO TRANG TONG QUAN! ===\n";
        }
    } else {
        echo "=== TRANG TONG QUAN DA CO MENU TU TRUOC! ===\n";
    }
} else {
    echo "Khong tim thay file admin_dashboard.html\n";
}
?>
