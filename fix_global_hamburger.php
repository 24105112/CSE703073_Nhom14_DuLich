<?php
$htmlFiles = ['index.html', 'search.html', 'detail.html', 'booking.html', 'admin_dashboard.html'];

$globalCSS = <<<CSS
<style id="global-hamburger-fix">
    /* 1. GHIM HEADER VĨNH VIỄN BẰNG FIXED TRÊN MỌI MÀN HÌNH */
    body { padding-top: 60px !important; }
    header, .header, .navbar {
        position: fixed !important; top: 0 !important; left: 0 !important; right: 0 !important;
        height: 60px !important; background-color: var(--color-bg-card, #ffffff) !important;
        z-index: 9999 !important; display: flex !important; align-items: center !important;
        justify-content: space-between !important; padding: 0 16px !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08) !important; border: none !important;
    }
    html[data-theme="dark"] header, html[data-theme="dark"] .navbar { background-color: #0f172a !important; border-bottom: 1px solid #334155 !important; }
    
    /* 2. ẨN TẤT CẢ NÚT GỐC, CHỈ CHỪA LOGO, DARK MODE VÀ HAMBURGER */
    header > *:not(.logo):not(img):not(.hamburger-btn):not(#themeToggleBtn) { display: none !important; }
    #themeToggleBtn { margin-left: auto !important; }
    
    /* 3. NÚT HAMBURGER (3 GẠCH) HIỂN THỊ TOÀN CẦU */
    .hamburger-btn {
        background: transparent !important; border: none !important; font-size: 26px !important;
        cursor: pointer !important; display: block !important; color: var(--color-text-main, #0f172a) !important;
        padding: 4px 8px !important; margin-left: 10px !important;
    }
    html[data-theme="dark"] .hamburger-btn { color: #f8fafc !important; }

    /* 4. KHUNG MENU RỦ XUỐNG DÀNH CHO MỌI THIẾT BỊ */
    .mobile-dropdown {
        position: fixed !important; top: 60px !important; left: 0 !important; right: 0 !important;
        background-color: var(--color-bg-card, #ffffff) !important; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1) !important;
        display: none !important; flex-direction: column !important; padding: 16px !important;
        z-index: 9998 !important; max-height: calc(100vh - 60px); overflow-y: auto;
        border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;
    }
    html[data-theme="dark"] .mobile-dropdown { background-color: #1e293b !important; }
    .mobile-dropdown.show { display: flex !important; }

    .mobile-dropdown a, .mobile-dropdown button {
        margin: 6px 0 !important; padding: 14px !important; text-align: center !important;
        font-size: 15px !important; font-weight: 600 !important; border-radius: 8px !important;
        text-decoration: none !important; color: var(--color-text-main, #0f172a) !important;
        background: #f1f5f9 !important; border: none !important; width: 100% !important;
    }
    html[data-theme="dark"] .mobile-dropdown a, html[data-theme="dark"] .mobile-dropdown button { color: #f8fafc !important; background: #0f172a !important; }
    .mobile-dropdown .btn-primary { background: #0284c7 !important; color: #fff !important; }
</style>
CSS;

$globalJS = <<<JS
<script id="global-hamburger-js">
document.addEventListener("DOMContentLoaded", function() {
    var header = document.querySelector('header') || document.querySelector('.header') || document.querySelector('.navbar');
    if(!header) return;

    // Tạo nút Hamburger nếu chưa có
    if(!document.querySelector('.hamburger-btn')) {
        var btn = document.createElement('button');
        btn.className = 'hamburger-btn';
        btn.innerHTML = '☰';
        header.appendChild(btn);
    }

    // Tạo Dropdown và copy tất cả các nút vào trong
    if(!document.querySelector('.mobile-dropdown')) {
        var dropdown = document.createElement('div');
        dropdown.className = 'mobile-dropdown';
        var links = header.querySelectorAll('a, button');
        links.forEach(function(el) {
            // Loại trừ Logo, nút DarkMode và chính nút Hamburger
            if(el.classList.contains('logo') || el.classList.contains('hamburger-btn') || el.id === 'themeToggleBtn' || el.querySelector('img')) return;
            var clone = el.cloneNode(true);
            clone.removeAttribute('style');
            dropdown.appendChild(clone);
        });
        document.body.insertBefore(dropdown, document.body.firstChild);
    }

    // Gắn sự kiện click rủ menu xuống
    var hamburger = document.querySelector('.hamburger-btn');
    var mobileMenu = document.querySelector('.mobile-dropdown');
    if(hamburger && mobileMenu) {
        hamburger.addEventListener('click', function() {
            mobileMenu.classList.toggle('show');
            hamburger.innerHTML = mobileMenu.classList.contains('show') ? '✕' : '☰'; 
        });
    }
});
</script>
JS;

foreach($htmlFiles as $file) {
    $path = __DIR__ . '/frontend/' . $file;
    if(file_exists($path)) {
        $content = file_get_contents($path);
        
        // Dọn sạch tàn dư của các bản vá lỗi header theo kích thước cũ
        $content = preg_replace('/<style id="desktop-header-fix">.*?<\/style>/is', '', $content);
        $content = preg_replace('/<style id="mega-header-fix">.*?<\/style>/is', '', $content);
        $content = preg_replace('/<script id="mega-header-js">.*?<\/script>/is', '', $content);
        $content = preg_replace('/<style id="global-hamburger-fix">.*?<\/style>/is', '', $content);
        $content = preg_replace('/<script id="global-hamburger-js">.*?<\/script>/is', '', $content);
        
        // Bơm mã mới Global
        $content = str_replace('</head>', $globalCSS . "\n</head>", $content);
        $content = str_replace('</body>', $globalJS . "\n</body>", $content);
        file_put_contents($path, $content);
    }
}
echo "=== DA XOA BO MOI GIOI HAN! MENU HAMBURGER KICH HOAT TREN MOI MAN HINH! ===\n";
?>
