<?php
// 1. NÂNG CẤP API TÌM KIẾM (api/search.php)
$apiPath = __DIR__ . '/api/search.php';$searchAPI = <<<PHP
<?php
require_once 'db.php';
header('Content-Type: application/json; charset=UTF-8');

try {
    \$sql = "SELECT * FROM accessible_destinations WHERE 1=1";
    \$params = [];

    // Lọc theo từ khóa (Tên/Địa điểm)
    if (!empty(\$_GET['q'])) {
        \$sql .= " AND (title LIKE :q OR address LIKE :q)";
        \$params[':q'] = '%' . trim(\$_GET['q']) . '%';
    }

    // Lọc theo tiện ích (Checkbox)
    if (isset(\$_GET['wheelchair']) && \$_GET['wheelchair'] === 'true') {
        \$sql .= " AND has_wheelchair_access = 1";
    }
    if (isset(\$_GET['elevator']) && \$_GET['elevator'] === 'true') {
        \$sql .= " AND (description LIKE '%thang máy%' OR description LIKE '%xe điện%')";
    }

    // Sắp xếp (Server Sort)
    \$sort = isset(\$_GET['sort']) ? \$_GET['sort'] : '';
    if (\$sort === 'price_asc') {
        \$sql .= " ORDER BY price ASC";
    } elseif (\$sort === 'price_desc') {
        \$sql .= " ORDER BY price DESC";
    } elseif (\$sort === 'rating') {
        \$sql .= " ORDER BY rating DESC";
    } else {
        \$sql .= " ORDER BY id DESC"; // Mặc định mới nhất
    }

    \$stmt = \$pdo->prepare(\$sql);
    \$stmt->execute(\$params);
    \$results = \$stmt->fetchAll();

    echo json_encode(["status" => "success", "data" => \$results]);
} catch (Exception \$e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => \$e->getMessage()]);
}
PHP;
if(is_dir(__DIR__ . '/api')) {
    file_put_contents($apiPath,$searchAPI);
}

// 2. CẤY JAVASCRIPT GOM DỮ LIỆU LỌC VÀO TRANG (frontend/search.html)
$frontendPath = __DIR__ . '/frontend/search.html';
if(file_exists($frontendPath)) {$content = file_get_contents($frontendPath);$filterScript = <<<JS
<script id="smart-filter-js">
document.addEventListener("DOMContentLoaded", function() {
    const filterBtn = document.querySelector('button:contains("Lọc kết quả"), .btn-filter, button[type="button"]'); // Tìm nút lọc
    if (!filterBtn) return;

    filterBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Thu thập toàn bộ dữ liệu từ các ô input/select/checkbox
        const q = document.querySelector('input[placeholder*="Tên địa điểm"], input[type="text"]').value;
        const sort = document.querySelector('select:last-of-type').value; // Ô select sắp xếp
        const wheelchair = document.querySelector('input[type="checkbox"]:nth-of-type(1)').checked;
        const elevator = document.querySelector('input[type="checkbox"]:nth-of-type(2)').checked;

        // Dựng URL kèm tham số truy vấn (Query String)
        const apiUrl = `../api/search.php?q=\${encodeURIComponent(q)}&sort=\${sort}&wheelchair=\${wheelchair}&elevator=\${elevator}`;
        
        // Gọi API và render lại danh sách tour
        fetch(apiUrl)
            .then(res => res.json())
            .then(res => {
                if(res.status === 'success') {
                    // Chèn hàm render danh sách của bro ở đây (gọi lại hàm hiển thị UI)
                    if(typeof renderTours === 'function') renderTours(res.data);
                    else console.log("Da lay duoc data loc:", res.data); // Báo log nếu chưa có hàm render
                }
            });
    });
});
</script>
JS;
    // Dọn code cũ và bơm code mới
    $content = preg_replace('/<script id="smart-filter-js">.*?<\/script>/is', '', $content);$content = str_replace('</body>', $filterScript . "\n</body>", $content);
    file_put_contents($frontendPath,$content);
}

echo "=== DA FIX XONG CHUC NANG LOC KET QUA KET HOP TIM KIEM & SAP XEP! ===\n";
?>
