// Hệ thống Đa ngôn ngữ (VI / EN) TOÀN DIỆN 100% - Phủ sóng mọi trang
function getCurrentUser() {
    try { const raw = localStorage.getItem('at_user'); return raw ? JSON.parse(raw) : null; } catch (e) { return null; }
}

function applySavedTheme() {
    if ((localStorage.getItem('at_theme') || 'default') === 'accessible') document.documentElement.setAttribute('data-theme', 'accessible');
    else document.documentElement.removeAttribute('data-theme');
}

function toggleAccessibilityTheme() {
    if (document.documentElement.getAttribute('data-theme') === 'accessible') {
        document.documentElement.removeAttribute('data-theme');
        localStorage.setItem('at_theme', 'default');
    } else {
        document.documentElement.setAttribute('data-theme', 'accessible');
        localStorage.setItem('at_theme', 'accessible');
    }
}

function getLang() { return localStorage.getItem('at_lang') || 'vi'; }

// TỪ ĐIỂN SIÊU TO KHỔNG LỒ (Bao trọn Trang chủ, Booking, Detail, Register, Login)
const EXACT_PAIRS = [
    // Menu & Chung
    ["Khám phá điểm đến", "Explore Destinations"], ["Đánh giá cộng đồng", "Verified Reviews"], ["Kiểm tra & Đặt lịch", "Check & Book Slot"], ["← Quay lại Khám phá điểm đến", "← Back to Explore Destinations"], ["🎧 Hỗ trợ", "🎧 Support & Guide"], ["Aa Chế độ Chữ lớn", "Aa Large Text Mode"], ["Aa Chế độ Chữ lớn (Trợ năng)", "Aa Large Text Mode"], ["Đăng nhập", "Log in"], ["Đăng ký", "Sign up"], ["Đăng xuất", "Log out"], ["Tỉnh/Thành hoặc Tên cơ sở", "Province/City or Facility Name"],
    
    // Trang chủ
    ["✔ Dữ liệu khảo sát thực địa • Cập nhật Tháng 10/2026", "✔ Field-Verified Data • Updated Oct 2026"],
    ["Biết Trước Chuyến Đi Có Thực Sự Phù Hợp Với Cơ Thể & Sức Khỏe Của Bạn", "Know Before You Go: Trips Tailored to Your Needs"],
    ["Không chỉ là đặt chỗ — chúng tôi minh bạch hóa mức độ hỗ trợ người cao tuổi, khoảng cách ghế nghỉ chân, thái độ nhân viên hỗ trợ và đánh giá thực tế từ những gia đình đã trải nghiệm.", "More than booking — we verify senior care support, rest bench distances, trained staff availability, and real unprompted reviews from families."],
    ["🩺 Bước 1: Chọn thể trạng của người đi cùng bạn (Hệ thống sẽ ưu tiên hiển thị thông tin phù hợp):", "🩺 Step 1: Select mobility profile (Prioritized matching):"],
    ["Đang ưu tiên: Người cao tuổi cần ghế nghỉ & nhân viên hỗ trợ", "Prioritizing: Seniors needing rest benches & staff assistance"],
    ["Đang ưu tiên: Người dùng xe lăn (Dốc ≤ 6%, lối đi xe lăn & thang máy rộng)", "Prioritizing: Wheelchair users (Slope ≤ 6%, ramps & wide elevators)"],
    ["Đang ưu tiên: Chỗ nghỉ tầng trệt yên tĩnh & nhân viên y tế túc trực", "Prioritizing: Quiet ground-floor rooms & 24/7 medical standby"],
    ["Đang hiển thị tất cả điểm đến trong CSDL", "Showing all verified destinations in database"],
    ["👴 Người cao tuổi (Dễ mỏi gối, cần chỗ nghỉ & nhân viên dìu)", "👴 Seniors (Easy fatigue, needs rest benches & staff)"],
    ["🦽 Người dùng xe lăn (Cần dốc ≤ 6%, cửa ≥ 80cm, thang máy)", "🦽 Wheelchair Users (Slope ≤ 6%, door ≥ 80cm, elevator)"],
    ["🛌 Cần không gian yên tĩnh, phòng tầng trệt & y tế gần", "🛌 Quiet Space, Ground-Floor Room & Medical Care"],
    ["🔄 Xem tất cả tiêu chuẩn", "🔄 View All Standards"], ["Tìm theo Tên địa điểm hoặc Tỉnh/Thành phố", "Search by Destination Name or Province/City"], ["Độ thoải đường dốc (Phù hợp sức chân)", "Ramp Slope Comfort (Leg Strength Fit)"], ["Tất cả độ dốc đã kiểm định", "All Verified Ramp Slopes"], ["Đi bộ nhẹ / Người cao tuổi (≤ 8%)", "Gentle Walk / Seniors (≤ 8%)"], ["Siêu thoải cho Xe lăn tự đẩy (≤ 6%)", "Ultra-Gentle for Manual Wheelchair (≤ 6%)"], ["Sắp xếp phía Máy chủ (Server Sort)", "Server-Side Sorting"], ["Độ phù hợp thể trạng cao nhất", "Highest Body-Fit Match"], ["🔥 Sắp hết suất hỗ trợ (1 chỗ cuối lên đầu)", "🔥 Almost Full (Last 1 Slot First)"], ["💰 Chi phí thấp đến cao", "💰 Price: Low to High"], ["💎 Dịch vụ cao cấp trước", "💎 Premium Care First"], ["🔍 Lọc kết quả", "🔍 Filter Results"], ["♿ Có lối đi Xe lăn xuyên suốt", "♿ Full Wheelchair Ramp Access"], ["🛗 Có Thang máy / Xe điện nội khu", "🛗 Elevator / Internal Electric Buggy"], ["🚻 Nhà vệ sinh có tay vịn chống trượt", "🚻 Accessible Restroom with Grab Bars"],
    ["🎥 Video khảo sát thực địa", "🎥 Field Inspection Video"], ["Xem Trước Hành Trình Thực Tế: Lối Đi Xe Lăn, Chỗ Nghỉ Chân & Nhân Viên Hỗ Trợ", "Preview Real Journey: Wheelchair Ramps, Rest Benches & Staff"], ["✔ Quay trực tiếp tại điểm đến đã kiểm định", "✔ Filmed on-site at verified destinations"], ["KIỂM ĐỊNH THỰC TẾ", "FIELD VERIFIED"], ["ĐỘ DỐC • CHỖ NGHỈ • NHÂN VIÊN HỖ TRỢ", "RAMP SLOPE • REST ZONES • SUPPORT STAFF"], ["\"Giúp gia đình bạn nhìn thấy tận mắt lối đi và chỗ nghỉ trước khi quyết định khởi hành.\"", "\"Helping your family see the actual pathways and rest areas before you depart.\""], ["Điểm Đến Đã Kiểm Định Mức Độ Hỗ Trợ Thể Trạng", "Destinations Verified for Mobility & Senior Comfort"], ["Mọi thẻ đều hiển thị rõ: Hỗ trợ người cao tuổi, Chỗ nghỉ chân, Nhân viên, Ngày đo đạc và Đánh giá thật.", "Every card clearly shows: Senior support, Rest areas, Staff, Verification date & Real reviews."], ["Đánh Giá Thực Tế Từ Khách Hàng & Gia Đình Người Cao Tuổi", "Real Unprompted Reviews from Seniors & Families"], ["🔄 Hiện tất cả đánh giá", "🔄 Show All Reviews"], ["Tổng cộng 148 đánh giá thực tế", "Total 148 verified reviews"], ["5 sao", "5-star"], ["4 sao", "4-star"], ["3 sao", "3-star"], ["2 sao", "2-star"], ["1 sao", "1-star"], ["✔ Đang hiển thị tất cả mức sao", "✔ Showing all star ratings"], ["✔ Đang hiển thị tất cả mức sao (5 đánh giá tiêu biểu)", "✔ Showing all star ratings (5 featured reviews)"],

    // Trang Đặt Lịch (booking.html)
    ["📅 Kiểm tra & Đặt lịch", "📅 Check & Book Slot"],
    ["Luồng 4 bước: Thông tin chuyến đi → Nhu cầu tiếp cận → Chọn dịch vụ → Xác nhận đặt lịch (Giữ chỗ 15 phút)", "4-step flow: Trip Info → Accessibility Needs → Select Service → Confirm Booking (15-min hold)"],
    ["🔄 Reset điểm đến #1 về Còn 1 chỗ trống", "🔄 Reset destination #1 to 1 slot left"],
    ["1. Thông tin chuyến đi", "1. Trip Information"],
    ["Nhập thông tin cơ bản để hệ thống kiểm tra chỗ trống và nhân viên hỗ trợ.", "Enter basic info to check availability and support staff."],
    ["Điểm đến (Tỉnh/Thành hoặc Tên cơ sở)", "Destination (Province/City or Facility Name)"],
    ["Loại dịch vụ", "Service Type"],
    ["Khách sạn / Tour / Điểm tham quan", "Hotel / Tour / Attraction"],
    ["Khách sạn & Khu nghỉ dưỡng có phòng tầng trệt", "Hotel & Resort with ground floor rooms"],
    ["Tour tham quan có xe điện & nhân viên dìu", "Tour with electric buggy & walking support"],
    ["Ngày đi dự kiến", "Expected Date"],
    ["Số người (Nút tăng/giảm trực quan)", "Number of Guests (+/- buttons)"],
    ["2. Nhu cầu tiếp cận", "2. Accessibility Needs"],
    ["Chia thành Tiêu chí bắt buộc (lọc cứng trên CSDL) và Mức độ cần nhân viên hỗ trợ.", "Divided into Mandatory criteria (DB filtered) and Staff support level."],
    ["A. Tiêu chí hạ tầng bắt buộc:", "A. Mandatory Infrastructure Criteria:"],
    ["♿ Đường dốc cho xe lăn (≤ 8%)", "♿ Wheelchair ramp (≤ 8%)"],
    ["🛗 Có thang máy rộng (≥ 80cm)", "🛗 Wide elevator (≥ 80cm)"],
    ["🚻 Nhà vệ sinh tiếp cận có tay vịn", "🚻 Accessible restroom with grab bars"],
    ["❤️ Hỗ trợ y tế & Hạn chế đi bộ xa", "❤️ Medical support & Limited walking"],
    ["B. Nhân viên hỗ trợ (Tiêu chí ưu tiên):", "B. Support Staff (Priority Criteria):"],
    ["Cần nhân viên hỗ trợ", "Need support staff"],
    ["Có thì tốt", "Good to have"],
    ["Không cần", "Not needed"],
    ["🔍 Kiểm tra dịch vụ phù hợp", "🔍 Check Suitable Services"],
    ["3. Kết quả dịch vụ phù hợp", "3. Suitable Service Results"],
    ["Hiển thị rõ mức độ xác minh thực tế, số chỗ trống và chi phí để bạn chọn đưa vào phiếu đặt lịch.", "Displaying actual verification level, available slots, and costs to add to your booking form."],
    ["4. Xác nhận đặt lịch & Giữ chỗ (15 phút)", "4. Confirm Booking & Hold Slot (15 mins)"],
    ["Sau khi xác nhận, hệ thống dùng khóa hàng SELECT ... FOR UPDATE trừ tồn kho và giữ chỗ 15 phút.", "After confirmation, system uses SELECT ... FOR UPDATE lock to deduct inventory and hold for 15 mins."],
    ["1. Dịch vụ đang chọn đặt", "1. Selected Service"],
    ["2. Họ tên & Số điện thoại liên hệ", "2. Full Name & Phone Number"],
    ["3. Nhu cầu hỗ trợ cụ thể & Ghi chú tự nguyện", "3. Specific Support Needs & Voluntary Notes"],
    ["4. Chi phí & Điều kiện hoàn hủy:", "4. Cost & Cancellation Policy:"],
    ["Tổng tạm tính:", "Estimated Total:"],
    ["✔ Miễn phí hủy/đổi lịch trước 24 giờ khởi hành.", "✔ Free cancellation/rescheduling 24 hours before departure."],
    ["5. Phương thức thanh toán", "5. Payment Method"],
    ["Giữ chỗ trước — Thanh toán tại điểm đến sau khi kiểm tra hạ tầng", "Hold first — Pay at destination after checking infrastructure"],
    ["Chuyển khoản ngân hàng / VietQR", "Bank Transfer / VietQR"],
    ["6. Xác nhận đặt lịch & Giữ chỗ ngay", "6. Confirm Booking & Hold Now"]
];

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
    ["Phòng nghỉ tầng trệt & Nhân viên y tế trực", "Ground-floor room & 24/7 medical standby"],
    ["Đường bằng phẳng, hạn chế đi bộ xa", "Flat pathways, limited walking distance"],
    ["Có nhân viên hỗ trợ đẩy xe lăn & dìu khách", "Staff available to push wheelchairs & assist walking"],
    ["Lưu ý thực tế:", "Field Note:"],
    ["Hạn chế nhỏ: Lối vào cổng phụ có 2 bậc tam cấp, xe lăn nên đi cổng chính phía Đông.", "Minor note: Side gate has 2 steps; wheelchair users should use the East main gate."],
    ["Lưu ý: Thang máy khu B bảo trì từ 12h-13h thứ Hai hàng tuần, có nhân viên hỗ trợ.", "Note: Block B elevator under maintenance Mon 12-1PM; staff assist via secondary ramp."],
    ["Chưa xác minh độ rộng cửa phòng tắm ở khu nhà cổ, nên yêu cầu phòng tầng 1 khu mới.", "Bathroom door width in heritage wing unverified; request a 1st-floor room in the new wing."],
    ["Hạn chế nhỏ: Quãng đường từ bãi xe vào sảnh dài 80m, người cao tuổi nên đăng ký xe điện.", "Minor note: Parking to lobby is 80m; seniors should request the free electric buggy pickup."],
    ["♿ Xe lăn: Có", "♿ Wheelchair: Yes"],
    ["📐 Độ dốc:", "📐 Slope:"],
    ["🚪 Cửa rộng:", "🚪 Door:"],
    ["Chi phí trọn gói hỗ trợ / khách", "All-inclusive care package / guest"],
    ["Xem thẩm định", "View Audit"],
    ["Đặt giữ chỗ", "Book Slot"],
    ["Tiện nghi: Dốc", "Amenities: Slope"],
    ["• Cửa", "• Door"],
    ["• Còn", "•"],
    ["chỗ trống", "slots left"],
    ["⚠ Lưu ý:", "⚠ Note:"],
    ["⚠ Hạn chế nhỏ:", "⚠ Minor note:"],
    ["⚠ Chưa xác minh", "⚠ Unverified"],
    ["Chọn dịch vụ này ↓", "Select this service ↓"]
];

