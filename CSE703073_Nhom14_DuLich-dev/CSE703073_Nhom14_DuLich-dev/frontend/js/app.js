// Hệ thống Đa ngôn ngữ (VI / EN) toàn diện 100% cho AccessTravel
function getCurrentUser() {
    try {
        const raw = localStorage.getItem('at_user');
        return raw ? JSON.parse(raw) : null;
    } catch (e) { return null; }
}

function applySavedTheme() {
    const saved = localStorage.getItem('at_theme') || 'default';
    if (saved === 'accessible') {
        document.documentElement.setAttribute('data-theme', 'accessible');
    } else {
        document.documentElement.removeAttribute('data-theme');
    }
}

function toggleAccessibilityTheme() {
    const current = document.documentElement.getAttribute('data-theme');
    if (current === 'accessible') {
        document.documentElement.removeAttribute('data-theme');
        localStorage.setItem('at_theme', 'default');
    } else {
        document.documentElement.setAttribute('data-theme', 'accessible');
        localStorage.setItem('at_theme', 'accessible');
    }
}

function getLang() {
    return localStorage.getItem('at_lang') || 'vi';
}

// Bảng đối chiếu câu chữ Việt <-> Anh trên toàn bộ các phần tử tĩnh và động
const EXACT_PAIRS = [
    ["Khám phá điểm đến", "Explore Destinations"],
    ["Đánh giá cộng đồng", "Verified Reviews"],
    ["Kiểm tra & Đặt lịch", "Check & Book Slot"],
    ["← Quay lại Khám phá điểm đến", "← Back to Explore Destinations"],
    ["🎧 Hỗ trợ", "🎧 Support & Guide"],
    ["Aa Chế độ Chữ lớn", "Aa Large Text Mode"],
    ["Aa Chế độ Chữ lớn (Trợ năng)", "Aa Large Text Mode"],
    ["Đăng nhập", "Log in"],
    ["Đăng ký", "Sign up"],
    ["Đăng xuất", "Log out"],
    ["✔ Dữ liệu khảo sát thực địa • Cập nhật Tháng 10/2026", "✔ Field-Verified Data • Updated Oct 2026"],
    ["Biết Trước Chuyến Đi Có Thực Sự Phù Hợp Với Cơ Thể & Sức Khỏe Của Bạn", "Know Before You Go: Trips Tailored to Your Body & Mobility Needs"],
    ["Không chỉ là đặt chỗ — chúng tôi minh bạch hóa mức độ hỗ trợ người cao tuổi, khoảng cách ghế nghỉ chân, thái độ nhân viên hỗ trợ và đánh giá thực tế từ những gia đình đã trải nghiệm.", "More than booking — we verify senior care support, rest bench distances, trained staff availability, and real unprompted reviews from families."],
    ["🩺 Bước 1: Chọn thể trạng của người đi cùng bạn (Hệ thống sẽ ưu tiên hiển thị thông tin phù hợp):", "🩺 Step 1: Select your companion's mobility profile (Prioritized matching):"],
    ["Đang ưu tiên: Người cao tuổi cần ghế nghỉ & nhân viên hỗ trợ", "Prioritizing: Seniors needing rest benches & staff assistance"],
    ["Đang ưu tiên: Người cao tuổi cần ghế nghỉ chân, thang máy & nhân viên hỗ trợ", "Prioritizing: Seniors needing rest benches, elevators & staff support"],
    ["Đang ưu tiên: Người dùng xe lăn (Dốc ≤ 6%, lối đi xe lăn & thang máy rộng)", "Prioritizing: Wheelchair users (Slope ≤ 6%, ramps & wide elevators)"],
    ["Đang ưu tiên: Chỗ nghỉ tầng trệt yên tĩnh & nhân viên y tế túc trực", "Prioritizing: Quiet ground-floor rooms & 24/7 medical standby"],
    ["Đang hiển thị tất cả điểm đến trong CSDL", "Showing all verified destinations in database"],
    ["👴 Người cao tuổi (Dễ mỏi gối, cần chỗ nghỉ & nhân viên dìu)", "👴 Seniors (Easy knee fatigue, needs rest benches & staff support)"],
    ["🦽 Người dùng xe lăn (Cần dốc ≤ 6%, cửa ≥ 80cm, thang máy)", "🦽 Wheelchair Users (Slope ≤ 6%, door ≥ 80cm, elevator)"],
    ["🛌 Cần không gian yên tĩnh, phòng tầng trệt & y tế gần", "🛌 Quiet Space, Ground-Floor Room & Nearby Medical Care"],
    ["🔄 Xem tất cả tiêu chuẩn", "🔄 View All Standards"],
    ["Tìm theo Tên địa điểm hoặc Tỉnh/Thành phố", "Search by Destination Name or Province/City"],
    ["Độ thoải đường dốc (Phù hợp sức chân)", "Ramp Slope Comfort (Leg Strength Fit)"],
    ["Tất cả độ dốc đã kiểm định", "All Verified Ramp Slopes"],
    ["Đi bộ nhẹ / Người cao tuổi (≤ 8%)", "Gentle Walk / Seniors (≤ 8%)"],
    ["Siêu thoải cho Xe lăn tự đẩy (≤ 6%)", "Ultra-Gentle for Manual Wheelchair (≤ 6%)"],
    ["Sắp xếp phía Máy chủ (Server Sort)", "Server-Side Sorting"],
    ["Độ phù hợp thể trạng cao nhất", "Highest Body-Fit Match"],
    ["🔥 Sắp hết suất hỗ trợ (1 chỗ cuối lên đầu)", "🔥 Almost Full (Last 1 Slot First)"],
    ["💰 Chi phí thấp đến cao", "💰 Price: Low to High"],
    ["💎 Dịch vụ cao cấp trước", "💎 Premium Care First"],
    ["🔍 Lọc kết quả", "🔍 Filter Results"],
    ["♿ Có lối đi Xe lăn xuyên suốt", "♿ Full Wheelchair Ramp Access"],
    ["🛗 Có Thang máy / Xe điện nội khu", "🛗 Elevator / Internal Electric Buggy"],
    ["🚻 Nhà vệ sinh có tay vịn chống trượt", "🚻 Accessible Restroom with Grab Bars"],
    ["🎥 Video khảo sát thực địa", "🎥 Field Inspection Video"],
    ["Xem Trước Hành Trình Thực Tế: Lối Đi Xe Lăn, Chỗ Nghỉ Chân & Nhân Viên Hỗ Trợ", "Preview Real Journey: Wheelchair Ramps, Rest Benches & Care Staff"],
    ["✔ Quay trực tiếp tại điểm đến đã kiểm định", "✔ Filmed on-site at verified destinations"],
    ["KIỂM ĐỊNH THỰC TẾ", "FIELD VERIFIED"],
    ["ĐỘ DỐC • CHỖ NGHỈ • NHÂN VIÊN HỖ TRỢ", "RAMP SLOPE • REST ZONES • SUPPORT STAFF"],
    ["\"Giúp gia đình bạn nhìn thấy tận mắt lối đi và chỗ nghỉ trước khi quyết định khởi hành.\"", "\"Helping your family see the actual pathways and rest areas before you depart.\""],
    ["Điểm Đến Đã Kiểm Định Mức Độ Hỗ Trợ Thể Trạng", "Destinations Verified for Mobility & Senior Comfort"],
    ["Mọi thẻ đều hiển thị rõ: Hỗ trợ người cao tuổi, Chỗ nghỉ chân, Nhân viên, Ngày đo đạc và Đánh giá thật.", "Every card clearly shows: Senior support, Rest areas, Staff availability, Verification date & Real reviews."],
    ["Đánh Giá Thực Tế Từ Khách Hàng & Gia Đình Người Cao Tuổi", "Real Unprompted Reviews from Seniors & Families"],
    ["🔄 Hiện tất cả đánh giá", "🔄 Show All Reviews"],
    ["Tổng cộng 148 đánh giá thực tế", "Total 148 verified reviews"],
    ["5 sao", "5-star"],
    ["4 sao", "4-star"],
    ["3 sao", "3-star"],
    ["2 sao", "2-star"],
    ["1 sao", "1-star"],
    ["✔ Đang hiển thị tất cả mức sao", "✔ Showing all star ratings"],
    ["✔ Đang hiển thị tất cả mức sao (5 đánh giá tiêu biểu)", "✔ Showing all star ratings (5 featured reviews)"]
];

