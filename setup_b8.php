<?php
// === 1. TẠO FILE NHẬT KÝ SỬA LỖI BACKEND (CHO V3) ===
$logContent = "# NHẬT KÝ SỬA LỖI BACKEND (FIX LOG) - BUỔI 08\n**Người thực hiện:** Nguyễn Trung Anh (V3 - Phát triển máy chủ)\n**Ngày thực hiện:** Buổi 08\n\n### Danh sách các vấn đề Backend đã xử lý:\n1. **Fix lỗi CORS Headers:** Bổ sung `Access-Control-Allow-Origin` và xử lý request `OPTIONS` ở đầu các API.\n2. **Fix lỗi Phông chữ tiếng Việt JSON:** Thêm cờ `JSON_UNESCAPED_UNICODE` để API trả về chữ tiếng Việt chuẩn.\n3. **Tối ưu câu truy vấn Search & Phân trang:** Viết lại mảng `\$where` ghép bằng `IMPLODE(' AND ')` và sử dụng Prepared Statements an toàn chống SQL Injection.\n4. **Xử lý ngoại lệ Máy trạng thái đơn:** Đơn hết hạn hoặc hủy ngang tự động `UPDATE accessible_destinations SET available_slots = available_slots + ?`.";
file_put_contents(__DIR__ . '/NhatKy_SuaLoi_Backend_Buoi08.md', $logContent);

// === 2. V3: FIX API SEARCH & BỔ SUNG CORS/JSON UNICODE ===
$searchCode = <<<PHP
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
if (\$_SERVER['REQUEST_METHOD'] == 'OPTIONS') { http_response_code(200); exit(); }
require_once 'db.php';
\$page = isset(\$_GET['page']) ? (int)\$_GET['page'] : 1;
\$limit = isset(\$_GET['limit']) ? (int)\$_GET['limit'] : 6;
\$offset = (\$page - 1) * \$limit;
\$keyword = isset(\$_GET['keyword']) ? trim(\$_GET['keyword']) : '';
\$hasWheelchair = isset(\$_GET['has_wheelchair']) ? (int)\$_GET['has_wheelchair'] : 0;
try {
    \$where = ["1=1"]; \$params = [];
    if (\$keyword !== '') { \$where[] = "(title LIKE ? OR address LIKE ?)"; \$params[] = "%\$keyword%"; \$params[] = "%\$keyword%"; }
    if (\$hasWheelchair === 1) { \$where[] = "has_wheelchair_access = 1"; }
    \$whereSql = implode(" AND ", \$where);
    
    \$countStmt = \$pdo->prepare("SELECT COUNT(*) FROM accessible_destinations WHERE \$whereSql");
    \$countStmt->execute(\$params);
    \$totalItems = \$countStmt->fetchColumn();
    \$totalPages = ceil(\$totalItems / \$limit) ?: 1;
    
    \$sql = "SELECT id, title, address, price, available_slots, has_wheelchair_access, has_elevator, has_audio_guide FROM accessible_destinations WHERE \$whereSql ORDER BY id DESC LIMIT \$limit OFFSET \$offset";
    \$stmt = \$pdo->prepare(\$sql);
    \$stmt->execute(\$params);
    \$items = \$stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['status' => 'success', 'page' => \$page, 'limit' => \$limit, 'total_items' => (int)\$totalItems, 'total_pages' => (int)\$totalPages, 'data' => \$items], JSON_UNESCAPED_UNICODE);
} catch (Exception \$e) { 
    http_response_code(500); 
    echo json_encode(['status' => 'error', 'message' => \$e->getMessage()], JSON_UNESCAPED_UNICODE); 
}
PHP;
file_put_contents(__DIR__ . '/api/search.php', $searchCode);

// === 3. V4: THÊM DESIGN TOKENS (DARK MODE) & RESPONSIVE CSS ===
$cssPath = __DIR__ . '/frontend/css/tokens.css';$cssAppend = <<<CSS

/* === BUOI 8: DARK MODE & RESPONSIVE === */
:root {
    --bg-main: #f8fafc;
    --color-bg-card: #ffffff;
    --color-text-main: #0f172a;
    --color-text-muted: #64748b;
    --color-border: #e2e8f0;
}
[data-theme="dark"] {
    --bg-main: #0f172a;
    --color-bg-card: #1e293b;
    --color-text-main: #f8fafc;
    --color-text-muted: #94a3b8;
    --color-border: #334155;
}
body { background-color: var(--bg-main); color: var(--color-text-main); transition: background-color 0.3s, color 0.3s; }

/* Responsive Media Queries cho 3 khổ màn hình */
@media (max-width: 1023px) { /* Tablet 768px - 1023px */
    .tour-grid, .metrics-grid, .charts-grid, .grid-4, .grid-2 { grid-template-columns: repeat(2, 1fr) !important; gap: 16px; }
}
@media (max-width: 767px) { /* Mobile < 768px (Chuẩn 375px) */
    .tour-grid, .metrics-grid, .charts-grid, .grid-4, .grid-2, .detail-layout, .review-dashboard { grid-template-columns: 1fr !important; gap: 12px; }
    .hero-gallery { height: 240px !important; }
}
CSS;
if(file_exists($cssPath) && strpos(file_get_contents($cssPath), 'BUOI 8: DARK MODE') === false) {
    file_put_contents($cssPath,$cssAppend, FILE_APPEND);
}

// === 4. V4: THÊM JS THEME SWITCHER VÀO APP.JS ===
$jsPath = __DIR__ . '/frontend/js/app.js';$jsAppend = <<<JS

// === BUOI 8: THEME SWITCHER ===
function toggleTheme() {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    updateThemeButton(newTheme);
}
function updateThemeButton(theme) {
    const btn = document.getElementById('themeToggleBtn');
    if (btn) btn.innerHTML = theme === 'dark' ? '☀️ Sáng' : '🌙 Tối';
}
(function initTheme() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    document.addEventListener("DOMContentLoaded", () => updateThemeButton(savedTheme));
})();
JS;
if(file_exists($jsPath) && strpos(file_get_contents($jsPath), 'BUOI 8: THEME SWITCHER') === false) {
    file_put_contents($jsPath,$jsAppend, FILE_APPEND);
}

// === 5. CẤY NÚT CHUYỂN CHỦ ĐỀ VÀO CÁC FILE HTML ===
$htmlFiles = ['index.html', 'detail.html', 'search.html', 'admin_dashboard.html', 'booking.html'];
foreach($htmlFiles as$file) {
    $p = __DIR__ . '/frontend/' .$file;
    if(file_exists($p)) {
        $c = file_get_contents($p);
        if(strpos($c, 'id="themeToggleBtn"') === false) {
            $btn = '<button id="themeToggleBtn" onclick="toggleTheme()" type="button" style="background:var(--color-bg-card); color:var(--color-text-main); border:1px solid var(--color-border); border-radius:99px; padding:6px 13px; font-size:13.5px; font-weight:800; cursor:pointer; min-height:38px; margin-right:8px;">🌙 Tối</button>';
            if (strpos($c, '<button id="btnLangSwitch"') !== false) {
                $c = str_replace('<button id="btnLangSwitch"', $btn . ' <button id="btnLangSwitch"', $c);
            } elseif (strpos($c, '<div class="header">') !== false) {
                $c = str_replace('<div class="header">', '<div class="header">' . $btn,$c);
            }
            file_put_contents($p,$c);
        }
    }
}
echo "=== DA HOAN THANH NHIEM VU BUOI 8 CHO V3 & V4! NÚT DARK MODE ĐÃ LÊN HÌNH! ===\n";
?>
