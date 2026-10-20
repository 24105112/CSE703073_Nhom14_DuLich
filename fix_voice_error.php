<?php
$searchFile = __DIR__ . '/frontend/search.html';

if (file_exists($searchFile)) {
    $content = file_get_contents($searchFile);

    // Xóa bộ cũ
    $content = preg_replace('/<!-- VOICE SEARCH MODULE -->.*?<!-- END VOICE SEARCH MODULE -->/is', '',$content);

    // Code mới có tích hợp cảnh báo lỗi tự động
    $newVoiceJS = <<<'HTML'
<!-- VOICE SEARCH MODULE -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('keywordInput');
    
    if (searchInput && !document.getElementById('btn-voice-search')) {
        const wrapper = document.createElement('div');
        wrapper.style.position = 'relative';
        wrapper.style.display = 'flex';
        wrapper.style.alignItems = 'center';
        wrapper.style.width = '100%';
        
        searchInput.parentNode.insertBefore(wrapper, searchInput);
        wrapper.appendChild(searchInput);
        searchInput.style.paddingRight = '45px';

        const micBtn = document.createElement('button');
        micBtn.id = 'btn-voice-search';
        micBtn.title = 'Tìm kiếm bằng giọng nói';
        micBtn.type = 'button'; // Ngăn việc tự submit form
        micBtn.innerHTML = `<svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line><line x1="8" y1="23" x2="16" y2="23"></line></svg>`;
        
        micBtn.style.cssText = `
            position: absolute; right: 8px; background: #f0fdfa; border: 1px solid #ccfbf1;
            color: #0f766e; cursor: pointer; padding: 8px; display: flex; align-items: center;
            justify-content: center; border-radius: 50%; transition: all 0.3s ease; outline: none; z-index: 10;
        `;
        wrapper.appendChild(micBtn);

        const style = document.createElement('style');
        style.innerHTML = `
            #btn-voice-search:hover { color: #fff; background: #0f766e; }
            #btn-voice-search.listening { color: #fff; background: #ef4444; border-color: #ef4444; animation: mic-pulse 1.2s infinite; }
            @keyframes mic-pulse {
                0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
                70% { transform: scale(1.15); box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
                100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
            }
        `;
        document.head.appendChild(style);

        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        
        micBtn.onclick = function(e) {
            e.preventDefault();
            
            if (!SpeechRecognition) {
                alert("⚠ Trình duyệt của bạn không hỗ trợ tính năng Giọng nói! Hãy sử dụng Google Chrome hoặc Microsoft Edge.");
                return;
            }

            const recognition = new SpeechRecognition();
            recognition.lang = 'vi-VN';
            recognition.continuous = false;
            recognition.interimResults = false;

            recognition.onstart = () => {
                micBtn.classList.add('listening');
                searchInput.placeholder = 'Đang nghe...';
            };

            recognition.onspeechend = () => {
                recognition.stop();
                micBtn.classList.remove('listening');
                searchInput.placeholder = 'VD: Bái Đính, Ninh Bình...';
            };

            recognition.onresult = (event) => {
                let transcript = event.results[0][0].transcript;
                if(transcript.endsWith('.')) transcript = transcript.slice(0, -1);
                searchInput.value = transcript;
                if(typeof loadDestinations === 'function') loadDestinations(1);
            };

            recognition.onerror = (event) => {
                micBtn.classList.remove('listening');
                searchInput.placeholder = 'VD: Bái Đính, Ninh Bình...';
                if(event.error === 'not-allowed') {
                    alert('⚠ BẠN CHƯA CẤP QUYỀN MICRO!\n\nHãy nhìn lên thanh địa chỉ (chỗ chứa chữ localhost), bấm vào biểu tượng Ổ KHÓA hoặc CÀI ĐẶT TRANG, chọn "Cho phép Micro" rồi tải lại trang nhé!');
                } else if(event.error !== 'no-speech') {
                    alert('⚠ Lỗi micro: ' + event.error);
                }
            };

            try {
                recognition.start();
            } catch(err) {
                console.log('Đang nghe rồi...');
            }
        };
    }
});
</script>
<!-- END VOICE SEARCH MODULE -->
HTML;

    $content = str_replace('</body>', $newVoiceJS . "\n</body>", $content);
    file_put_contents($searchFile,$content);
    echo "=== DA FIX NUT MICRO KEM CHAN DOAN LOI! ===\n";
} else {
    echo "Khong tim thay file search.html\n";
}
?>