function translatePlaceholders(lang) {
    const p1 = document.getElementById('keywordInput');
    if (p1) p1.placeholder = (lang === 'en') ? "e.g., Bai Dinh, Ninh Binh, Hanoi..." : "VD: Bái Đính, Ninh Bình, Hà Nội, Đà Nẵng...";
    const p2 = document.getElementById('reviewSearchInput');
    if (p2) p2.placeholder = (lang === 'en') ? "🔍 Search in reviews (e.g., wheelchair, staff)..." : "🔍 Tìm trong đánh giá (VD: xe lăn, nhân viên, ghế nghỉ, ca trưa)...";
    const p3 = document.getElementById('tripKeyword');
    if (p3) p3.placeholder = (lang === 'en') ? "e.g., Da Nang, Ha Noi..." : "VD: Ninh Bình, Đà Nẵng, Hà Nội...";
    const p4 = document.getElementById('special_note');
    if (p4) {
        if(p4.value.includes("Đi cùng người cao tuổi, cần xe lăn tại sảnh")) {
            p4.value = (lang === 'en') ? "Traveling with seniors, need wheelchair at lobby and ground-floor room." : "Đi cùng người cao tuổi, cần xe lăn tại sảnh và phòng nghỉ tầng trệt.";
        } else if (p4.value.includes("Traveling with seniors, need wheelchair at lobby")) {
            p4.value = (lang === 'en') ? "Traveling with seniors, need wheelchair at lobby and ground-floor room." : "Đi cùng người cao tuổi, cần xe lăn tại sảnh và phòng nghỉ tầng trệt.";
        }
    }
}

