<?php
$searchFile = __DIR__ . '/frontend/search.html';

if (file_exists($searchFile)) {
    $content = file_get_contents($searchFile);

    $voiceSearchJS = <<<'HTML'
<!-- VOICE SEARCH MODULE -->
<style>
    .mic-btn {
        background: #10b981; color: #fff; border: none; border-radius: 50%;
        width: 44px; height: 44px; display: inline-flex; align-items: center; justify-content: center;
        cursor: pointer; transition: 0.3s; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
        margin-left: 8px; font-size: 18px; flex-shrink: 0;
    }
    .mic-btn:hover { background: #059669; transform: scale(1.1); }
    
    /* Hiệu ứng nhấp nháy khi đang ghi âm */
    .mic-btn.recording {
        background: #ef4444; animation: pulse-red 1.5s infinite;
    }
    @keyframes pulse-red {
        0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
        70% { box-shadow: 0 0 0 12px rgba(239, 68, 68, 0); }
        100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }
    
    /* Popup thông báo đang nghe */
    #voice-status {
        position: fixed; top: 30px; left: 50%; transform: translateX(-50%);
        background: rgba(15, 23, 42, 0.9); color: #fff; padding: 12px 24px;
        border-radius: 30px; font-weight: 700; z-index: 100000;
        display: none; align-items: center; gap: 12px; font-size: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2); backdrop-filter: blur(5px);
    }
</style>

<!-- Thông báo bay từ trên xuống khi bấm mic -->
<div id="voice-status"><i class="fa fa-microphone fa-spin" style="color:#34d399;"></i> <span>Đang nghe... Hãy nói tên địa điểm hoặc khu vực (VD: "Huế")</span></div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Tìm ô nhập liệu của form tìm kiếm
    const searchInput = document.getElementById('keywordInput');
    
    if (searchInput && !document.getElementById('btn-voice-search')) {
        // Căn chỉnh lại bố cục để nhét nút Mic vào cho đẹp
        const parentDiv = searchInput.parentNode;
        parentDiv.style.display = 'flex';
        parentDiv.style.alignItems = 'center';
        
        const micBtn = document.createElement('button');
        micBtn.id = 'btn-voice-search';
        micBtn.className = 'mic-btn';
        micBtn.innerHTML = '<i class="fa fa-microphone"></i>';
        micBtn.title = 'Tìm kiếm bằng giọng nói';
        
        // Chèn nút mic ngay sau ô nhập liệu
        parentDiv.insertBefore(micBtn, searchInput.nextSibling);
        
        // Khởi tạo Web Speech API
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        if (SpeechRecognition) {
            const recognition = new SpeechRecognition();
            recognition.lang = 'vi-VN'; // Setup chuẩn giọng tiếng Việt
            recognition.continuous = false;
            recognition.interimResults = false;

            micBtn.onclick = (e) => {
                e.preventDefault();
                recognition.start();
            };

            recognition.onstart = function() {
                micBtn.classList.add('recording');
                document.getElementById('voice-status').style.display = 'flex';
                searchInput.placeholder = 'Đang nghe...';
            };

            recognition.onspeechend = function() {
                recognition.stop();
                micBtn.classList.remove('recording');
                document.getElementById('voice-status').style.display = 'none';
                searchInput.placeholder = 'Nhập tên tour, địa điểm...';
            };

            recognition.onresult = function(event) {
                // Lấy kết quả chữ từ giọng nói
                let transcript = event.results[0][0].transcript;
                // Xóa dấu chấm câu thừa ở cuối nếu có
                if(transcript.endsWith('.')) transcript = transcript.slice(0, -1);
                
                searchInput.value = transcript;
                
                // Tự động kích hoạt hàm tìm kiếm (hàm loadDestinations anh em mình viết hôm trước)
                if(typeof loadDestinations === 'function') {
                    loadDestinations(1);
                }
            };

            recognition.onerror = function(event) {
                micBtn.classList.remove('recording');
                document.getElementById('voice-status').style.display = 'none';
                searchInput.placeholder = 'Nhập tên tour, địa điểm...';
                
                if(event.error === 'not-allowed') {
                    alert('Trình duyệt chưa được cấp quyền sử dụng Micro. Vui lòng cho phép!');
                }
            };
        } else {
            // Giấu nút nếu trình duyệt quá cũ không hỗ trợ AI giọng nói
            micBtn.style.display = 'none';
            console.log('Trình duyệt không hỗ trợ Web Speech API');
        }
    }
});
</script>
<!-- END VOICE SEARCH MODULE -->
HTML;

    // Xóa bản cũ nếu chạy lại lệnh
    $content = preg_replace('/<!-- VOICE SEARCH MODULE -->.*?<!-- END VOICE SEARCH MODULE -->/is', '', $content);
    
    // Cấy code xuống cuối trang
    $content = str_replace('</body>', $voiceSearchJS . "\n</body>", $content);
    
    file_put_contents($searchFile, $content);
    echo "=== DA CAY CHUC NANG TIM KIEM BANG GIONG NOI VAO SEARCH.HTML ===\n";
} else {
    echo "Khong tim thay file search.html\n";
}
?>
