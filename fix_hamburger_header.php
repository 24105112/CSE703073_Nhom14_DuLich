<?php
$htmlFiles = ['index.html', 'search.html', 'detail.html', 'booking.html', 'admin_dashboard.html'];

$megaFixCSS = <<<CSS
<style id="mega-header-fix">
    /* 1. GHIM HEADER VĨNH VIỄN BẰNG FIXED */
    body { padding-top: 60px !important; } /* Đẩy nội dung xuống để không bị Header đè */
    header, .header, .navbar {
        position: fixed !important;
        top: 0 !important; left: 0 !important; right: 0 !important;
        height: 60px !important;
        background-color: var(--color-bg-card, #ffffff) !important;
        z-index: 9999 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 0 16px !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08) !important;
        border: none !important;
    }
    html[data-theme="dark"] header, html[data-theme="dark"] .navbar { background-color: #0f172a !important; border-bottom: 1px solid #334155 !important; }

    /* 2. GIAO DIỆN NÚT HAMBURGER (3 GẠCH) & MENU RỦ XUỐNG */
    .hamburger-btn {
        background: transparent !important;
        border: none !important;
        font-size: 26px !important;
        cursor: pointer !important;
        display: none !important;
        color: var(--color-text-main, #0f172a) !important;
        padding: 4px 8px !important;
        margin-left: 10px !important;
    }
    html[data-theme="dark"] .hamburger-btn { color: #f8fafc !important; }

    .mobile-dropdown {
        position: fixed !important;
        top: 60px !important;
        left: 0 !important;
        right: 0 !important;
        background-color: var(--color-bg-card, #ffffff) !important;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1) !important;
        display: none !important; /* Mặc định ẩn */
        flex-direction: column !important;
        padding: 16px !important;
        z-index: 9998 !important;
        max-height: calc(100vh - 60px);
        overflow-y: auto;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }
    html[data-theme="dark"] .mobile-dropdown { background-color: #1e293b !important; }
    .mobile-dropdown.show { display: flex !important; } /* Hiện khi bấm nút */

    .mobile-dropdown a, .mobile-dropdown button {
        margin: 6px 0 !important;
        padding: 14px !important;
        text-align: center !important;
        font-size: 15px !important;
        font-weight: 600 !important;
        border-radius: 8px !important;
        text-decoration: none !important;
        color: var(--color-text-main, #0f172a) !important;
        background: #f1f5f9 !important;
        border: none !important;
        width: 100% !important;
    }
    html[data-theme="dark"] .mobile-dropdown a, html[data-theme="dark"] .mobile-dropdown button {
        color: #f8fafc !important; background: #0f172a !important; 
    }
    .mobile-dropdown .btn-primary { background: #0284c7 !important; color: #fff !important; }

    /* --- 3. RESPONSIVE 3 KHỔ MÀN HÌNH --- */
    
    /* Desktop (>= 1024px): Hiển thị hàng ngang đầy đủ như cũ */
    @media (min-width: 1024px) {
        .hamburger-btn { display: none !important; }
        header > *:not(.hamburger-btn) { display: inline-flex !important; }
    }

    /* Tablet (768px - 1023px) & Mobile (< 768px): Bật Hamburger Menu */
    @media (max-width: 1023px) {
        .hamburger-btn { display: block !important; }
        /* Ẩn các menu item trên header gốc, chỉ chừa lại Logo, Nút DarkMode và Nút Hamburger */
        header > *:not(.logo):not(img):not(.hamburger-btn):not(#themeToggleBtn) { display: none !important; }
        #themeToggleBtn { margin-left: auto; } /* Ép nút DarkMode sang phải cạnh nút 3 gạch */
    }
</style>
CSS;

$megaFixJS = <<<JS
<script id="mega-header-js">
document.addEventListener("DOMContentLoaded", function() {
    var header = document.querySelector('header') || document.querySelector('.header') || document.querySelector('.navbar');
    if(!header) return;

    // Cấy nút Hamburger (3 gạch) vào Header
    if(!document.querySelector('.hamburger-btn')) {
        var btn = document.createElement('button');
        btn.className = 'hamburger-btn';
        btn.innerHTML = '☰';
        header.appendChild(btn);
    }

    // Cấy khung Menu Rủ xuống (Dropdown)
    if(!document.querySelector('.mobile-dropdown')) {
        var dropdown = document.createElement('div');
        dropdown.className = 'mobile-dropdown';
        
        // Lọc và Copy các thẻ a, button từ Header gốc bỏ vào Dropdown
        var links = header.querySelectorAll('a, button');
        links.forEach(function(el) {
            // Không copy Logo, nút Hamburger, và nút DarkMode vào menu rủ xuống
            if(el.classList.contains('logo') || el.classList.contains('hamburger-btn') || el.id === 'themeToggleBtn' || el.querySelector('img')) return;
            var clone = el.cloneNode(true);
            clone.removeAttribute('style'); // Xóa style cứng để ăn CSS mới
            dropdown.appendChild(clone);
        });
        
        document.body.insertBefore(dropdown, document.body.firstChild);
    }

    // Xử lý sự kiện bấm nút
    var hamburger = document.querySelector('.hamburger-btn');
    var mobileMenu = document.querySelector('.mobile-dropdown');
    if(hamburger && mobileMenu) {
        hamburger.addEventListener('click', function() {
            mobileMenu.classList.toggle('show');
            // Đổi icon 3 gạch thành dấu X khi mở menu
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
        
        // Dọn dẹp các CSS vá lỗi header từ trước
        $content = preg_replace('/<style id="ios-pro-header">.*?<\/style>/is', '', $content);
        $content = preg_replace('/<style id="sticky-header-fix">.*?<\/style>/is', '', $content);
        $content = preg_replace('/<style id="mega-header-fix">.*?<\/style>/is', '', $content);
        $content = preg_replace('/<script id="mega-header-js">.*?<\/script>/is', '', $content);
        
        // Chèn CSS và JS mới
        $content = str_replace('</head>', $megaFixCSS . "\n</head>", $content);
        $content = str_replace('</body>', $megaFixJS . "\n</body>", $content);
        
        file_put_contents($path, $content);
    }
}
echo "=== DA TOI UU 3 KHO MAN HINH! HEADER DA FIX CUNG + MENU RỦ XUỐNG CỰC MUỢT! ===\n";
?>