function translateDOMNodes(lang) {
    // Dịch các text tĩnh bằng EXACT_PAIRS
    const allElements = document.querySelectorAll('h1, h2, h3, p, span, strong, label, button, a, option, div.section-title, div.section-sub, div.video-caption-bar');
    allElements.forEach(el => {
        // Chỉ ưu tiên những thẻ không có nhiều thẻ HTML con lồng nhau để tránh lỗi giao diện
        if (el.children.length === 0 || el.tagName === 'BUTTON' || el.tagName === 'A' || el.tagName === 'OPTION' || el.tagName === 'LABEL') {
            let txt = el.innerText.trim();
            
            // Xử lý riêng cho Label có chứa checkbox/radio input bên trong
            let targetNode = el;
            if (el.tagName === 'LABEL' && el.querySelector('input')) {
                const textNodes = Array.from(el.childNodes).filter(n => n.nodeType === Node.TEXT_NODE && n.textContent.trim() !== '');
                if (textNodes.length > 0) {
                    txt = textNodes[textNodes.length - 1].textContent.trim();
                    targetNode = textNodes[textNodes.length - 1];
                }
            }

            EXACT_PAIRS.forEach(([vi, en]) => {
                if (lang === 'en' && txt === vi) {
                    if (targetNode.nodeType === Node.TEXT_NODE) targetNode.textContent = ' ' + en;
                    else el.innerText = en;
                } else if (lang === 'vi' && txt === en) {
                    if (targetNode.nodeType === Node.TEXT_NODE) targetNode.textContent = ' ' + vi;
                    else el.innerText = vi;
                }
            });
        }
    });

    // Dịch các khối động lấy từ API (Thẻ địa điểm ở trang chủ & Kết quả search ở Booking)
    const dynamicContainers = document.querySelectorAll('#destinationList .dest-card, #matchingResultsBox .mini-result-item');
    dynamicContainers.forEach(card => {
        if (!card.dataset.viHtml) card.dataset.viHtml = card.innerHTML;
        if (lang === 'vi') {
            card.innerHTML = card.dataset.viHtml;
        } else {
            let html = card.dataset.viHtml;
            DYNAMIC_REPLACEMENTS_VI_TO_EN.forEach(([vi, en]) => { html = html.split(vi).join(en); });
            html = html.replace(/Còn (\d+) suất hỗ trợ/g, '$1 care slots left');
            html = html.replace(/Còn <strong>(\d+)<\/strong> chỗ trống/g, '<strong>$1</strong> slots left');
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

    if (user && user.role === 'admin' && adminLink) adminLink.style.display = 'inline-block';
    else if (adminLink) adminLink.style.display = 'none';
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

    // Quan sát sự thay đổi DOM ở cả 2 khu vực (Trang chủ và Trang Booking) để dịch ngay
    const obsConfig = { childList: true };
    const listEl = document.getElementById('destinationList');
    const matchBox = document.getElementById('matchingResultsBox');
    const obs = new MutationObserver(() => { if (getLang() === 'en') translateDOMNodes('en'); });
    if (listEl) obs.observe(listEl, obsConfig);
    if (matchBox) obs.observe(matchBox, obsConfig);
});
