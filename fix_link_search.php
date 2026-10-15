<?php
$path = __DIR__ . '/frontend/search.html';
if(file_exists($path)) {
    $content = file_get_contents($path);
    
    // Ép sự kiện onclick nhảy trang vào tất cả các nút "Xem thẩm định"
    $content = preg_replace(
        '/(<button|<a)([^>]*?)>(\s*Xem thẩm định\s*)(<\/button>|<\/a>)/is',
        '<button onclick="window.location.href=\'detail.html?id=\' + (typeof item !== \'undefined\' ? item.id : (typeof tour !== \'undefined\' ? tour.id : 1))" $2 style="cursor:pointer;">$3</button>',
        $content
    );
    
    // Ép luôn link cho ảnh bìa hoặc tiêu đề tour (nếu có)
    $content = str_replace('class="tour-card"', 'class="tour-card" onclick="window.location.href=\'detail.html?id=\' + (typeof item !== \'undefined\' ? item.id : (typeof tour !== \'undefined\' ? tour.id : 1))" style="cursor:pointer;"', $content);
    
    file_put_contents($path, $content);
    echo "=== DA FIX XONG LINK CHUYEN TRANG TU SEARCH SANG DETAIL! ===\n";
} else {
    echo "Khong tim thay file search.html\n";
}
?>
