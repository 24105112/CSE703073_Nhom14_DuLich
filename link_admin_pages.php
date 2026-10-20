<?php
// 1. TỰ ĐỘNG CHÈN LINK VÀO TRANG TỔNG QUAN (ADMIN_DASHBOARD.HTML)
$files = [__DIR__ . '/frontend/admin_dashboard.html', __DIR__ . '/frontend/admin.html'];

foreach ($files as $file) {
    if (file_exists($file)) {
        $html = file_get_contents($file);
        
        // Nếu trang chưa có link Trạm Kiểm Định thì mới chèn
        if (strpos($html, 'admin_auditor.html') === false) {
            // Regex tìm dòng chứa chữ "Tổng quan" hoặc "Dashboard"
            $pattern = '/(<a[^>]*>.*?(?:Tổng quan|Dashboard).*?<\/a>|<li[^>]*>.*?(?:Tổng quan|Dashboard).*?<\/li>)/is';
            
            // Nút Trạm Kiểm Định (Style trung tính để tự ăn theo giao diện cũ của bro)
            $injection = "\n" . '                        <!-- LINK TRẠM KIỂM ĐỊNH TỰ ĐỘNG -->
                        <a href="admin_auditor.html" class="nav-link menu-item" style="display:flex; align-items:center; gap:8px; padding:10px 15px; color:inherit; text-decoration:none;"><i class="fa fa-check-square-o"></i> Trạm Kiểm Định</a>';
            
            $html = preg_replace($pattern, "$1" . $injection, $html, 1);
            file_put_contents($file, $html);
            echo "=== DA CHEN NUT 'TRAM KIEM DINH' VAO FILE: " . basename($file) . " ===\n";
        } else {
            echo "=== " . basename($file) . " DA CO SAN LINK TRAM KIEM DINH TỪ TRƯỚC! ===\n";
        }
    }
}

// 2. BỔ SUNG NÚT "VỀ TRANG CHỦ" CHO TRẠM KIỂM ĐỊNH (ADMIN_AUDITOR.HTML)
$auditorFile = __DIR__ . '/frontend/admin_auditor.html';
if(file_exists($auditorFile)) {
    $aud = file_get_contents($auditorFile);
    if(strpos($aud, 'Về trang chủ') === false) {
        $aud = str_replace('<!-- Sidebar -->', "<!-- Sidebar -->\n<style>.btn-logout { margin-top: auto; padding: 15px 20px; color: #fca5a5; text-decoration: none; font-weight: 600; display: block; border-top: 1px solid #115e59; transition: 0.2s;} .btn-logout:hover { color: #fff; background: #0f766e; }</style>", $aud);
        
        $aud = str_replace('</div>

        <!-- Content -->', "<a href=\"index.html\" class=\"btn-logout\"><i class=\"fa fa-sign-out fa-fw\"></i> Thoát về Trang chủ</a>\n        </div>\n\n        <!-- Content -->", $aud);
        
        file_put_contents($auditorFile, $aud);
        echo "=== DA CAP NHAT NUT THOAT VE TRANG CHU CHO ADMIN AUDITOR! ===\n";
    }
}
?>
