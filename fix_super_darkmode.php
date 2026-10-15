<?php
$htmlFiles = ['index.html', 'search.html', 'detail.html', 'booking.html', 'admin_dashboard.html'];
$superDarkCSS = <<<CSS
<style id="super-dark-mode">
    /* Cưỡng chế toàn bộ thân trang web thành màu tối */
    html[data-theme="dark"] body, html[data-theme="dark"] header, html[data-theme="dark"] .navbar { 
        background-color: #0f172a !important; color: #f8fafc !important; border-bottom-color: #334155 !important;
    }
    
    /* Bắt mọi thẻ div mặc định trong suốt để không bị đè màu */
    html[data-theme="dark"] div, html[data-theme="dark"] section, html[data-theme="dark"] article {
        background-color: transparent !important; 
        color: #f8fafc !important;
        border-color: #334155 !important;
    }
    
    /* TUYỆT CHIÊU: Tự động nhận diện các khối thẻ (card) thông qua class, viền hoặc shadow để tô nền xám đen */
    html[data-theme="dark"] .tour-card, html[data-theme="dark"] .card, html[data-theme="dark"] .booking-card, 
    html[data-theme="dark"] .spec-card, html[data-theme="dark"] .ai-card, html[data-theme="dark"] .metric-card, 
    html[data-theme="dark"] .review-item, html[data-theme="dark"] .review-dashboard,
    html[data-theme="dark"] .content-section, html[data-theme="dark"] [style*="border"], 
    html[data-theme="dark"] [style*="box-shadow"], html[data-theme="dark"] [style*="padding: 24px"] {
        background-color: #1e293b !important;
    }

    /* Ép tất cả các loại chữ (tiêu đề, thẻ p, span, nhãn) phát sáng */
    html[data-theme="dark"] h1, html[data-theme="dark"] h2, html[data-theme="dark"] h3, 
    html[data-theme="dark"] h4, html[data-theme="dark"] p, html[data-theme="dark"] span,
    html[data-theme="dark"] strong, html[data-theme="dark"] label, html[data-theme="dark"] input { 
        color: #f8fafc !important; 
    }

    /* Bảo vệ các nút bấm, icon và badge trợ năng không bị hỏng màu */
    html[data-theme="dark"] button, html[data-theme="dark"] .btn, html[data-theme="dark"] .btn-primary { 
        background-color: #0284c7 !important; color: #fff !important; border:none !important; 
    }
    html[data-theme="dark"] img, html[data-theme="dark"] i, html[data-theme="dark"] svg {
        background-color: transparent !important;
    }
    html[data-theme="dark"] .verify-badge-large, html[data-theme="dark"] .ai-badge {
        background-color: #a21caf !important; color: #fdf4ff !important;
    }
</style>
CSS;

foreach($htmlFiles as $file) {
    $path = __DIR__ . '/frontend/' . $file;
    if(file_exists($path)) {
        $content = file_get_contents($path);
        
        // Xóa sạch các bản CSS vá lỗi cũ để tránh xung đột
        $content = preg_replace('/<style id="force-dark-mode">.*?<\/style>/is', '', $content);
        $content = preg_replace('/<style id="super-dark-mode">.*?<\/style>/is', '', $content);
        
        // Cắt bỏ tận gốc các thủ phạm gây "tàng hình" (inline styles màu trắng)
        $content = str_replace(['background: #fff;', 'background:#fff;', 'background-color: #ffffff;', 'background: white;', 'background-color: #fff;'], '', $content);
        
        // Chèn CSS mới cực mạnh vào trước thẻ </head>
        $content = str_replace('</head>', $superDarkCSS . "\n</head>", $content);
        file_put_contents($path, $content);
    }
}
echo "=== DA FIX TRUM CUOI! GIAO DIEN DEN MUOT MA TOAN DIEN! ===\n";
?>
