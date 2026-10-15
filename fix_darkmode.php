<?php
$htmlFiles = ['index.html', 'search.html', 'detail.html', 'booking.html', 'admin_dashboard.html'];
$btnHTML = '<button id="themeToggleBtn" onclick="toggleTheme()" type="button" style="background:var(--color-bg-card, #fff); color:var(--color-text-main, #0f172a); border:1px solid var(--color-border, #cbd5e1); border-radius:99px; padding:6px 13px; font-size:13.5px; font-weight:800; cursor:pointer; min-height:38px; margin-right:8px; display:inline-flex; align-items:center; transition: all 0.3s;">🌙 Chế độ Tối</button>';

foreach($htmlFiles as $file) {
    $path = __DIR__ . '/frontend/' . $file;
    if(file_exists($path)) {
        $content = file_get_contents($path);
        
        // Xóa nút cũ nếu bị chèn lặp
        $content = preg_replace('/<button id="themeToggleBtn".*?<\/button>/is', '', $content);
        
        // Chèn nút Dark Mode ngay trước nút "Aa Chế độ Chữ lớn"
        if (strpos($content, '<button id="btnThemeToggle"') !== false) {
            $content = str_replace('<button id="btnThemeToggle"', $btnHTML . "\n            <button id=\"btnThemeToggle\"", $content);
        } 
        // Xử lý riêng cho Admin Dashboard (nếu không có nút Aa)
        elseif (strpos($content, '<div class="header">') !== false && strpos($content, 'themeToggleBtn') === false) {
            $content = str_replace('<div class="header">', '<div class="header">' . $btnHTML, $content);
        }
        
        file_put_contents($path, $content);
    }
}
echo "=== DA FIX XONG NUT DARK MODE! CHAY NGAY CHO NONG ===\n";
?>
