<?php
$htmlFiles = ['index.html', 'search.html', 'detail.html', 'booking.html', 'admin_dashboard.html'];
$forceDarkCSS = <<<CSS
<style id="force-dark-mode">
    /* Cưỡng chế CSS cho Dark Mode (BẢN HOÀN HẢO) */
    html[data-theme="dark"] body { background-color: #0f172a !important; color: #f8fafc !important; }
    html[data-theme="dark"] header, html[data-theme="dark"] .navbar { background-color: #0f172a !important; border-bottom: 1px solid #334155 !important; }
    
    /* Đã bổ sung .tour-card để nền thẻ chuyển sang màu tối */
    html[data-theme="dark"] .tour-card, html[data-theme="dark"] .card, html[data-theme="dark"] .booking-card, 
    html[data-theme="dark"] .spec-card, html[data-theme="dark"] .ai-card, html[data-theme="dark"] .metric-card, html[data-theme="dark"] .chart-card,
    html[data-theme="dark"] .review-dashboard, html[data-theme="dark"] .support-card,
    html[data-theme="dark"] .detail-wrap, html[data-theme="dark"] .content-section,
    html[data-theme="dark"] input, html[data-theme="dark"] select { 
        background-color: #1e293b !important; color: #f8fafc !important; border-color: #334155 !important; 
    }
    
    /* Chỉnh màu chữ hiển thị rõ trên nền tối */
    html[data-theme="dark"] h1, html[data-theme="dark"] h2, html[data-theme="dark"] h3, 
    html[data-theme="dark"] h4, html[data-theme="dark"] p, html[data-theme="dark"] span,
    html[data-theme="dark"] div, html[data-theme="dark"] strong, html[data-theme="dark"] label { 
        color: #f8fafc !important; 
    }
    
    /* Giữ nguyên màu cho nhãn AI và các nút */
    html[data-theme="dark"] .ai-badge { color: #fdf4ff !important; background: #a21caf !important; border-color: #f0abfc !important; }
    html[data-theme="dark"] a:not(.btn) { color: #38bdf8 !important; }
    html[data-theme="dark"] .spec-card.pass { background: rgba(22, 101, 52, 0.4) !important; border-color: #166534 !important; }
    html[data-theme="dark"] .btn-primary, html[data-theme="dark"] .btn, html[data-theme="dark"] button { background-color: #0284c7 !important; color: #fff !important; border:none !important; }
    html[data-theme="dark"] * { border-color: #334155 !important; }
</style>
CSS;

foreach($htmlFiles as $file) {
    $path = __DIR__ . '/frontend/' . $file;
    if(file_exists($path)) {
        $content = file_get_contents($path);
        // Xóa style lỗi cũ
        $content = preg_replace('/<style id="force-dark-mode">.*?<\/style>/is', '', $content);
        // Chèn style chuẩn xác vào cuối phần head
        $content = str_replace('</head>', $forceDarkCSS . "\n</head>", $content);
        file_put_contents($path, $content);
    }
}
echo "=== DA FIX PERFECT DARK MODE! MAU DEN XIN, CHU TRANG RO NET! ===\n";
?>
