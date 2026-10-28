/**
 * ACCESSTRAVEL ACCESSIBILITY WIDGET (WCAG 2.1 AA)
 * Tự động chèn nút tròn trợ năng nổi góc dưới phải, bảng tùy chỉnh cỡ chữ,
 * đọc toàn trang / đọc đoạn bôi đen, chế độ tương phản & lưu localStorage.
 */
(function() {
    // 1. TỰ ĐỘNG BỎ QUA NẾU LÀ TRANG QUẢN TRỊ (ADMIN)
    const currentPath = window.location.pathname.toLowerCase();
    if (currentPath.includes('admin') || currentPath.includes('dashboard')) {
        return; // Không chạy trên trang admin
    }

    // 2. NHÚNG CSS TỰ ĐỘNG CHO TOÀN BỘ WIDGET
    const style = document.createElement('style');
    style.id = 'a11y-widget-styles';
    style.textContent = `
        /* Nút nổi góc dưới bên phải */
        #a11y-floating-trigger {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #0f766e;
            color: #ffffff;
            border: 2px solid #ffffff;
            box-shadow: 0 4px 16px rgba(0,0,0,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 999999;
            transition: all 0.25s ease;
            outline: none;
        }
        #a11y-floating-trigger:hover {
            transform: scale(1.08);
            background: #0d9488;
            box-shadow: 0 6px 20px rgba(15,118,110,0.4);
        }
        #a11y-floating-trigger i {
            font-size: 26px;
        }

        /* Thanh mini tool khi bôi đen chữ */
        #a11y-selection-tooltip {
            position: absolute;
            display: none;
            background: #0f172a;
            color: #ffffff;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 800;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
            z-index: 9999999;
            cursor: pointer;
            align-items: center;
            gap: 6px;
            transform: translateY(-100%);
            border: 1px solid #334155;
        }
        #a11y-selection-tooltip:hover {
            background: #0f766e;
        }

        /* Bảng điều khiển trợ năng Modal / Popup */
        #a11y-modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(2px);
            z-index: 9999998;
        }
        #a11y-panel {
            display: none;
            position: fixed;
            bottom: 95px;
            right: 24px;
            width: 380px;
            max-width: calc(100vw - 32px);
            max-height: calc(100vh - 120px);
            background: #000000;
            color: #ffffff;
            border: 1px solid #27272a;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
            z-index: 9999999;
            overflow-y: auto;
            font-family: 'Be Vietnam Pro', system-ui, sans-serif;
            box-sizing: border-box;
        }
        #a11y-panel * {
            box-sizing: border-box;
        }
        .a11y-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            border-bottom: 1px solid #27272a;
            padding-bottom: 14px;
        }
        .a11y-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .a11y-icon-badge {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #0f766e;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 20px;
        }
        .a11y-close-btn {
            background: none;
            border: none;
            color: #a1a1aa;
            font-size: 20px;
            cursor: pointer;
            padding: 4px;
        }
        .a11y-close-btn:hover { color: #fff; }

        .a11y-section-title {
            font-size: 14px;
            font-weight: 800;
            color: #e4e4e7;
            margin: 16px 0 10px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Bộ nút cỡ chữ */
        .a11y-font-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #18181b;
            border: 1px solid #27272a;
            border-radius: 12px;
            padding: 10px 16px;
        }
        .a11y-btn-round {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #27272a;
            border: 1px solid #3f3f46;
            color: #fff;
            font-weight: 900;
            font-size: 15px;
            cursor: pointer;
            transition: 0.2s;
        }
        .a11y-btn-round:hover { background: #0f766e; border-color: #0f766e; }

        /* Nút hành động đọc */
        .a11y-action-btn {
            width: 100%;
            background: #ffffff;
            color: #09090b;
            border: none;
            padding: 12px 16px;
            border-radius: 10px;
            font-weight: 800;
            font-size: 14px;
            margin-bottom: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: 0.2s;
        }
        .a11y-action-btn:hover { background: #e4e4e7; }
        .a11y-action-btn.secondary {
            background: transparent;
            color: #ffffff;
            border: 1px solid #3f3f46;
        }
        .a11y-action-btn.secondary:hover { background: #18181b; border-color: #71717a; }

        /* Tùy chọn Radio hiển thị */
        .a11y-radio-label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            margin-bottom: 10px;
            cursor: pointer;
            color: #d4d4d8;
        }
        .a11y-radio-label input {
            accent-color: #0f766e;
            width: 17px;
            height: 17px;
        }

        /* Khung xem trước */
        .a11y-preview-box {
            background: #ffffff;
            color: #000000;
            border-radius: 12px;
            padding: 14px;
            margin-top: 14px;
            font-size: 13.5px;
            line-height: 1.5;
        }

        /* Các class toàn cục kích hoạt trên thẻ html */
        html.a11y-high-contrast {
            filter: contrast(140%) !important;
        }
        html.a11y-line-height * {
            line-height: 2.0 !important;
            letter-spacing: 0.6px !important;
        }
        html.a11y-reading-active {
            outline: 3px solid #0f766e !important;
        }
    `;
    document.head.appendChild(style);

    // 3. VẼ HTML NÚT NỔI & BẢNG ĐIỀU KHIỂN VÀO TRANG
    const widgetContainer = document.createElement('div');
    widgetContainer.id = 'a11y-global-root';
    widgetContainer.innerHTML = `
        <!-- NÚT NỔI CỐ ĐỊNH -->
        <button id="a11y-floating-trigger" title="Hỗ trợ tiếp cận & Đọc văn bản" aria-label="Hỗ trợ tiếp cận">
            <i class="fa-solid fa-universal-access"></i>
        </button>

        <!-- TOOLTIP KHI BÔI ĐEN -->
        <div id="a11y-selection-tooltip">
            <i class="fa-solid fa-volume-high"></i> Đọc đoạn này
        </div>

        <!-- BACKDROP CHO MOBILE -->
        <div id="a11y-modal-backdrop"></div>

        <!-- BẢNG ĐIỀU KHIỂN TIẾP CẬN -->
        <div id="a11y-panel" role="dialog" aria-modal="true">
            <div class="a11y-header">
                <div class="a11y-header-left">
                    <div class="a11y-icon-badge">
                        <i class="fa-solid fa-universal-access"></i>
                    </div>
                    <div>
                        <div style="font-weight:900; font-size:16px;">Hỗ trợ tiếp cận</div>
                        <div style="font-size:12px; color:#a1a1aa;">Tùy chỉnh trải nghiệm đọc của bạn</div>
                    </div>
                </div>
                <button class="a11y-close-btn" id="a11y-close-btn">&times;</button>
            </div>

            <!-- CỠ CHỮ -->
            <div class="a11y-section-title">Cỡ chữ</div>
            <div class="a11y-font-box">
                <button class="a11y-btn-round" id="a11y-font-dec" title="Giảm cỡ chữ">A-</button>
                <div style="text-align:center;">
                    <strong id="a11y-font-val" style="font-size:16px; color:#fff;">16px</strong>
                    <div style="font-size:11px; color:#a1a1aa;">Kích thước chữ</div>
                </div>
                <button class="a11y-btn-round" id="a11y-font-inc" title="Tăng cỡ chữ">A+</button>
            </div>

            <!-- ĐỌC VĂN BẢN -->
            <div class="a11y-section-title">Đọc văn bản</div>
            <button class="a11y-action-btn" id="a11y-read-page">
                <i class="fa-solid fa-volume-high"></i> <span id="a11y-read-label">Đọc nội dung trang</span>
            </button>
            <button class="a11y-action-btn secondary" id="a11y-read-selected">
                <i class="fa-solid fa-crop-simple"></i> Đọc đoạn văn được chọn
            </button>

            <!-- HIỂN THỊ DỄ ĐỌC -->
            <div class="a11y-section-title">Hiển thị dễ đọc</div>
            <label class="a11y-radio-label">
                <input type="radio" name="a11y_theme_mode" value="default" checked>
                <span>Mặc định</span>
            </label>
            <label class="a11y-radio-label">
                <input type="radio" name="a11y_theme_mode" value="contrast">
                <span>Tương phản cao</span>
            </label>
            <label class="a11y-radio-label">
                <input type="radio" name="a11y_theme_mode" value="dark">
                <span>Nền tối, chữ sáng</span>
            </label>
            <label class="a11y-radio-label">
                <input type="checkbox" id="a11y_line_height">
                <span>Tăng khoảng cách dòng</span>
            </label>

            <!-- XEM TRƯỚC -->
            <div class="a11y-preview-box">
                <strong style="display:block; margin-bottom:4px; color:#0f172a;">Xem trước nội dung</strong>
                Du lịch tiếp cận dành cho tất cả mọi người.<br>
                Điều chỉnh chữ và cách hiển thị theo nhu cầu của bạn.
            </div>

            <!-- ĐẶT LẠI MẶC ĐỊNH -->
            <button class="a11y-action-btn secondary" id="a11y-reset-all" style="margin-top:16px; width:100%;">
                <i class="fa-solid fa-rotate-left"></i> Đặt lại mặc định
            </button>
        </div>
    `;

    function initWidget() {
        document.body.appendChild(widgetContainer);

        const trigger = document.getElementById('a11y-floating-trigger');
        const panel = document.getElementById('a11y-panel');
        const backdrop = document.getElementById('a11y-modal-backdrop');
        const closeBtn = document.getElementById('a11y-close-btn');
        const fontInc = document.getElementById('a11y-font-inc');
        const fontDec = document.getElementById('a11y-font-dec');
        const fontVal = document.getElementById('a11y-font-val');
        const readPageBtn = document.getElementById('a11y-read-page');
        const readSelectedBtn = document.getElementById('a11y-read-selected');
        const readLabel = document.getElementById('a11y-read-label');
        const tooltip = document.getElementById('a11y-selection-tooltip');
        const resetBtn = document.getElementById('a11y-reset-all');
        const lineHeightCheck = document.getElementById('a11y_line_height');
        const themeRadios = document.querySelectorAll('input[name="a11y_theme_mode"]');

        let isSpeaking = false;
        let selectedTextToRead = '';

        // Đóng mở bảng điều khiển
        function togglePanel(open) {
            const show = (open !== undefined) ? open : (panel.style.display !== 'block');
            panel.style.display = show ? 'block' : 'none';
            backdrop.style.display = (show && window.innerWidth < 768) ? 'block' : 'none';
        }

        trigger.addEventListener('click', () => togglePanel());
        closeBtn.addEventListener('click', () => togglePanel(false));
        backdrop.addEventListener('click', () => togglePanel(false));

        // 4. QUẢN LÝ CỠ CHỮ
       // 4. QUẢN LÝ CỠ CHỮ TOÀN DIỆN (ÉP TO TRÊN MỌI THẺ)
        let currentSize = parseInt(localStorage.getItem('a11y_fontSize') || '16');
        
        function applyFontSize(size) {
            currentSize = Math.max(14, Math.min(26, size));
            fontVal.textContent = currentSize + 'px';
            localStorage.setItem('a11y_fontSize', currentSize);

            // Tính tỷ lệ phóng đại so với chuẩn 16px (từ 0.875 đến 1.625)
            const scale = currentSize / 16;

            // Xóa thẻ style cũ nếu có
            let fontStyleTag = document.getElementById('a11y-dynamic-fontsize');
            if (!fontStyleTag) {
                fontStyleTag = document.createElement('style');
                fontStyleTag.id = 'a11y-dynamic-fontsize';
                document.head.appendChild(fontStyleTag);
            }

            // Ép độ to theo tỷ lệ cho mọi thẻ chữ (trừ bảng panel của widget để không bị vỡ)
            fontStyleTag.textContent = `
                body:not(#a11y-panel):not(#a11y-panel *) {
                    font-size: ${15 * scale}px !important;
                }
                body *:not(#a11y-panel):not(#a11y-panel *):not(i):not(.fa):not(.fa-solid):not(.fa-brands) {
                    font-size: inherit;
                }
                body h1:not(#a11y-panel *) { font-size: ${32 * scale}px !important; }
                body h2:not(#a11y-panel *) { font-size: ${24 * scale}px !important; }
                body h3:not(#a11y-panel *) { font-size: ${18 * scale}px !important; }
                body p:not(#a11y-panel *), 
                body span:not(#a11y-panel *):not(.badge):not(.badge-verified-mini),
                body li:not(#a11y-panel *),
                body a:not(#a11y-panel *),
                body label:not(#a11y-panel *) {
                    font-size: ${15 * scale}px !important;
                }
            `;
        }
        applyFontSize(currentSize);

        fontInc.addEventListener('click', () => applyFontSize(currentSize + 2));
        fontDec.addEventListener('click', () => applyFontSize(currentSize - 2));

        // 5. GIỌNG NÓI WEB SPEECH API (ĐỌC NỘI DUNG)
        function speak(text) {
            if (!('speechSynthesis' in window)) {
                alert('Trình duyệt của bạn không hỗ trợ đọc văn bản tự động.');
                return;
            }
            window.speechSynthesis.cancel();
            if (!text || text.trim() === '') return;

            const utterance = new SpeechSynthesisUtterance(text.trim());
            utterance.lang = 'vi-VN';
            utterance.rate = 0.95;

            utterance.onstart = () => {
                isSpeaking = true;
                readLabel.textContent = 'Dừng đọc văn bản';
                readPageBtn.style.background = '#ef4444';
                readPageBtn.style.color = '#ffffff';
                trigger.style.background = '#ef4444';
            };

            utterance.onend = utterance.onerror = () => {
                isSpeaking = false;
                readLabel.textContent = 'Đọc nội dung trang';
                readPageBtn.style.background = '#ffffff';
                readPageBtn.style.color = '#09090b';
                trigger.style.background = '#0f766e';
            };

            window.speechSynthesis.speak(utterance);
        }

        function stopSpeaking() {
            window.speechSynthesis.cancel();
            isSpeaking = false;
            readLabel.textContent = 'Đọc nội dung trang';
            readPageBtn.style.background = '#ffffff';
            readPageBtn.style.color = '#09090b';
            trigger.style.background = '#0f766e';
        }

        readPageBtn.addEventListener('click', () => {
            if (isSpeaking) {
                stopSpeaking();
            } else {
                // Lấy các khối nội dung chính, bỏ qua header/nav/footer để tránh đọc rác
                const mainArea = document.querySelector('main') || document.querySelector('.container') || document.body;
                speak(mainArea.innerText);
            }
        });

        readSelectedBtn.addEventListener('click', () => {
            const sel = window.getSelection().toString();
            if (sel && sel.trim().length > 0) {
                speak(sel);
            } else {
                alert('Vui lòng dùng chuột hoặc ngón tay bôi đen một đoạn văn bản trên trang trước.');
            }
        });

        // 6. TÍNH NĂNG BÔI ĐEN CHỮ HIỆN NÚT ĐỌC NGAY
        document.addEventListener('mouseup', (e) => {
            setTimeout(() => {
                const sel = window.getSelection();
                const text = sel.toString().trim();
                if (text.length > 2 && !panel.contains(e.target)) {
                    selectedTextToRead = text;
                    const range = sel.getRangeAt(0);
                    const rect = range.getBoundingClientRect();
                    tooltip.style.left = (rect.left + window.scrollX) + 'px';
                    tooltip.style.top = (rect.top + window.scrollY - 10) + 'px';
                    tooltip.style.display = 'flex';
                } else {
                    tooltip.style.display = 'none';
                }
            }, 10);
        });

        tooltip.addEventListener('click', () => {
            if (selectedTextToRead) {
                speak(selectedTextToRead);
                tooltip.style.display = 'none';
            }
        });

        // 7. CHẾ ĐỘ HIỂN THỊ DỄ ĐỌC
        function applyDisplaySettings() {
            const savedThemeMode = localStorage.getItem('a11y_theme_mode') || 'default';
            const savedLineHeight = localStorage.getItem('a11y_line_height') === 'true';

            document.documentElement.classList.toggle('a11y-high-contrast', savedThemeMode === 'contrast');
            document.documentElement.classList.toggle('a11y-line-height', savedLineHeight);

            if (savedThemeMode === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
            } else if (savedThemeMode === 'default') {
                const currentSystemTheme = localStorage.getItem('accessTravelTheme') || 'light';
                document.documentElement.setAttribute('data-theme', currentSystemTheme);
            }

            // Đồng bộ UI radio
            themeRadios.forEach(r => {
                if (r.value === savedThemeMode) r.checked = true;
            });
            lineHeightCheck.checked = savedLineHeight;
        }

        themeRadios.forEach(r => {
            r.addEventListener('change', () => {
                localStorage.setItem('a11y_theme_mode', r.value);
                applyDisplaySettings();
            });
        });

        lineHeightCheck.addEventListener('change', () => {
            localStorage.setItem('a11y_line_height', lineHeightCheck.checked);
            applyDisplaySettings();
        });

        // Đặt lại mặc định
        resetBtn.addEventListener('click', () => {
            stopSpeaking();
            localStorage.removeItem('a11y_fontSize');
            localStorage.removeItem('a11y_theme_mode');
            localStorage.removeItem('a11y_line_height');
            applyFontSize(16);
            applyDisplaySettings();
            alert('Đã thiết lập lại cài đặt hỗ trợ tiếp cận mặc định.');
        });

        applyDisplaySettings();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initWidget);
    } else {
        initWidget();
    }
})();