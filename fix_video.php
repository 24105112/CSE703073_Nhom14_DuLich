<?php
$files = glob(__DIR__ . '/frontend/*.html');
foreach($files as $path) {
    $content = file_get_contents($path);
    // Truy tìm và tiêu diệt mọi link video .mp4 cũ (bao gồm con thỏ béo) 
    // Thay bằng video flycam du lịch (For Bigger Escapes - Google Sample)
    $content = preg_replace('/src="[^"]*\.mp4"/i', 'src="http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4"', $content);
    
    // Ép video tự động phát, lặp lại và tắt tiếng để làm background cho sang
    $content = str_replace('<video', '<video autoplay loop muted', $content);
    
    file_put_contents($path, $content);
}
echo "=== DA TIEN CON THO BEO DI CHO KHAC! GIAO DIEN DA CO VIDEO DU LICH CHILL CHILL! ===\n";
?>
