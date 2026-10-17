<?php
$files = glob(__DIR__ . '/frontend/*.html');
foreach($files as $path) {
    $content = file_get_contents($path);
    // Bơm thuộc tính lazy load vào tất cả thẻ ảnh
    $content = preg_replace('/<img(?!.*?loading="lazy")(.*?)\/?>/is', '<img$1 loading="lazy">', $content);
    // Ép cờ defer vào các script để không chặn render
    $content = preg_replace('/<script src="([^"]+)"(?!.*?defer)><\/script>/is', '<script src="$1" defer></script>', $content);
    file_put_contents($path, $content);
}
echo "=== DA TOI UU HIEU NANG FRONTEND (LAZY LOAD + DEFER)! ===\n";
?>
