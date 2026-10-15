<?php
$frontendDir = __DIR__ . '/frontend/';
$files = glob($frontendDir . '*.html');

$modernSidebarCSS = <<<CSS
<style id="modern-sidebar-fix">
    /* 1. HEADER GỌN GÀNG NHƯ CŨ */
    body { padding-top: 60px !important; }
    header, .header, .navbar {
        position: fixed !important; top: 0 !important; left: 0 !important; right: 0 !important;
        height: 60px !important; background-color: var(--color-bg-card, #ffffff) !important;
        z-index: 9999 !important; display: flex !important; align-items: center !important;
        justify-content: space-between !important; padding: 0 16px !important;
        box-shadow: 0 1px 8px rgba(0,0,0,0.06) !important; border: none !important;
    }
    html[data-theme="dark"] header { background-color: #0f172a !important; border-bottom: 1px solid #334155 !important; }
    
    header > *:not(.logo):not(img):not(.hamburger-btn):not(#themeToggleBtn) { display: none !important; }
    #themeToggleBtn { margin-left: auto !important; margin-right: 16px !important; }
    
    .hamburger-btn {
        background: transparent !important; border: none !important; font-size: 24px !important;
        cursor: pointer !important; display: block !important; color: var(--color-text-main, #0f172a) !important;
        padding: 4px !important; margin: 0 !important;
    }
    html[data-theme="dark"] .hamburger-btn { color: #f8fafc !important; }

    /* 2. LỚP PHỦ ĐEN (OVERLAY) */
    .menu-overlay {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6); z-index: 99998;
        opacity: 0; visibility: hidden; transition: all 0.3s ease;
        backdrop-filter: blur(2px); -webkit-backdrop-filter: blur(2px);
    }
    .menu-overlay.show { opacity: 1; visibility: visible; }

    /* 3. MENU TRƯỢT TỪ BÊN PHẢI (SIDEBAR DRAWER) */
    .mobile-sidebar {
        position: fixed !important; top: 0 !important; right: -320px !important;
        width: 280px !important; height: 100vh !important;
        background-color: var(--color-bg-card, #ffffff) !important;
        box-shadow: -5px 0 25px rgba(0,0,0,0.15) !important;
        z-index: 99999 !important; transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        display: flex !important; flex-direction: column !important;
        padding: 20px 16px !important; overflow-y: auto !important;
    }
    html[data-theme="dark"] .mobile-sidebar { background-color: #1e293b !important; border-left: 1px solid #334155 !important; }
    .mobile-sidebar.show { right: 0 !important; }

    /* 4. STYLE CÁC NÚT BÊN TRONG SIDEBAR */
    .close-sidebar-btn {
        align-self: flex-end !important; background: transparent !important;
        border: none !important; font-size: 24px !important; cursor: pointer !important;
        color: #64748b !important; margin-bottom: 24px !important; padding: 8px !important;
        border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important;
    }
    .close-sidebar-btn:active { background: #f1f5f9 !important; }
    
    .mobile-sidebar a, .mobile-sidebar button:not(.close-sidebar-btn) {
        display: block !important; width: 100% !important; text-align: left !important;
        padding: 14px 16px !important; margin-bottom: 8px !important;
        font-size: 15px !important; font-weight: 500 !important;
        border-radius: 12px !important; text-decoration: none !important;
        color: var(--color-text-main, #0f172a) !important;
        background: transparent !important; border: 1px solid transparent !important;
        transition: all 0.2s ease !important;
    }
    html[data-theme="dark"] .mobile-sidebar a, html[data-theme="dark"] .mobile-sidebar button:not(.close-sidebar-btn) { color: #f8fafc !important; }
    
    .mobile-sidebar a:active, .mobile-sidebar button:active:not(.close-sidebar-btn) { background: #f1f5f9 !important; }
    html[data-theme="dark"] .mobile-sidebar a:active, html[data-theme="dark"] .mobile-sidebar button:active:not(.close-sidebar-btn) { background: #334155 !important; }
    
    /* Làm nổi bật nút Đăng nhập / Đăng ký */
    .mobile-sidebar .btn-primary { 
        background: #0284c7 !important; color: #fff !important; 
        font-weight: 600 !important; text-align: center !important; margin-top: 16px !important;
    }
</style>
CSS;

$modernSidebarJS = <<<JS
<script id="modern-sidebar-js">
document.addEventListener("DOMContentLoaded", function() {
    var header = document.querySelector('header') || document.querySelector('.header') || document.querySelector('.navbar');
    if(!header) return;

    if(!document.querySelector('.hamburger-btn')) {
        var btn = document.createElement('button');
        btn.className = 'hamburger-btn';
        btn.innerHTML = '☰';
        header.appendChild(btn);
    }

    var overlay = document.querySelector('.menu-overlay');
    if(!overlay) {
        overlay = document.createElement('div');
        overlay.className = 'menu-overlay';
        document.body.appendChild(overlay);
    }

    var sidebar = document.querySelector('.mobile-sidebar');
    if(!sidebar) {
        sidebar = document.createElement('div');
        sidebar.className = 'mobile-sidebar';
        
        var closeBtn = document.createElement('button');
        closeBtn.className = 'close-sidebar-btn';
        closeBtn.innerHTML = '✕';
        sidebar.appendChild(closeBtn);

        var links = header.querySelectorAll('a, button');
        links.forEach(function(el) {
            if(el.classList.contains('logo') || el.classList.contains('hamburger-btn') || el.id === 'themeToggleBtn' || el.querySelector('img')) return;
            var clone = el.cloneNode(true);
            clone.removeAttribute('style');
            sidebar.appendChild(clone);
        });
        document.body.appendChild(sidebar);
    }

    var hamburger = document.querySelector('.hamburger-btn');
    sidebar = document.querySelector('.mobile-sidebar');
    overlay = document.querySelector('.menu-overlay');
    var closeSidebar = document.querySelector('.close-sidebar-btn');

    function toggleMenu() {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }

    if(hamburger) hamburger.addEventListener('click', toggleMenu);
    if(closeSidebar) closeSidebar.addEventListener('click', toggleMenu);
    if(overlay) overlay.addEventListener('click', toggleMenu);
});
</script>
JS;

foreach($files as $path) {
    $content = file_get_contents($path);
    
    // Tẩy chay cái đống menu thả xuống rác rưởi cũ
    $content = preg_replace('/<style id="global-hamburger-fix">.*?<\/style>/is', '', $content);
    $content = preg_replace('/<script id="global-hamburger-js">.*?<\/script>/is', '', $content);
    $content = preg_replace('/<style id="modern-sidebar-fix">.*?<\/style>/is', '', $content);
    $content = preg_replace('/<script id="modern-sidebar-js">.*?<\/script>/is', '', $content);
    
    // Bơm Menu trượt ngang xịn xò vào
    $content = str_ireplace('</head>', $modernSidebarCSS . "\n</head>", $content);
    $content = str_ireplace('</body>', $modernSidebarJS . "\n</body>", $content);
    
    file_put_contents($path, $content);
}
echo "=== DA FIX MENU TRUOT NGANG (SIDEBAR)! GIAO DIEN APP XIN XO MUOT MA! ===\n";
?>
