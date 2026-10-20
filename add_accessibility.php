<?php
$frontendDir = __DIR__ . '/frontend';

// Quét toàn bộ file HTML trong thư mục frontend
$htmlFiles = glob($frontendDir . '/*.html');

$accessibilityJS = <<<'HTML'
<!-- ACCESSIBILITY MODULE -->
<style>
    /* Nút Trợ năng lơ lửng */
    #access-widget-btn {
        position: fixed; bottom: 30px; left: 30px; width: 56px; height: 56px;
        background: #0f766e; color: #fff; border-radius: 50%; box-shadow: 0 4px 15px rgba(15,118,110,0.4);
        display: flex; align-items: center; justify-content: center; font-size: 28px;
        cursor: pointer; z-index: 99999; transition: 0.3s;
    }
    #access-widget-btn:hover { transform: scale(1.1); background: #0d9488; }
    
    /* Bảng điều khiển */
    #access-panel {
        position: fixed; bottom: 100px; left: 30px; width: 280px; background: #fff;
        border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); border: 2px solid #0f766e;
        padding: 20px; z-index: 99998; opacity: 0; visibility: hidden; transform: translateY(20px);
        transition: 0.3s; font-family: system-ui, sans-serif;
    }
    #access-panel.show { opacity: 1; visibility: visible; transform: translateY(0); }
    #access-panel h4 { margin: 0 0 15px 0; color: #0f172a; font-size: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px; }
    
    .access-row { display: flex; gap: 10px; margin-bottom: 15px; }
    .access-btn { flex: 1; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; background: #f8fafc; font-weight: 700; color: #0f172a; cursor: pointer; transition: 0.2s; }
    .access-btn:hover, .access-btn.active { background: #0f766e; color: #fff; border-color: #0f766e; }
    
    .access-toggle { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; background: #f8fafc; font-weight: 600; color: #0f172a; cursor: pointer; display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
    .access-toggle:hover { background: #e2e8f0; }

    /* CSS Chế độ Tương phản cao */
    body.high-contrast { background: #000 !important; color: #ffff00 !important; }
    body.high-contrast * { background-color: #000 !important; color: #ffff00 !important; border-color: #ffff00 !important; box-shadow: none !important; }
    body.high-contrast img { filter: contrast(120%) grayscale(20%); }

    /* Nút Đọc văn bản mọc ra khi bôi đen */
    #tts-popup {
        position: absolute; background: #0f766e; color: #fff; padding: 8px 16px;
        border-radius: 20px; font-size: 14px; font-weight: 700; cursor: pointer;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2); z-index: 100000; display: none; align-items: center; gap: 8px;
    }
    #tts-popup:hover { background: #0d9488; }
</style>

<!-- Nút nổi -->
<div id="access-widget-btn" onclick="toggleAccessPanel()">
    <i class="fa fa-wheelchair-alt"></i>
</div>

<!-- Bảng Trợ năng -->
<div id="access-panel">
    <h4><i class="fa fa-cogs"></i> Tùy chỉnh Trợ năng</h4>
    <div style="font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 8px;">Kích thước chữ:</div>
    <div class="access-row">
        <button class="access-btn active" id="btn-font-1" onclick="setFontSize(1)">A</button>
        <button class="access-btn" id="btn-font-2" onclick="setFontSize(2)">A+</button>
        <button class="access-btn" id="btn-font-3" onclick="setFontSize(3)">A++</button>
    </div>
    
    <button class="access-toggle" onclick="toggleHighContrast()">
        <span><i class="fa fa-adjust"></i> Tương phản cao</span>
        <span id="contrast-status">TẮT</span>
    </button>
    
    <button class="access-toggle" id="btn-tts-mode" onclick="toggleTTSMode()">
        <span><i class="fa fa-volume-up"></i> Chế độ Đọc (Chạm)</span>
        <span id="tts-status">TẮT</span>
    </button>
</div>

<!-- Nút Đọc Văn Bản Ẩn -->
<div id="tts-popup" onclick="speakSelectedText()"><i class="fa fa-play-circle"></i> Đọc chữ</div>

<script>
    // 1. Mở bảng công cụ
    function toggleAccessPanel() {
        document.getElementById('access-panel').classList.toggle('show');
    }

    // 2. Chỉnh cỡ chữ
    function setFontSize(level) {
        document.querySelectorAll('.access-btn').forEach(b => b.classList.remove('active'));
        document.getElementById('btn-font-' + level).classList.add('active');
        
        let root = document.documentElement;
        if(level === 1) root.style.fontSize = '100%'; // Mặc định
        if(level === 2) root.style.fontSize = '110%'; // To vừa
        if(level === 3) root.style.fontSize = '125%'; // To đại
    }

    // 3. Chế độ tương phản cao (Mù màu / Mắt kém)
    let isHighContrast = false;
    function toggleHighContrast() {
        isHighContrast = !isHighContrast;
        if(isHighContrast) {
            document.body.classList.add('high-contrast');
            document.getElementById('contrast-status').innerText = 'BẬT';
        } else {
            document.body.classList.remove('high-contrast');
            document.getElementById('contrast-status').innerText = 'TẮT';
        }
    }

    // 4. Trợ lý Đọc văn bản (Bôi đen là đọc)
    let isTTSMode = false;
    function toggleTTSMode() {
        isTTSMode = !isTTSMode;
        const status = document.getElementById('tts-status');
        const btn = document.getElementById('btn-tts-mode');
        if(isTTSMode) {
            status.innerText = 'BẬT';
            btn.style.borderColor = '#10b981';
            alert('Đã BẬT Trợ lý đọc! Hãy dùng chuột bôi đen một đoạn văn bản trên web để nghe hệ thống đọc.');
        } else {
            status.innerText = 'TẮT';
            btn.style.borderColor = '#cbd5e1';
            window.speechSynthesis.cancel(); // Tắt đọc ngay
        }
    }

    // Hiện nút loa khi bôi đen chữ
    document.addEventListener('mouseup', function(e) {
        if(!isTTSMode) return;
        const text = window.getSelection().toString().trim();
        const popup = document.getElementById('tts-popup');
        
        if(text.length > 0) {
            popup.style.display = 'flex';
            popup.style.top = (e.pageY - 40) + 'px';
            popup.style.left = e.pageX + 'px';
        } else {
            popup.style.display = 'none';
        }
    });

    // Phát âm thanh
    function speakSelectedText() {
        const text = window.getSelection().toString().trim();
        if(text.length > 0) {
            window.speechSynthesis.cancel();
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'vi-VN'; // Chuẩn giọng tiếng Việt
            utterance.rate = 0.9;     // Đọc hơi chậm lại cho người già dễ nghe
            window.speechSynthesis.speak(utterance);
        }
        document.getElementById('tts-popup').style.display = 'none';
    }

    // Tích hợp với 3 nút A A+ A++ có sẵn trên thanh Menu của bro
    document.addEventListener('DOMContentLoaded', () => {
        const existingA = document.querySelectorAll('span, button, a');
        existingA.forEach(el => {
            if(el.innerText === 'A') el.onclick = (e) => { e.preventDefault(); setFontSize(1); };
            if(el.innerText === 'A+') el.onclick = (e) => { e.preventDefault(); setFontSize(2); };
            if(el.innerText === 'A++') el.onclick = (e) => { e.preventDefault(); setFontSize(3); };
        });
    });
</script>
<!-- END ACCESSIBILITY MODULE -->
HTML;

foreach ($htmlFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Xóa code cũ nếu đã cài để tránh trùng lặp
        $content = preg_replace('/<!-- ACCESSIBILITY MODULE -->.*?<!-- END ACCESSIBILITY MODULE -->/is', '', $content);
        
        // Cấy vào trước thẻ </body>
        $newContent = str_replace('</body>', $accessibilityJS . "\n</body>", $content);
        file_put_contents($file, $newContent);
        echo "=== DA CAY THANH CONG CU TRO NANG VAO FILE: " . basename($file) . " ===\n";
    }
}
?>
