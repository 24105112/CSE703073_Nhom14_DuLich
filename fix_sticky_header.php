<?php
$htmlFiles = ['index.html', 'search.html', 'detail.html', 'booking.html', 'admin_dashboard.html'];
$stickyCSS = <<<CSS
<style id="sticky-header-fix">
    /* Ghim thanh Header dính chặt trên cùng cho mọi khổ màn hình */
    header, .header, .navbar {
        position: sticky !important;
        top: 0 !important;
        z-index: 1050 !important;
        background-color: var(--color-bg-card, #ffffff) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05) !important;
    }
    
    /* Đảm bảo Dark mode header cũng đổi màu đúng và không bị trong suốt */
    html[data-theme="dark"] header, html[data-theme="dark"] .navbar {
        background-color: #0f172a !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.5) !important;
    }
    
    /* Tinh chỉnh khoảng cách nội dung bên dưới để không bị Header che mất lúc khởi tạo */
    body {
        margin: 0 !important;
    }
</style>
CSS;

foreach($htmlFiles as $file) {
    $path = __DIR__ . '/frontend/' . $file;
    if(file_exists($path)) {
        $content = file_get_contents($path);
        // Xóa code cũ nếu đã chạy
        $content = preg_replace('/<style id="sticky-header-fix">.*?<\/style>/is', '', $content);
        // Cấy CSS ghim Header vào sát thẻ đóng </head>
        $content = str_replace('</head>', $stickyCSS . "\n</head>", $content);
        file_put_contents($path, $content);
    }
}
echo "=== DA FIX GHIM HEADER (STICKY)! CUON TRANG THOAI MAI KHONG MAT MENU! ===\n";
?>