// Bảng dịch các cụm từ nằm bên trong thẻ địa điểm động (render từ MySQL)
const DYNAMIC_REPLACEMENTS_VI_TO_EN = [
    ["✔ Đã xác minh tại chỗ", "✔ Verified On-Site"],
    ["✔ Được cơ sở cung cấp thông tin", "✔ Provided by Facility"],
    ["✔ Chưa xác minh (Cần gọi trước)", "✔ Unverified (Call Ahead)"],
    ["🔥 Chỉ còn 1 suất cuối!", "🔥 Only 1 slot left!"],
    ["Đã kín chỗ (0 suất)", "Sold Out (0 slots)"],
    ["🔄 Cập nhật:", "🔄 Updated:"],
    ["Hỗ trợ người cao tuổi:", "Senior Support:"],
    ["Chỗ nghỉ chân:", "Rest Areas:"],
    ["Nhân viên hỗ trợ:", "Support Staff:"],
    ["Có ghế nghỉ mỗi 50m & Xe điện nội khu", "Rest benches every 50m & Electric buggy"],
    ["Cao (Có ghế nghỉ mỗi 50m & Xe điện nội khu)", "High (Rest benches every 50m & Electric buggy)"],
    ["Rất cao (Phòng tầng trệt & Chăm sóc y tế 24/7)", "Very High (Ground-floor room & 24/7 medical care)"],
    ["Tiêu chuẩn (Đường bằng phẳng, ít bậc thang)", "Standard (Flat pathways, minimal steps)"],
    ["Chuyên biệt (Hỗ trợ toàn diện người cao tuổi & xe lăn)", "Specialized (Full senior & wheelchair assistance)"],
    ["Khu nghỉ chân có mái che, nước ấm & ghế tựa lưng", "Covered rest area, warm water & backrest benches"],
    ["Phòng nghỉ yên tĩnh cách âm, giường thấp chống ngã", "Soundproof quiet room, low anti-fall bed"],
    ["Trạm dừng chân oxy & ghế massage thư giãn nhẹ", "Oxygen rest station & gentle massage chairs"],
    ["Sảnh chờ điều hòa, sofa cao dễ đứng lên ngồi xuống", "A/C lounge, elevated sofa for easy standing"],
    ["Nhân viên đào tạo sơ cứu & dìu khách 1-1", "First-aid trained staff & 1-on-1 walking support"],
    ["Đội ngũ hỗ trợ tại sảnh & đẩy xe lăn miễn phí", "Lobby assistance team & free wheelchair pushing"],
    ["Nhân viên trực chuông gọi khẩn cấp tại phòng nghỉ", "24/7 emergency call-bell staff on duty"],
    ["Hướng dẫn viên am hiểu tâm lý & nhịp độ người già", "Guides trained in senior pacing & care"],
    ["Lưu ý thực tế:", "Field Note:"],
    ["Hạn chế nhỏ: Lối vào cổng phụ có 2 bậc tam cấp, xe lăn nên đi cổng chính phía Đông.", "Minor note: Side gate has 2 steps; wheelchair users should use the East main gate."],
    ["Lưu ý: Thang máy khu B bảo trì từ 12h-13h thứ Hai hàng tuần, có nhân viên hỗ trợ lối phụ.", "Note: Block B elevator under maintenance Mon 12-1PM; staff assist via secondary ramp."],
    ["Chưa xác minh độ rộng cửa phòng tắm ở khu nhà cổ, nên yêu cầu phòng tầng 1 khu mới.", "Bathroom door width in heritage wing unverified; request a 1st-floor room in the new wing."],
    ["Hạn chế nhỏ: Quãng đường từ bãi xe vào sảnh dài 80m, người cao tuổi nên đăng ký xe điện đón.", "Minor note: Parking to lobby is 80m; seniors should request the free electric buggy pickup."],
    ["♿ Xe lăn: Có", "♿ Wheelchair: Yes"],
    ["📐 Độ dốc:", "📐 Slope:"],
    ["🚪 Cửa rộng:", "🚪 Door:"],
    ["Chi phí trọn gói hỗ trợ / khách", "All-inclusive care package / guest"],
    ["Xem thẩm định", "View Audit"],
    ["Đặt giữ chỗ", "Book Slot"],
    ["Đi ngày:", "Visited:"]
];

