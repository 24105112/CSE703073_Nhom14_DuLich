<?php
$htmlFiles = ['index.html', 'search.html', 'detail.html', 'booking.html', 'admin_dashboard.html'];
$desktopFixCSS = <<<CSS
<style id="desktop-header-fix">
    /* --- ÉP KHUNG DESKTOP/LAPTOP (>= 1024px) KHÔNG ĐƯỢC RỚT DÒNG --- */
    @media (min-width: 1024px) {
        header, .header, .navbar {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important; /* Cấm tuyệt đối hành vi rớt dòng */
            align-items: center !important;
            justify-content: space-between !important;
            padding: 0 16px !important;
            gap: 6px !important; /* Ép khoảng cách các nút nhỏ lại */
            overflow-x: hidden !important; /* Cắt phần thừa nếu màn hình quá bé */
            width: 100% !important;
            height: 65px !important;
        }
        
        /* Cho phép các phần tử tự động co lại khi hết chỗ */
        header > *, .header > *, .navbar > * {
            flex-shrink: 1 !important; 
            white-space: nowrap !important; /* Không cho chữ trong nút rớt dòng */
        }

        /* Thu nhỏ font và padding của các nút trên màn hình laptop để nhét cho vừa */
        header button, header .btn, header a.btn, header .nav-links a {
            padding: 6px 10px !important;
            font-size: 13px !important;
            min-height: 32px !important;
        }
        
        /* Logo gọn lại một chút và tự động đẩy các nút kia sang phải */
        img[alt*="logo"], .logo, .brand { 
            height: 26px !important; 
            margin-right: auto !important; 
        }
    }
</style>
CSS;

foreach($htmlFiles as $file) {
    $path = __DIR__ . '/frontend/' . $file;
    if(file_exists($path)) {
        $content = file_get_contents($path);
        // Dọn dẹp code cũ nếu có chạy trước đó
        $content = preg_replace('/<style id="desktop-header-fix">.*?<\/style>/is', '', $content);
        // Bơm mã ép khung Desktop vào cuối head
        $content = str_replace('</head>', $desktopFixCSS . "\n</head>", $content);
        file_put_contents($path, $content);
    }
}
echo "=== DA FIX XONG HEADER DESKTOP! TAT CA NÚT ĐÃ ĐƯỢC ÉP VÀO 1 DÒNG! ===\n";
?>
