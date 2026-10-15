<?php
$htmlFiles = ['index.html', 'search.html', 'detail.html', 'booking.html', 'admin_dashboard.html'];
$mobileCSS = <<<CSS
<style id="mobile-header-fix">
    @media (max-width: 767px) {
        /* Ép thanh Header thành một dòng duy nhất và cho phép vuốt ngang */
        header, .header, .navbar {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            overflow-x: auto !important;
            white-space: nowrap !important;
            padding: 10px 15px !important;
            gap: 10px !important;
            justify-content: flex-start !important;
            align-items: center !important;
            -webkit-overflow-scrolling: touch; /* Tạo cảm giác cuộn mượt trên iOS */
            border-bottom: 1px solid var(--color-border, #e2e8f0) !important;
        }
        
        /* Ẩn cái thanh cuộn ngang thô kệch đi cho đẹp */
        header::-webkit-scrollbar, .header::-webkit-scrollbar, .navbar::-webkit-scrollbar {
            display: none;
        }
        
        /* Chống co dúm các thành phần bên trong */
        header > *, .header > *, .navbar > * {
            flex-shrink: 0 !important;
            margin: 0 !important;
        }

        /* Ẩn tạm mấy link text rườm rà (Khám phá, Đánh giá...) để tiết kiệm không gian, chỉ ưu tiên Nút bấm */
        .nav-links, .menu-links, header a[href*=".html"]:not(.btn) { 
            display: none !important; 
        }

        /* Thu gọn kích thước các nút bấm trên Mobile */
        #themeToggleBtn, button, .btn, a.btn { 
            padding: 6px 12px !important; 
            font-size: 12px !important; 
            min-height: 32px !important;
        }

        /* Thu nhỏ logo lại một chút cho cân đối */
        img[alt*="logo"], .logo, .brand { 
            height: 28px !important; 
            margin-right: 10px !important;
        }
    }
</style>
CSS;

foreach($htmlFiles as $file) {
    $path = __DIR__ . '/frontend/' . $file;
    if(file_exists($path)) {
        $content = file_get_contents($path);
        // Xóa code cũ nếu đã chạy trước đó
        $content = preg_replace('/<style id="mobile-header-fix">.*?<\/style>/is', '', $content);
        // Cấy CSS mới vào sát thẻ đóng </head>
        $content = str_replace('</head>', $mobileCSS . "\n</head>", $content);
        file_put_contents($path, $content);
    }
}
echo "=== DA FIX GIAO DIEN MOBILE! THANH HEADER DA VUOT NGANG CUC MUOT! ===\n";
?>
