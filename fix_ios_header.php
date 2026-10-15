<?php
$htmlFiles = ['index.html', 'search.html', 'detail.html', 'booking.html', 'admin_dashboard.html'];
$iosCSS = <<<CSS
<style id="ios-pro-header">
    @media (max-width: 767px) {
        /* Bơm không gian để nội dung không bị Header đè lên */
        body { padding-top: 65px !important; }
        
        /* Chuyển Header thành Kính mờ (Glassmorphism) chuẩn iPhone */
        header, .header, .navbar {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            height: 55px !important;
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(15px) !important; /* Làm mờ nền phía sau */
            -webkit-backdrop-filter: blur(15px) !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06) !important;
            z-index: 9999 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-start !important;
            overflow-x: auto !important;
            overflow-y: hidden !important;
            padding: 0 16px !important;
            gap: 10px !important;
            border-bottom: none !important;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Chế độ Kính mờ cho Dark Mode */
        html[data-theme="dark"] header, html[data-theme="dark"] .navbar {
            background: rgba(15, 23, 42, 0.75) !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3) !important;
        }
        
        /* Giấu sạch thanh cuộn ngang để nhìn như app xịn */
        header::-webkit-scrollbar, .header::-webkit-scrollbar, .navbar::-webkit-scrollbar { display: none !important; }
        
        /* Ép các nút bấm thành dạng viên thuốc (Pill) phong cách Apple */
        #themeToggleBtn, button:not(.btn-primary), .btn, a.btn {
            background: #f1f5f9 !important;
            color: #0f172a !important;
            border-radius: 24px !important;
            padding: 8px 16px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            white-space: nowrap !important;
            border: none !important;
            flex-shrink: 0 !important;
        }
        
        /* Màu nút Pill khi bật Dark Mode */
        html[data-theme="dark"] #themeToggleBtn, html[data-theme="dark"] button:not(.btn-primary), html[data-theme="dark"] .btn {
            background: #334155 !important;
            color: #f8fafc !important;
        }
        
        /* Thu nhỏ Logo cho thanh thoát */
        img[alt*="logo"], .logo, .brand { 
            height: 26px !important; 
            margin-right: 8px !important; 
            flex-shrink: 0 !important; 
        }
        
        /* Ẩn các text menu dài dòng không cần thiết trên mobile */
        .nav-links, .menu-links, header a[href*=".html"]:not(.btn) { 
            display: none !important; 
        }
        
        /* Tối ưu viền các khối card trên mobile để rộng rãi hơn */
        .tour-card, .card {
            border-radius: 16px !important;
            margin-bottom: 16px !important;
        }
    }
</style>
CSS;

foreach($htmlFiles as $file) {
    $path = __DIR__ . '/frontend/' . $file;
    if(file_exists($path)) {
        $content = file_get_contents($path);
        // Xóa sạch các bản fix header cũ để không đè nhau
        $content = preg_replace('/<style id="mobile-header-fix">.*?<\/style>/is', '', $content);
        $content = preg_replace('/<style id="sticky-header-fix">.*?<\/style>/is', '', $content);
        $content = preg_replace('/<style id="ios-pro-header">.*?<\/style>/is', '', $content);
        
        // Bơm mã iOS Pro vào cuối head
        $content = str_replace('</head>', $iosCSS . "\n</head>", $content);
        file_put_contents($path, $content);
    }
}
echo "=== DA CAP NHAT GIAO DIEN MOBILE CHUAN APPLE! KINH MO SIEU DEP! ===\n";
?>
