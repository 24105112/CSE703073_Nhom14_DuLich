<?php
$searchFile = __DIR__ . '/frontend/search.html';

if (file_exists($searchFile)) {
    $content = file_get_contents($searchFile);

    // 1. Dọn dẹp sạch sẽ cái cục lỗi cũ
    $content = preg_replace('/<!-- VOICE SEARCH MODULE -->.*?<!-- END VOICE SEARCH MODULE -->/is', '',$content);

    // 2. Chèn bộ Code mới xịn xò (Nút Mic nằm gọn trong Input)
    $newVoiceJS = <<<'HTML'
<!-- VOICE SEARCH MODULE -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Tìm ô input tìm kiếm của bro
    const searchInput = document.getElementById('keywordInput');
    
    if (searchInput && !document.getElementById('btn-voice-search')) {
        
        // 1. Bọc ô input vào một thẻ div để có thể đặt nút Mic vào trong
        const wrapper = document.createElement('div');
        wrapper.style.position = 'relative';
        wrapper.style.display = 'flex';
        wrapper.style.alignItems = 'center';
        wrapper.style.width = '100%';
        
        // Tráo đổi vị trí DOM
        searchInput.parentNode.insertBefore(wrapper, searchInput);
        wrapper.appendChild(searchInput);
        
        // Đẩy chữ sang trái một chút để không bị đè lên nút Mic
        searchInput.style.paddingRight = '40px';

        // 2. Tạo nút Micro bằng SVG (Cực sắc nét, không bị lỗi font)
        const micBtn = document.createElement('button');
        micBtn.id = 'btn-voice-search';
        micBtn.title = 'Tìm kiếm bằng giọng nói';
        micBtn.innerHTML = `<svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line><line x1="8" y1="23" x2="16" y2="23"></line></svg>`;
        
        // CSS cho nút Mic (Nằm gọn gàng bên phải ô input)
        micBtn.style.cssText = `
            position: absolute; right: 8px; background: transparent; border: none;
            color: #0f766e; cursor: pointer; padding: 6px; display: flex; align-items: center;
            justify-content: center; border-radius: 50%; transition: all 0.3s ease; outline: none;
        `;
        wrapper.appendChild(micBtn);

        // 3. CSS Hiệu ứng nhấp nháy cực mượt khi đang thu âm
        const style = document.createElement('style');
        style.innerHTML = `
            #btn-voice-search:hover { color: #0d9488; background: #ccfbf1; }
            #btn-voice-search.listening {
                color: #ef4444; background: #fee2e2;
                animation: mic-pulse 1.2s infinite;
            }
            @keyframes mic-pulse {
                0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.5); }
                70% { transform: scale(1.1); box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
                100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
            }
        `;
        document.head.appendChild(style);

        // 4. Kích hoạt Web Speech API
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        if (SpeechRecognition) {
            const recognition = new SpeechRecognition();
            recognition.lang = 'vi-VN';
            recognition.continuous = false;
            recognition.interimResults = false;

            // Xử lý sự kiện bấm (Dùng e.preventDefault() để không load lại trang)
            micBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                try {
                    recognition.start();
                } catch(err) {
                    console.log("Đã bấm rồi, hệ thống đang nghe...");
                }
            });

            // Khi bắt đầu nghe
            recognition.onstart = () => {
                micBtn.classList.add('listening');
                searchInput.placeholder = 'Đang nghe...';
            };

            // Khi ngừng nghe
            recognition.onspeechend = () => {
                recognition.stop();
                micBtn.classList.remove('listening');
                searchInput.placeholder = 'VD: Bái Đính, Ninh Bình...';
            };

            // Khi có kết quả giọng nói
            recognition.onresult = (event) => {
                let transcript = event.results[0][0].transcript;
                if(transcript.endsWith('.')) transcript = transcript.slice(0, -1); // Xóa dấu chấm
                
                searchInput.value = transcript;
                
                // Gọi hàm lọc kết quả
                if(typeof loadDestinations === 'function') {
                    loadDestinations(1);
                }
            };

            // Nếu lỗi (Từ chối micro, không nghe thấy gì)
            recognition.onerror = (event) => {
                micBtn.classList.remove('listening');
                searchInput.placeholder = 'VD: Bái Đính, Ninh Bình...';
                if(event.error === 'not-allowed') {
                    alert('Lỗi: Bạn chưa CẤP QUYỀN sử dụng Micro cho trình duyệt. Vui lòng ấn vào biểu tượng ổ khóa cạnh thanh URL để cho phép!');
                } else if (event.error === 'no-speech') {
                    // Im lặng không nói gì thì thôi, không cần báo lỗi lằng nhằng
                }
            };
        } else {
            micBtn.style.display = 'none'; // Trình duyệt quá cũ thì ẩn nút đi
        }
    }
});
</script>
<!-- END VOICE SEARCH MODULE -->
HTML;

    $content = str_replace('</body>', $newVoiceJS . "\n</body>", $content);
    file_put_contents($searchFile,$content);
    echo "=== DA FIX XONG LOI NUT MICRO! GIAO DIEN GOOGLE SEARCH! ===\n";
} else {
    echo "Khong tim thay file search.html\n";
}
?>