function translatePlaceholders(lang) {
    const kw = document.getElementById('keywordInput');
    if (kw) {
        kw.placeholder = (lang === 'en')
            ? "e.g., Bai Dinh, Ninh Binh, Hanoi, Da Nang..."
            : "VD: Bái Đính, Ninh Bình, Hà Nội, Đà Nẵng...";
    }
    const revIn = document.getElementById('reviewSearchInput');
    if (revIn) {
        revIn.placeholder = (lang === 'en')
            ? "🔍 Search in reviews (e.g., wheelchair, staff, rest bench)..."
            : "🔍 Tìm trong đánh giá (VD: xe lăn, nhân viên, ghế nghỉ, ca trưa)...";
    }
}

function translateDOMNodes(lang) {
    // 1. Dịch các phần tử khớp chính xác trong EXACT_PAIRS
    const allElements = document.querySelectorAll('h1, h2, h3, p, span, strong, label, button, a, option, div.video-caption-bar');
    allElements.forEach(el => {
        if (el.children.length === 0 || el.tagName === 'BUTTON' || el.tagName === 'A' || el.tagName === 'OPTION') {
            const txt = el.innerText.trim();
            EXACT_PAIRS.forEach(([vi, en]) => {
                if (lang === 'en' && txt === vi) {
                    el.innerText = en;
                } else if (lang === 'vi' && txt === en) {
                    el.innerText = vi;
                }
            });
        }
    });

    // 2. Dịch các checkbox có chứa input bên trong label
    document.querySelectorAll('.a11y-checks label').forEach(lbl => {
        const inp = lbl.querySelector('input');
        if (!inp) return;
        let textNode = Array.from(lbl.childNodes).find(n => n.nodeType === 3 && n.textContent.trim() !== '');
        if (textNode) {
            const cur = textNode.textContent.trim();
            EXACT_PAIRS.forEach(([vi, en]) => {
                if (lang === 'en' && cur === vi) textNode.textContent = ' ' + en;
                if (lang === 'vi' && cur === en) textNode.textContent = ' ' + vi;
            });
        }
    });

    // 3. Dịch bộ đếm phân trang
    const counter = document.getElementById('recordCounter');
    if (counter) {
        if (lang === 'en') {
            counter.innerText = counter.innerText
                .replace('Trang ', 'Page ')
                .replace(' địa điểm đã kiểm định', ' verified destinations');
        } else {
            counter.innerText = counter.innerText
                .replace('Page ', 'Trang ')
                .replace(' verified destinations', ' địa điểm đã kiểm định');
        }
    }

    // 4. Dịch các nút Phân trang (Trang 1 -> Page 1)
    document.querySelectorAll('#paginationControls button, #paginationControls span').forEach(btn => {
        if (lang === 'en') {
            btn.innerText = btn.innerText.replace('Trang ', 'Page ').replace('Tổng ', 'Total ').replace(' trang', ' pages');
        } else {
            btn.innerText = btn.innerText.replace('Page ', 'Trang ').replace('Total ', 'Tổng ').replace(' pages', ' trang');
        }
    });

    // 5. Dịch nội dung bên trong các thẻ địa điểm (#destinationList)
    const cards = document.querySelectorAll('#destinationList .dest-card');
    cards.forEach(card => {
        if (!card.dataset.viHtml) {
            card.dataset.viHtml = card.innerHTML;
        }
        if (lang === 'vi') {
            card.innerHTML = card.dataset.viHtml;
        } else {
            let html = card.dataset.viHtml;
            DYNAMIC_REPLACEMENTS_VI_TO_EN.forEach(([vi, en]) => {
                html = html.split(vi).join(en);
            });
            html = html.replace(/Còn (\d+) suất hỗ trợ/g, '$1 care slots left');
            card.innerHTML = html;
        }
    });

    translatePlaceholders(lang);
}

