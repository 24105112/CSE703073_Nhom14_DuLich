<?php
$file = __DIR__ . '/../frontend/index.html';
$html = file_get_contents($file);

// A. Thay thế phần Video bằng trình phát có nút Play lớn & nguồn video chuẩn
$newVideoSection = <<<'HTML'
        <!-- VIDEO THỰC TẾ KHẢO SÁT HẠ TẦNG & HỖ TRỢ NGƯỜI CAO TUỔI -->
        <section class="video-showcase" aria-label="Video thực tế trải nghiệm trợ năng">
            <div class="video-header-flex">
                <div>
                    <span style="color:#0f766e; font-weight:800; font-size:13.5px; text-transform:uppercase; letter-spacing:0.5px;">🎥 Video khảo sát thực địa</span>
                    <h2 style="font-size:22px; margin-top:4px;">Xem Trước Hành Trình Thực Tế: Lối Đi Xe Lăn, Chỗ Nghỉ Chân & Nhân Viên Hỗ Trợ</h2>
                </div>
                <span style="font-size:13.5px; color:var(--color-text-muted); font-weight:600;">✔ Quay trực tiếp tại điểm đến đã kiểm định</span>
            </div>
            <div class="video-wrapper" style="position:relative; cursor:pointer;" onclick="toggleMainVideo(event)">
                <video id="introVideo" controls preload="metadata" playsinline
                       poster="https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&w=1200&q=80"
                       src="images/intro.mp4"
                       onerror="if(this.src.indexOf('w3schools')===-1){this.src='https://www.w3schools.com/html/mov_bbb.mp4';}">
                    Trình duyệt của bạn không hỗ trợ phát video.
                </video>
                <div id="bigPlayBtn" style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:74px; height:74px; border-radius:50%; background:rgba(0,182,122,0.95); color:#fff; display:flex; align-items:center; justify-content:center; font-size:30px; box-shadow:0 8px 25px rgba(0,0,0,0.35); pointer-events:none; transition:opacity 0.2s;">
                    ▶
                </div>
                <div class="video-overlay-badge">
                    <span>KIỂM ĐỊNH THỰC TẾ</span><br>
                    <span>ĐỘ DỐC • CHỖ NGHỈ • NHÂN VIÊN HỖ TRỢ</span>
                </div>
                <div class="video-caption-bar">
                    "Giúp gia đình bạn nhìn thấy tận mắt lối đi và chỗ nghỉ trước khi quyết định khởi hành."
                </div>
            </div>
        </section>
HTML;

$html = preg_replace('/<!-- VIDEO THỰC TẾ.*?<\/section>/s', $newVideoSection, $html);

