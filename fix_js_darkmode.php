<?php
$htmlFiles = ['index.html', 'search.html', 'detail.html', 'booking.html', 'admin_dashboard.html'];
$jsCode = <<<JS
<script>
function toggleTheme() {
    var currentTheme = document.documentElement.getAttribute('data-theme');
    var newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    var btns = document.querySelectorAll('#themeToggleBtn');
    btns.forEach(btn => btn.innerHTML = newTheme === 'dark' ? '☀️ Chế độ Sáng' : '🌙 Chế độ Tối');
}
// Khoi phuc theme khi F5
var savedTheme = localStorage.getItem('theme') || 'light';
document.documentElement.setAttribute('data-theme', savedTheme);
window.addEventListener("DOMContentLoaded", function() {
    var btns = document.querySelectorAll('#themeToggleBtn');
    btns.forEach(btn => btn.innerHTML = savedTheme === 'dark' ? '☀️ Chế độ Sáng' : '🌙 Chế độ Tối');
});
</script>
JS;

foreach($htmlFiles as $file) {
    $path = __DIR__ . '/frontend/' . $file;
    if(file_exists($path)) {
        $content = file_get_contents($path);
        // Xóa script cũ nếu lỡ chạy 2 lần
        $content = preg_replace('/<script>\s*function toggleTheme\(\).*?<\/script>/is', '', $content);
        // Chèn script mới sát trên thẻ đóng body
        if (strpos($content, 'function toggleTheme()') === false) {
            $content = str_replace('</body>', $jsCode . "\n</body>", $content);
            file_put_contents($path, $content);
        }
    }
}
echo "=== DA FIX XONG JS CHO NUT DARK MODE! BAM LA AN NGAY! ===\n";
?>