function toggleLanguage() {
    const next = getLang() === 'vi' ? 'en' : 'vi';
    localStorage.setItem('at_lang', next);
    applyLanguage(next);
}

function applyLanguage(lang) {
    const langBtn = document.getElementById('btnLangSwitch');
    if (langBtn) {
        langBtn.innerHTML = `<span style="font-size:15px;">🌐</span> <span>${lang.toUpperCase()}</span>`;
        langBtn.title = lang === 'vi' ? 'Switch to English' : 'Chuyển sang Tiếng Việt';
    }
    renderAuthNavbar();
    translateDOMNodes(lang);
}

function openSupportModal() {
    let modal = document.getElementById('atSupportModal');
    if (modal) { modal.remove(); }
    const isEn = getLang() === 'en';
    modal = document.createElement('div');
    modal.id = 'atSupportModal';
    modal.style.cssText = 'position:fixed; inset:0; background:rgba(15,23,42,0.65); backdrop-filter:blur(4px); z-index:9999; display:flex; align-items:center; justify-content:center; padding:20px;';
    modal.innerHTML = `
        <div style="background:var(--color-bg-card, #fff); color:var(--color-text-main, #0f172a); max-width:660px; width:100%; border-radius:20px; padding:30px; border:1px solid var(--color-border, #cbd5e1); box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);">
            <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--color-border, #e2e8f0); padding-bottom:12px; margin-bottom:18px;">
                <h2 style="font-size:21px;">${isEn ? '🎧 User Guide & 24/7 Care Support' : '🎧 Hướng Dẫn Sử Dụng & Liên Hệ Hỗ Trợ'}</h2>
                <button onclick="document.getElementById('atSupportModal').style.display='none'" style="background:#f1f5f9; border:none; width:36px; height:36px; border-radius:50%; font-size:17px; font-weight:800; cursor:pointer;">✕</button>
            </div>
            <div style="display:grid; gap:10px; margin-bottom:20px; font-size:14.5px;">
                <div style="background:var(--color-bg-main, #f8fafc); padding:12px 16px; border-radius:10px; border:1px solid var(--color-border, #e2e8f0);">
                    <strong>${isEn ? '1. Select Mobility Profile:' : '1. Chọn thể trạng cơ thể:'}</strong> ${isEn ? 'Choose Senior, Wheelchair, or Quiet Ground-Floor room to filter suitable slopes and rest benches.' : 'Bấm chọn Người cao tuổi, Xe lăn hoặc Phòng tầng trệt để lọc độ dốc và ghế nghỉ phù hợp.'}
                </div>
                <div style="background:var(--color-bg-main, #f8fafc); padding:12px 16px; border-radius:10px; border:1px solid var(--color-border, #e2e8f0);">
                    <strong>${isEn ? '2. Check Verification Level:' : '2. Kiểm tra mức độ xác minh:'}</strong> ${isEn ? 'Review on-site verification badges, existing limitations, and real unprompted reviews.' : 'Xem nhãn Đã xác minh tại chỗ, Lưu ý hạn chế còn tồn tại và Đánh giá thực tế.'}
                </div>
                <div style="background:var(--color-bg-main, #f8fafc); padding:12px 16px; border-radius:10px; border:1px solid var(--color-border, #e2e8f0);">
                    <strong>${isEn ? '3. 15-Minute Slot Hold:' : '3. Giữ chỗ có thời hạn 15 phút:'}</strong> ${isEn ? 'Your care slot is locked exclusively for 15 minutes via SELECT ... FOR UPDATE.' : 'Hệ thống khóa hàng độc quyền giữ suất hỗ trợ cho bạn trong 15 phút.'}
                </div>
            </div>
            <div style="border:1.5px solid #bbf7d0; background:#f0fdf4; padding:14px; border-radius:12px; color:#166534; margin-bottom:18px;">
                <strong>🚨 ${isEn ? '24/7 Medical & Accessibility Hotline:' : 'Tổng đài Hỗ trợ Y tế & Trợ năng (24/7):'} 1900 6868</strong> — Email: hotro@accesstravel.vn
            </div>
            <div style="text-align:right;">
                <button onclick="document.getElementById('atSupportModal').style.display='none'" class="btn btn-primary" style="padding:10px 22px; border-radius:10px;">${isEn ? 'Close' : 'Đóng cửa sổ'}</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}

function renderAuthNavbar() {
    const navAuth = document.getElementById('navAuthArea');
    const adminLink = document.getElementById('navAdminLink');
    const user = getCurrentUser();
    const isEn = getLang() === 'en';

    if (user && user.role === 'admin' && adminLink) {
        adminLink.style.display = 'inline-block';
    } else if (adminLink) {
        adminLink.style.display = 'none';
    }
    if (!navAuth) return;

    if (user) {
        navAuth.innerHTML = `
            <div style="display:inline-flex; align-items:center; gap:8px;">
                <span style="background:#f0fdf4; color:#065f46; border:1px solid #bbf7d0; padding:6px 12px; border-radius:99px; font-size:13.5px; font-weight:700;">
                    👋 ${user.full_name || user.username}
                </span>
                <button onclick="logoutUser()" class="btn btn-outline" style="min-height:38px; padding:6px 14px; border-radius:99px; font-size:13.5px;">${isEn ? 'Log out' : 'Đăng xuất'}</button>
            </div>
        `;
    } else {
        navAuth.innerHTML = `
            <div style="display:inline-flex; align-items:center; gap:8px;">
                <a href="register.html" class="btn btn-outline" style="min-height:38px; padding:6px 16px; border-radius:99px; font-size:13.5px; font-weight:700; background:transparent !important; color:#0f172a !important; border:1.5px solid #cbd5e1 !important;">${isEn ? 'Sign up' : 'Đăng ký'}</a>
                <a href="login.html" class="btn btn-primary" style="min-height:38px; padding:6px 18px; border-radius:99px; font-size:13.5px;">${isEn ? 'Log in' : 'Đăng nhập'}</a>
            </div>
        `;
    }
}

async function logoutUser() {
    localStorage.removeItem('at_user');
    try { await fetch('../api/logout.php'); } catch (e) {}
    window.location.href = 'index.html';
}

function enhanceNavbarControls() {
    const navLinks = document.querySelector('.nav-links');
    const themeBtn = document.getElementById('btnThemeToggle');
    if (!navLinks || !themeBtn) return;

    if (!document.getElementById('btnSupportModal')) {
        const supBtn = document.createElement('button');
        supBtn.id = 'btnSupportModal';
        supBtn.type = 'button';
        supBtn.onclick = openSupportModal;
        supBtn.style.cssText = 'background:transparent; border:none; font-size:15px; font-weight:600; color:#334155; cursor:pointer; padding:4px 6px;';
        supBtn.innerText = '🎧 Hỗ trợ';
        navLinks.insertBefore(supBtn, themeBtn);
    }

    if (!document.getElementById('btnLangSwitch')) {
        const langBtn = document.createElement('button');
        langBtn.id = 'btnLangSwitch';
        langBtn.type = 'button';
        langBtn.onclick = toggleLanguage;
        langBtn.style.cssText = 'background:#0f172a; color:#ffffff; border:1px solid #334155; border-radius:99px; padding:6px 13px; font-size:13.5px; font-weight:800; cursor:pointer; display:inline-flex; align-items:center; gap:6px; min-height:38px;';
        navLinks.insertBefore(langBtn, themeBtn);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    applySavedTheme();
    enhanceNavbarControls();
    applyLanguage(getLang());

    // Tự động dịch ngay cả khi danh sách thẻ địa điểm vừa tải xong từ AJAX MySQL
    const listEl = document.getElementById('destinationList');
    if (listEl) {
        const obs = new MutationObserver(() => {
            if (getLang() === 'en') translateDOMNodes('en');
        });
        obs.observe(listEl, { childList: true });
    }
});