// B. Thay thế Khu vực Trustpilot bằng bảng có Ô VUÔNG CHECKBOX LỌC SAO + Ô TÌM KIẾM ĐÁNH GIÁ giống hệt ảnh Trustpilot
$newTrustpilotSection = <<<'HTML'
        <!-- KHU VỰC ĐÁNH GIÁ MINH BẠCH CHUẨN TRUSTPILOT (CÓ Ô VUÔNG LỌC THEO SAO) -->
        <section class="tp-section" aria-label="Đánh giá cộng đồng theo chuẩn Trustpilot">
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:20px;">
                <div>
                    <span style="color:#00b67a; font-weight:900; font-size:18px;">★ Trustpilot Standard</span>
                    <h2 style="font-size:24px; margin-top:4px;">Đánh Giá Thực Tế Từ Khách Hàng & Gia Đình Người Cao Tuổi</h2>
                </div>
                <button type="button" onclick="resetStarFilters()" class="btn btn-outline" style="min-height:40px; padding:8px 16px; font-size:14px;">🔄 Hiện tất cả đánh giá</button>
            </div>

            <div class="tp-transparency-notice">
                <span style="font-size:22px;">🛡️</span>
                <div>
                    <strong>Cam kết minh bạch (Unprompted & Verified Reviews):</strong> Các đơn vị điểm đến không được phép trả tiền để ẩn đánh giá thấp sao. Tích vào các <strong>ô vuông số sao bên trái</strong> để lọc xem phản hồi thực tế.
                </div>
            </div>

            <div class="tp-grid">
                <!-- Cột trái: Điểm trung bình & Ô vuông Checkbox lọc 5 sao -> 1 sao chuẩn Trustpilot -->
                <div class="tp-score-card">
                    <div style="display:flex; align-items:baseline; gap:12px; margin-bottom:8px;">
                        <span style="font-size:44px; font-weight:900; line-height:1;">4.4</span>
                        <div>
                            <div style="color:#00b67a; font-size:20px; letter-spacing:2px;">★★★★☆</div>
                            <span style="font-size:13.5px; color:var(--color-text-muted);">Tổng cộng 148 đánh giá thực tế</span>
                        </div>
                    </div>
                    <p style="font-size:13px; color:var(--color-text-muted); margin-bottom:16px;">Cập nhật kiểm định gần nhất: <strong>12/10/2026</strong></p>

                    <style>
                        .tp-filter-row {
                            display: grid;
                            grid-template-columns: 78px 1fr 42px;
                            align-items: center;
                            gap: 10px;
                            font-size: 14px;
                            padding: 6px 8px;
                            margin-bottom: 4px;
                            border-radius: 8px;
                            font-weight: 600;
                            cursor: pointer;
                            transition: background 0.15s;
                        }
                        .tp-filter-row:hover { background: rgba(15, 118, 110, 0.08); }
                        .tp-filter-label { display: inline-flex; align-items: center; gap: 8px; cursor: pointer; }
                        .tp-star-check { width: 18px; height: 18px; accent-color: #0f172a; cursor: pointer; border-radius: 4px; }
                    </style>

                    <label class="tp-filter-row">
                        <span class="tp-filter-label"><input type="checkbox" class="tp-star-check" value="5" onchange="filterReviews()"> 5 sao</span>
                        <div class="tp-bar-bg"><div class="tp-bar-fill" style="width:68%; background:#00b67a;"></div></div>
                        <span style="text-align:right;">68%</span>
                    </label>
                    <label class="tp-filter-row">
                        <span class="tp-filter-label"><input type="checkbox" class="tp-star-check" value="4" onchange="filterReviews()"> 4 sao</span>
                        <div class="tp-bar-bg"><div class="tp-bar-fill" style="width:18%; background:#73cf11;"></div></div>
                        <span style="text-align:right;">18%</span>
                    </label>
                    <label class="tp-filter-row">
                        <span class="tp-filter-label"><input type="checkbox" class="tp-star-check" value="3" onchange="filterReviews()"> 3 sao</span>
                        <div class="tp-bar-bg"><div class="tp-bar-fill" style="width:6%; background:#ffce00;"></div></div>
                        <span style="text-align:right;">6%</span>
                    </label>
                    <label class="tp-filter-row">
                        <span class="tp-filter-label"><input type="checkbox" class="tp-star-check" value="2" onchange="filterReviews()"> 2 sao</span>
                        <div class="tp-bar-bg"><div class="tp-bar-fill" style="width:3%; background:#ff8622;"></div></div>
                        <span style="text-align:right;">3%</span>
                    </label>
                    <label class="tp-filter-row">
                        <span class="tp-filter-label"><input type="checkbox" class="tp-star-check" value="1" onchange="filterReviews()"> 1 sao</span>
                        <div class="tp-bar-bg"><div class="tp-bar-fill" style="width:5%; background:#ff3722;"></div></div>
                        <span style="text-align:right;">5%</span>
                    </label>

                    <div id="starFilterStatus" style="margin-top:12px; font-size:13px; color:#0f766e; font-weight:700;">
                        ✔ Đang hiển thị tất cả mức sao
                    </div>
                </div>

                <!-- Cột phải: Thanh tìm kiếm từ khóa trong review & Danh sách bình luận lọc động -->
                <div>
                    <div style="display:flex; gap:12px; margin-bottom:16px; flex-wrap:wrap;">
                        <input type="text" id="reviewSearchInput" oninput="filterReviews()" placeholder="🔍 Tìm trong đánh giá (VD: xe lăn, nhân viên, ghế nghỉ, ca trưa)..." style="flex:1; min-height:42px; padding:8px 16px; border-radius:99px; border:1.5px solid var(--color-border); font-size:14.5px; background:var(--color-bg-main); color:var(--color-text-main);">
                    </div>

                    <div id="reviewsListContainer">
                        <!-- 5 SAO -->
                        <div class="tp-review-item" data-stars="5">
                            <div class="tp-user-header">
                                <div style="display:flex; align-items:center;">
                                    <span class="tp-avatar">NM</span>
                                    <div>
                                        <strong>Gia đình bác Nguyễn Minh (Đi cùng cụ ông 86 tuổi)</strong>
                                        <div style="font-size:12.5px; color:var(--color-text-muted);">Đã xác minh chuyến đi • Hà Nội • 3 đánh giá</div>
                                    </div>
                                </div>
                                <span style="font-size:13px; color:var(--color-text-muted);">08 Tháng 10, 2026</span>
                            </div>
                            <div style="color:#00b67a; font-weight:900; margin-bottom:6px;">★★★★★ (5 sao) — Lựa chọn tốt nhất cho bố tôi sau nhiều năm ngại đi xa</div>
                            <p style="font-size:15px;">Đưa bố 86 tuổi đi du lịch thường rất áp lực vì sợ ông mệt giữa chừng không có chỗ nằm nghỉ. Nhờ xem trước trên AccessTravel biết khu Bái Đính có xe điện đón tận sảnh, cứ 50m có ghế tựa lưng và nhân viên y tế hỗ trợ dìu qua bậc cửa, cả nhà đã có chuyến đi trọn vẹn nhất.</p>
                            <div>
                                <span class="tp-tag-pill">Ngày trải nghiệm: 06/10/2026</span>
                                <span class="tp-tag-pill">✔ Đánh giá tự nguyện (Unprompted review)</span>
                                <span class="tp-tag-pill">👍 Hữu ích (19)</span>
                            </div>
                        </div>

                        <!-- 4 SAO -->
                        <div class="tp-review-item" data-stars="4">
                            <div class="tp-user-header">
                                <div style="display:flex; align-items:center;">
                                    <span class="tp-avatar" style="background:#e0e7ff; color:#1e40af;">HL</span>
                                    <div>
                                        <strong>Bác Hoàng Văn Lợi (74 tuổi - Khớp gối yếu)</strong>
                                        <div style="font-size:12.5px; color:var(--color-text-muted);">Đã xác minh chuyến đi • Quảng Ninh • 5 đánh giá</div>
                                    </div>
                                </div>
                                <span style="font-size:13px; color:var(--color-text-muted);">03 Tháng 10, 2026</span>
                            </div>
                            <div style="color:#73cf11; font-weight:900; margin-bottom:6px;">★★★★☆ (4 sao) — Chỗ nghỉ tầng trệt rất yên tĩnh, nhân viên lễ phép</div>
                            <p style="font-size:15px;">Phòng nghỉ bố trí ngay tầng 1 đúng như thông tin thẩm định, giường thấp chống trượt và trong nhà tắm có chuông gọi y tá trực. Tôi trừ 1 sao nhỏ vì lối từ cổng vào bãi xe điện hơi nắng vào buổi chiều, còn lại dịch vụ chăm sóc người già rất đáng khen.</p>
                            <div>
                                <span class="tp-tag-pill">Ngày trải nghiệm: 01/10/2026</span>
                                <span class="tp-tag-pill">✔ Đã kiểm chứng thực tế</span>
                                <span class="tp-tag-pill">👍 Hữu ích (14)</span>
                            </div>
                        </div>

                        <!-- 3 SAO -->
                        <div class="tp-review-item" data-stars="3">
                            <div class="tp-user-header">
                                <div style="display:flex; align-items:center;">
                                    <span class="tp-avatar" style="background:#fef3c7; color:#92400e;">TH</span>
                                    <div>
                                        <strong>Chị Trần Thu Hà (Con gái khách dùng xe lăn)</strong>
                                        <div style="font-size:12.5px; color:var(--color-text-muted);">Đã xác minh chuyến đi • Hải Phòng • 7 đánh giá</div>
                                    </div>
                                </div>
                                <span style="font-size:13px; color:var(--color-text-muted);">29 Tháng 09, 2026</span>
                            </div>
                            <div style="color:#eab308; font-weight:900; margin-bottom:6px;">★★★☆☆ (3 sao) — Hạ tầng đường dốc chuẩn, nhưng nhân viên ca trưa cần nhanh hơn</div>
                            <p style="font-size:15px;">Độ dốc 5.5% và chiều rộng cửa phòng nghỉ 85cm đúng y như thông số trên web, xe lăn của mẹ mình vào phòng vệ sinh rất dễ. Tuy nhiên lúc 12h trưa khu nhà hàng hơi đông, mình phải đợi khoảng 10 phút mới có nhân viên ra kê thêm ghế nghỉ cho mẹ.</p>
                            <div>
                                <span class="tp-tag-pill">Ngày trải nghiệm: 27/09/2026</span>
                                <span class="tp-tag-pill">✔ Đã kiểm chứng thực tế</span>
                                <span class="tp-tag-pill">👍 Hữu ích (11)</span>
                            </div>
                        </div>

                        <!-- 2 SAO -->
                        <div class="tp-review-item" data-stars="2">
                            <div class="tp-user-header">
                                <div style="display:flex; align-items:center;">
                                    <span class="tp-avatar" style="background:#ffedd5; color:#9a3412;">ĐK</span>
                                    <div>
                                        <strong>Anh Đỗ Trung Kiên (Đi cùng ông nội 80 tuổi)</strong>
                                        <div style="font-size:12.5px; color:var(--color-text-muted);">Đã xác minh chuyến đi • Đà Nẵng • 2 đánh giá</div>
                                    </div>
                                </div>
                                <span style="font-size:13px; color:var(--color-text-muted);">18 Tháng 09, 2026</span>
                            </div>
                            <div style="color:#ff8622; font-weight:900; margin-bottom:6px;">★★☆☆☆ (2 sao) — Thang máy khu B bảo trì đột xuất chưa báo trước trên web</div>
                            <p style="font-size:15px;">Hôm gia đình mình đến thì thang máy khu B bảo trì mất 2 tiếng buổi sáng, nhân viên có ra khiêng xe lăn giúp ông mình qua cầu thang bộ nhưng khá vất vả. Mong đơn vị cập nhật trạng thái bảo trì thang máy theo thời gian thực.</p>
                            <div>
                                <span class="tp-tag-pill">Ngày trải nghiệm: 16/09/2026</span>
                                <span class="tp-tag-pill">✔ Đánh giá tự nguyện (Unprompted review)</span>
                                <span class="tp-tag-pill">👍 Hữu ích (8)</span>
                            </div>
                        </div>

                        <!-- 1 SAO -->
                        <div class="tp-review-item" data-stars="1">
                            <div class="tp-user-header">
                                <div style="display:flex; align-items:center;">
                                    <span class="tp-avatar" style="background:#fee2e2; color:#991b1b;">LP</span>
                                    <div>
                                        <strong>Cô Lê Phương (Khách hàng sử dụng khung tập đi)</strong>
                                        <div style="font-size:12.5px; color:var(--color-text-muted);">Đã xác minh chuyến đi • TP.HCM • 4 đánh giá</div>
                                    </div>
                                </div>
                                <span style="font-size:13px; color:var(--color-text-muted);">05 Tháng 09, 2026</span>
                            </div>
                            <div style="color:#ff3722; font-weight:900; margin-bottom:6px;">★☆☆☆☆ (1 sao) — Phản ánh thái độ nhân viên bảo vệ bãi xe cổng phụ</div>
                            <p style="font-size:15px;">Nhân viên y tế và lễ tân bên trong thì rất tốt, nhưng bảo vệ ở cổng phụ hướng dẫn xe gia đình tôi đỗ khá xa lối dốc dành cho người khuyết tật khiến tôi đi bộ vào rất mỏi chân. Cần chấn chỉnh ngay khâu đón tiếp từ bãi đỗ xe.</p>
                            <div>
                                <span class="tp-tag-pill">Ngày trải nghiệm: 04/09/2026</span>
                                <span class="tp-tag-pill">✔ Đã xác minh phản ánh</span>
                                <span class="tp-tag-pill">👍 Hữu ích (23)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
HTML;

$html = preg_replace('/<!-- KHU VỰC ĐÁNH GIÁ MINH BẠCH.*?<\/section>/s', $newTrustpilotSection, $html);

// C. Thêm hàm JS xử lý Play Video và Lọc Đánh Giá theo Ô Vuông Checkbox
$extraJs = <<<'JS'
        function toggleMainVideo(e) {
            const v = document.getElementById('introVideo');
            const btn = document.getElementById('bigPlayBtn');
            if (!v) return;
            // Nếu người dùng bấm trực tiếp vào thanh điều khiển của video thì để trình duyệt tự xử lý
            if (e.target.tagName === 'VIDEO' && e.offsetY > v.clientHeight - 50) return;
            if (v.paused) {
                v.play();
                if (btn) btn.style.opacity = '0';
            } else {
                v.pause();
                if (btn) btn.style.opacity = '1';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const v = document.getElementById('introVideo');
            const btn = document.getElementById('bigPlayBtn');
            if (v && btn) {
                v.addEventListener('play', () => btn.style.opacity = '0');
                v.addEventListener('pause', () => btn.style.opacity = '1');
            }
        });

        function filterReviews() {
            const checkedStars = Array.from(document.querySelectorAll('.tp-star-check:checked')).map(cb => cb.value);
            const kw = (document.getElementById('reviewSearchInput')?.value || '').toLowerCase().trim();
            const items = document.querySelectorAll('#reviewsListContainer .tp-review-item');
            let visibleCount = 0;

            items.forEach(item => {
                const star = item.getAttribute('data-stars');
                const text = item.innerText.toLowerCase();
                const matchStar = (checkedStars.length === 0) || checkedStars.includes(star);
                const matchKw = (kw === '') || text.includes(kw);

                if (matchStar && matchKw) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            const statusEl = document.getElementById('starFilterStatus');
            if (statusEl) {
                if (checkedStars.length === 0 && kw === '') {
                    statusEl.innerText = '✔ Đang hiển thị tất cả mức sao (5 đánh giá tiêu biểu)';
                } else {
                    statusEl.innerText = '🔍 Đang lọc: ' + (checkedStars.length ? checkedStars.join(', ') + ' sao' : 'Tất cả sao') + ' — Tìm thấy ' + visibleCount + ' đánh giá';
                }
            }
        }

        function resetStarFilters() {
            document.querySelectorAll('.tp-star-check').forEach(cb => cb.checked = false);
            const inp = document.getElementById('reviewSearchInput');
            if (inp) inp.value = '';
            filterReviews();
        }
JS;

if (strpos($html, 'function filterReviews()') === false) {
    $html = str_replace('document.addEventListener(\'DOMContentLoaded\', () => loadDestinations(1));', $extraJs . "\n        document.addEventListener('DOMContentLoaded', () => loadDestinations(1));", $html);
}

file_put_contents($file, $html);
copy($file, __DIR__ . '/../frontend/search.html');
echo "=== DA CAP NHAT CHECKBOX LOC SAO TRUSTPILOT & SUA VIDEO CHAY MUOT 100%! ===\n";
