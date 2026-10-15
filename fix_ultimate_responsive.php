<?php
$htmlFiles = ['index.html', 'search.html', 'detail.html', 'booking.html', 'admin_dashboard.html'];
$ultimateResponsiveCSS = <<<CSS
<style id="ultimate-responsive-grid">
    /* 1. CHỐNG VỠ GIAO DIỆN TOÀN TẬP */
    html, body {
        max-width: 100vw !important; /* Cấm web phình to hơn màn hình */
        overflow-x: hidden !important; /* Cấm kéo ngang tạo khoảng trắng */
        box-sizing: border-box !important;
    }
    *, *:before, *:after {
        box-sizing: inherit !important;
    }

    /* 2. CẤU TRÚC LƯỚI (GRID) LINH HOẠT CHO TẤT CẢ THIẾT BỊ */
    .tour-grid, .metrics-grid, .grid-container {
        display: grid !important;
        width: 100% !important;
    }

    /* --- GIAO DIỆN DESKTOP & LAPTOP (Màn hình lớn > 1024px) --- */
    @media (min-width: 1024px) {
        .tour-grid { 
            grid-template-columns: repeat(3, 1fr) !important; /* 3 Cột rộng rãi */
            gap: 24px !important; 
        }
    }

    /* --- GIAO DIỆN TABLET (iPad từ 768px đến 1023px) --- */
    @media (min-width: 768px) and (max-width: 1023px) {
        .tour-grid, .metrics-grid { 
            grid-template-columns: repeat(2, 1fr) !important; /* 2 Cột cân đối */
            gap: 16px !important; 
        }
    }

    /* --- GIAO DIỆN MOBILE & THIẾT BỊ CẦM TAY (Màn hình < 768px) --- */
    @media (max-width: 767px) {
        .tour-grid { 
            grid-template-columns: repeat(2, 1fr) !important; /* HIỂN THỊ 2 CỘT SONG SONG GỌN GÀNG */
            gap: 8px !important; /* Giảm khoảng cách để đỡ tốn diện tích */
            padding: 8px !important;
        }
        
        .metrics-grid {
            grid-template-columns: repeat(2, 1fr) !important; /* Bảng admin cũng chia 2 ô/hàng */
            gap: 8px !important;
        }

        /* Ép thẻ tour trên mobile phải nhỏ gọn, xinh xắn */
        .tour-card, .card {
            padding: 8px !important;
            border-radius: 12px !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
        }

        /* Thu nhỏ ảnh bìa để chừa chỗ cho chữ */
        .tour-card img, .card-img { 
            height: 100px !important; 
            width: 100% !important;
            object-fit: cover !important; 
            border-radius: 8px !important; 
            margin-bottom: 8px !important;
        }

        /* Chữ bên trong thẻ phải nhỏ lại cho vừa khung 2 cột */
        .tour-card h3, .tour-card h4 { 
            font-size: 13px !important; 
            line-height: 1.3 !important; 
            margin: 0 0 4px 0 !important; 
            overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; /* Chống chữ dài tràn dòng */
        }
        
        .tour-card p, .tour-card span { 
            font-size: 11px !important; 
            line-height: 1.2 !important; 
            margin-bottom: 4px !important;
        }

        /* Nút bấm trong thẻ tự động dàn ngang hoặc xếp gọn */
        .tour-card .btn, .tour-card button { 
            padding: 6px !important; 
            font-size: 11px !important; 
            width: 100% !important; /* Nút trải dài hết thẻ */
            margin-top: 4px !important;
        }
        
        /* Ẩn bớt đoạn mô tả dài thòng lọng trên thẻ mobile */
        .tour-card .description-preview, .card-desc { 
            display: none !important; 
        }
        
        /* Đảm bảo trang chi tiết (Detail) không bị bóp nghẹt */
        .detail-layout {
            grid-template-columns: 1fr !important;
        }
    }
</style>
CSS;

foreach($htmlFiles as $file) {
    $path = __DIR__ . '/frontend/' . $file;
    if(file_exists($path)) {
        $content = file_get_contents($path);
        
        // Dọn dẹp code CSS mobile cũ cồng kềnh (grid 1 cột) nếu có
        $content = preg_replace('/@media\s*\(\s*max-width\s*:\s*767px\s*\)\s*\{[^}]*?grid-template-columns\s*:\s*1fr[^}]*?\}/is', '', $content);
        $content = preg_replace('/<style id="ultimate-responsive-grid">.*?<\/style>/is', '', $content);
        
        // Cấy bộ mã Tối thượng vào
        $content = str_replace('</head>', $ultimateResponsiveCSS . "\n</head>", $content);
        file_put_contents($path, $content);
    }
}
echo "=== DA FIX GIAO DIEN MOBILE 2 COT XIN XO NHU SHOPEE/TRAVELOKA! KHOI LO VO KHUNG Tren MOI THIET BI! ===\n";
?>
