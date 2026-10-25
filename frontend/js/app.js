// ============================================================================
// 1. TỪ ĐIỂN ĐA NGÔN NGỮ (Tương đương locales/vi.json & locales/en.json)
// ============================================================================
const LOCALES = {
    vi: {
        "nav.explore": "Khám phá",
        "nav.reviews": "Đánh giá",
        "nav.booking": "Đặt lịch",
        "nav.login": "Đăng nhập",
        "nav.home": "Trang chủ",
        "hero.title": "Du lịch Không Rào Cản Tại Việt Nam",
        "hero.subtitle": "Nền tảng OTA duy nhất kiểm định thực tế độ dốc xe lăn, thang máy và tiện ích người cao tuổi tại hàng trăm điểm đến trên toàn quốc.",
        "search.placeholder": "Nhập tên địa điểm, ví dụ: Hạ Long, Đà Nẵng",
        "search.listening": "Đang nghe... Hãy nói tên địa điểm",
        "search.btn": "Tìm kiếm",
        "search.voice_title": "Tìm kiếm bằng giọng nói",
        "search.filter_label": "Lọc theo nhu cầu:",
        "search.clear_filter": "Xóa bộ lọc",
        "chip.wheelchair": "Xe lăn an toàn",
        "chip.low_slope": "Độ dốc thấp",
        "chip.elevator": "Có thang máy",
        "chip.wc": "WC có tay vịn",
        "chip.medical": "Gần trạm y tế",
        "chip.elderly": "Phù hợp người cao tuổi",
        "video.title": "Trải Nghiệm Thực Tế Khảo Sát",
        "video.desc": "Khám phá tận mắt lối đi, độ dốc và sự hỗ trợ của nhân viên tại các điểm đến trước khi quyết định khởi hành.",
        "video.badge": "ĐỘ DỐC • CHỖ NGHỈ • NHÂN VIÊN",
        "tour.title": "Điểm Đến Đã Kiểm Định",
        "tour.desc": "Dữ liệu đo đạc thực tế. Sắp xếp theo mức độ phù hợp.",
        "tour.status_loaded": "Đã tải xong",
        "tour.slots_left": "Còn {n} suất",
        "tour.support": "Hỗ trợ:",
        "tour.rest": "Nghỉ chân:",
        "tour.staff": "Nhân viên:",
        "tour.btn_audit": "Xem thẩm định",
        "tour.btn_book": "Đặt chỗ",
        "tour.results_count": "Tìm thấy {n} điểm đến phù hợp",
        "tour.no_result_title": "Chưa tìm thấy điểm đến khớp hoàn toàn với bộ lọc của bạn",
        "tour.no_result_desc": "Gợi ý: Bạn có thể bấm 'Xóa bộ lọc' hoặc tham khảo các điểm đến đạt chuẩn 100% dưới đây:",
        "review.section_title": "Đánh Giá Thực Tế Từ Khách Hàng",
        "review.section_desc": "Tất cả đánh giá được tổng hợp trực tiếp từ dữ liệu chuyến đi thực tế của các gia đình.",
        "review.write_btn": "Viết đánh giá",
        "review.out_of": "trên 5",
        "review.total_count": "Dựa trên {n} đánh giá thực tế",
        "review.filter_all": "Tất cả",
        "review.filter_5": "5 Sao",
        "review.filter_4": "4 Sao",
        "review.filter_3": "3 Sao",
        "review.filter_2": "2 Sao",
        "review.filter_1": "1 Sao",
        "review.filter_img": "Có hình ảnh",
        "review.filter_cmt": "Có bình luận",
        "review.verified": "Đã xác minh chuyến đi",
        "review.helpful": "Hữu ích",
        "review.load_more": "Xem thêm đánh giá",
        "review.empty_filter": "Chưa có đánh giá nào ở mức lọc này.",
        "detail.not_found_title": "Không tìm thấy điểm đến",
        "detail.not_found_desc": "Điểm đến bạn tìm kiếm không tồn tại hoặc đường dẫn không hợp lệ.",
        "detail.back_home": "Quay lại trang chủ",
        "detail.verified_badge": "Đã Đo Đạc & Xác Minh Thực Tế",
        "detail.audited_by": "Được thẩm định bởi AccessTravel",
        "detail.warning_title": "Lưu ý hạn chế từ Chuyên gia Khảo sát:",
        "detail.specs_title": "Thông Số Hạ Tầng Đo Đạc Thực Tế",
        "detail.spec_slope": "ĐỘ DỐC ĐƯỜNG DẪN XE LĂN",
        "detail.spec_door": "CHIỀU RỘNG CỬA PHÒNG & WC",
        "detail.spec_elevator": "HỆ THỐNG THANG MÁY & LỐI VÀO",
        "detail.spec_wc": "NHÀ VỆ SINH & PHÒNG TẮM",
        "detail.price_label": "CHI PHÍ TRỌN GÓI / KHÁCH",
        "detail.slots_status": "Tình trạng chỗ: Còn {n} suất trống",
        "detail.lock_note": "Hệ thống áp dụng công nghệ khóa chống tranh chấp SELECT FOR UPDATE độc quyền của AccessTravel.",
        "detail.book_now": "Tiến Hành Đặt & Giữ Chỗ",
        "detail. safeguard": "Bảo vệ sự minh bạch tuyệt đối: Tất cả đánh giá được thu thập ngẫu nhiên từ khách hàng đã trải nghiệm thực tế.",
        "footer.desc": "Nền tảng tiên phong tại Việt Nam chuyên thẩm định mức độ phù hợp cơ thể & đặt dịch vụ du lịch tiếp cận cho người cao tuổi và người khuyết tật.",
        "footer.about": "Về Chúng Tôi",
        "footer.about_1": "Câu chuyện AccessTravel",
        "footer.about_2": "Đội ngũ phát triển (Nhóm 14)",
        "footer.about_3": "Quy trình thẩm định 5 bước",
        "footer.about_4": "Báo chí & Truyền thông",
        "footer.support": "Hỗ Trợ Khách Hàng",
        "footer.sup_1": "Trung tâm trợ giúp 24/7",
        "footer.sup_2": "Chính sách hủy & hoàn tiền",
        "footer.sup_3": "Cẩm nang du lịch cho xe lăn",
        "footer.sup_4": "Cam kết chuẩn WCAG 2.1 AA",
        "footer.contact": "Liên Hệ Đặt Dịch Vụ",
        "footer.hotline": "Hotline Y Tế & Trợ Năng",
        "footer.email": "Hỗ trợ Email",
        "footer.copyright": "© 2026 AccessTravel — Đồ án môn học Web Applications in Tourism (CSE703073).",
        "footer.arch": "Kiến trúc hệ thống: HTML/CSS/JS (Frontend) & PHP/MySQL (Backend) | CSDL: ≥ 300 bản ghi.",
        "footer.payment": "Thanh toán an toàn:",
        "auth.login_title": "Đăng nhập hệ thống",
        "auth.login_desc": "Để tiếp tục khám phá du lịch không rào cản",
        "auth.role_user": "CHẾ ĐỘ KHÁCH",
        "auth.role_admin": "CHẾ ĐỘ ADMIN",
        "auth.email_ph": "Email đăng nhập",
        "auth.pass_ph": "Mật khẩu",
        "auth.remember": "Ghi nhớ tôi",
        "auth.forgot": "Quên mật khẩu?",
        "auth.submit_login": "ĐĂNG NHẬP",
        "auth.or_social": "Hoặc đăng nhập nhanh bằng",
        "auth.no_acc": "Chưa có tài khoản?",
        "auth.reg_now": "ĐĂNG KÝ HỒ SƠ Y TẾ NGAY",
        "auth.err_email": "Vui lòng nhập đúng định dạng email (@)",
        "auth.err_pass": "Mật khẩu phải có ít nhất 6 ký tự"
    },
    en: {
        "nav.explore": "Explore",
        "nav.reviews": "Reviews",
        "nav.booking": "Book Now",
        "nav.login": "Sign In",
        "nav.home": "Home",
        "hero.title": "Barrier-Free Travel in Vietnam",
        "hero.subtitle": "The only OTA platform in Vietnam that physically audits wheelchair ramps, elevators, and senior-friendly facilities across hundreds of destinations.",
        "search.placeholder": "Enter destination, e.g., Ha Long, Da Nang",
        "search.listening": "Listening... Please speak destination name",
        "search.btn": "Search",
        "search.voice_title": "Voice Search",
        "search.filter_label": "Filter by needs:",
        "search.clear_filter": "Clear filters",
        "chip.wheelchair": "Wheelchair Safe",
        "chip.low_slope": "Low Slope",
        "chip.elevator": "Elevator Available",
        "chip.wc": "WC with Grab Bars",
        "chip.medical": "Near Medical Station",
        "chip.elderly": "Senior Friendly",
        "video.title": "Real Field Audit Experience",
        "video.desc": "See actual pathways, ramp slopes, and staff assistance at destinations before deciding to depart.",
        "video.badge": "RAMP SLOPE • REST AREAS • STAFF",
        "tour.title": "Verified Accessible Destinations",
        "tour.desc": "Physically measured data. Sorted by accessibility match.",
        "tour.status_loaded": "Data Loaded",
        "tour.slots_left": "{n} slots left",
        "tour.support": "Support:",
        "tour.rest": "Rest area:",
        "tour.staff": "Medical/Staff:",
        "tour.btn_audit": "View Audit",
        "tour.btn_book": "Book Now",
        "tour.results_count": "Found {n} matching destinations",
        "tour.no_result_title": "No destinations matched all of your selected filters",
        "tour.no_result_desc": "Suggestion: Click 'Clear filters' or explore our 100% verified destinations below:",
        "review.section_title": "Verified Customer Reviews",
        "review.section_desc": "All reviews are aggregated directly from real family trips.",
        "review.write_btn": "Write a Review",
        "review.out_of": "out of 5",
        "review.total_count": "Based on {n} verified reviews",
        "review.filter_all": "All",
        "review.filter_5": "5 Stars",
        "review.filter_4": "4 Stars",
        "review.filter_3": "3 Stars",
        "review.filter_2": "2 Stars",
        "review.filter_1": "1 Star",
        "review.filter_img": "With Photos",
        "review.filter_cmt": "With Comments",
        "review.verified": "Verified Trip",
        "review.helpful": "Helpful",
        "review.load_more": "Load More Reviews",
        "review.empty_filter": "No reviews match this filter.",
        "detail.not_found_title": "Destination Not Found",
        "detail.not_found_desc": "The destination you are looking for does not exist or the URL is invalid.",
        "detail.back_home": "Back to Home",
        "detail.verified_badge": "Physically Measured & Verified",
        "detail.audited_by": "Audited by AccessTravel",
        "detail.warning_title": "Accessibility Notice from Field Auditor:",
        "detail.specs_title": "Measured Infrastructure Specifications",
        "detail.spec_slope": "WHEELCHAIR RAMP SLOPE",
        "detail.spec_door": "ROOM & WC DOOR WIDTH",
        "detail.spec_elevator": "ELEVATOR & ENTRANCE",
        "detail.spec_wc": "RESTROOM & BATHROOM",
        "detail.price_label": "ALL-INCLUSIVE PRICE / GUEST",
        "detail.slots_status": "Availability: {n} slots left",
        "detail.lock_note": "Powered by AccessTravel's exclusive SELECT FOR UPDATE concurrency lock technology.",
        "detail.book_now": "Proceed to Book & Hold Slot",
        "detail.safeguard": "Absolute Transparency Guarantee: All reviews are collected from verified travelers.",
        "footer.desc": "Vietnam's pioneering platform for physical accessibility auditing & barrier-free travel booking for seniors and people with disabilities.",
        "footer.about": "About Us",
        "footer.about_1": "AccessTravel Story",
        "footer.about_2": "Development Team (Group 14)",
        "footer.about_3": "5-Step Audit Process",
        "footer.about_4": "Press & Media",
        "footer.support": "Customer Support",
        "footer.sup_1": "24/7 Help Center",
        "footer.sup_2": "Cancellation & Refund Policy",
        "footer.sup_3": "Wheelchair Travel Guide",
        "footer.sup_4": "WCAG 2.1 AA Commitment",
        "footer.contact": "Booking Contact",
        "footer.hotline": "Medical & Accessibility Hotline",
        "footer.email": "Email Support",
        "footer.copyright": "© 2026 AccessTravel — Course Project: Web Applications in Tourism (CSE703073).",
        "footer.arch": "System Architecture: HTML/CSS/JS (Frontend) & PHP/MySQL (Backend) | DB: ≥ 300 records.",
        "footer.payment": "Secure Payment:",
        "auth.login_title": "System Sign In",
        "auth.login_desc": "Continue exploring barrier-free travel",
        "auth.role_user": "GUEST MODE",
        "auth.role_admin": "ADMIN MODE",
        "auth.email_ph": "Login Email",
        "auth.pass_ph": "Password",
        "auth.remember": "Remember me",
        "auth.forgot": "Forgot password?",
        "auth.submit_login": "SIGN IN",
        "auth.or_social": "Or sign in quickly with",
        "auth.no_acc": "Don't have an account?",
        "auth.reg_now": "REGISTER MEDICAL PROFILE NOW",
        "auth.err_email": "Please enter a valid email address (@)",
        "auth.err_pass": "Password must be at least 6 characters"
    }
};

// ============================================================================
// 2. CƠ SỞ DỮ LIỆU ĐIỂM ĐẾN & ĐÁNH GIÁ (30 SẢN PHẨM)
// ============================================================================
const DESTINATIONS_DB = [
    // MIỀN BẮC
    {
        id: 1, slug: "ha-long-ambassador", title: "Du thuyền Ambassador Vịnh Hạ Long", title_en: "Ambassador Cruise Ha Long Bay",
        address: "Quảng Ninh, Việt Nam", address_en: "Quang Ninh, Vietnam",
        image: "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1000&q=80",
        slots: 12, price: 3200000, badge_text: "✔ Đã xác minh 100%", badge_text_en: "✔ 100% Verified", badge_bg: "#dcfce7", badge_color: "#166534",
        tags: ["wheelchair", "low_slope", "elevator", "wc", "medical", "elderly"],
        support_1: "Thang máy giữa các tầng boong", support_1_en: "Elevator connecting all decks",
        support_2: "Cabin rộng 90cm cho xe lăn", support_2_en: "90cm wide wheelchair cabin",
        support_3: "Nhân viên y tế & Cáng", support_3_en: "Medical officer & stretcher",
        warning: "Lối lên boong tàu hơi dốc (5.5%) khi thủy triều xuống.", warning_en: "Boarding ramp sloped at 5.5% during low tide.",
        specs: { slope_val: "5.5% (Chuẩn ≤ 8.0%)", slope_val_en: "5.5% (Standard ≤ 8.0%)", slope_desc: "Rất thoải, xe lăn tự đẩy không bị mất sức.", slope_desc_en: "Very gentle slope, manual wheelchairs can move effortlessly.", door_val: "85 cm", door_val_en: "85 cm", door_desc: "Đảm bảo mọi loại xe lăn tiêu chuẩn quay đầu.", door_desc_en: "Ensures all standard wheelchairs can turn.", elevator_val: "0 Bậc thềm", elevator_val_en: "Step-free", elevator_desc: "Thang máy rộng rãi.", elevator_desc_en: "Spacious elevator.", wc_val: "Tay vịn + Ghế tắm", wc_val_en: "Grab bars + Shower seat", wc_desc: "Sàn nhám chống trượt, chuông khẩn cấp.", wc_desc_en: "Anti-slip floor, emergency cord." },
        reviews: [
            { id: 101, avatar: "NM", color: "#0f766e", maskedName: "N***h", group: "Đi cùng người cao tuổi", stars: 5, date: "2026-10-18", content: "Thang máy trên du thuyền cực kỳ êm. Cứ đi khoảng 50m lại có ghế tựa lưng.", images: ["https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=400&q=80"], helpful: 124 },
            { id: 102, avatar: "TH", color: "#3b82f6", maskedName: "T***à", group: "Người sử dụng xe lăn", stars: 5, date: "2026-10-12", content: "Cửa nhà tắm rộng đúng 85cm như mô tả, xe lăn quay đầu thoải mái.", images: [], helpful: 89 },
            { id: 103, avatar: "ĐK", color: "#d97706", maskedName: "Đ***n", group: "Đi cùng người cao tuổi", stars: 4, date: "2026-09-28", content: "Độ dốc 5.5% đúng y như thông số, nhưng nhà hàng buffet hơi đông.", images: [], helpful: 45 },
            { id: 104, avatar: "HL", color: "#ef4444", maskedName: "H***g", group: "Dùng khung tập đi", stars: 2, date: "2026-09-15", content: "Lối ra boong đuôi tàu ướt mưa không có thảm, mẹ tôi bị trượt nhẹ.", images: [], helpful: 210 },
            { id: 105, avatar: "VA", color: "#8b5cf6", maskedName: "V***A", group: "Khuyết tật vận động", stars: 5, date: "2026-10-22", content: "Tuyệt vời! 10 điểm không có nhưng.", images: [], helpful: 12 },
            { id: 106, avatar: "BL", color: "#64748b", maskedName: "B***L", group: "Người cao tuổi", stars: 3, date: "2026-08-10", content: "Mọi thứ ổn, giá hơi cao.", images: [], helpful: 56 },
            { id: 107, avatar: "CQ", color: "#14b8a6", maskedName: "C***Q", group: "Người cao tuổi", stars: 1, date: "2026-07-05", content: "Hôm đó tàu bảo trì thang máy đột xuất không báo trước! Rất tệ.", images: [], helpful: 342 }
        ]
    },
    {
        id: 2, slug: "sapa-topas-ecolodge", title: "Khu nghỉ dưỡng Topas Ecolodge", title_en: "Topas Ecolodge Sapa",
        address: "Sapa, Lào Cai", address_en: "Sapa, Lao Cai",
        image: "https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1000&q=80",
        slots: 5, price: 4500000, badge_text: "✔ Đã xác minh 100%", badge_text_en: "✔ 100% Verified", badge_bg: "#dcfce7", badge_color: "#166534",
        tags: ["low_slope", "wc", "elderly"],
        support_1: "Xe điện nội khu gầm thấp", support_1_en: "Low-floor internal buggy",
        support_2: "Băng ghế nghỉ mỗi 30m", support_2_en: "Rest benches every 30m",
        support_3: "Hỗ trợ đẩy xe lăn", support_3_en: "Wheelchair pushing assist",
        warning: "Địa hình đồi núi nên có sương mù gây trơn trượt nhẹ.", warning_en: "Hilly terrain; fog can cause slight slipperiness.",
        specs: { slope_val: "6.5%", slope_val_en: "6.5%", slope_desc: "Lát đá nhám.", slope_desc_en: "Textured stone.", door_val: "86 cm", door_val_en: "86 cm", door_desc: "Rộng rãi.", door_desc_en: "Spacious.", elevator_val: "Xe điện", elevator_val_en: "Buggy", elevator_desc: "Chở tận nơi.", elevator_desc_en: "Drop off at door.", wc_val: "Sưởi sàn", wc_val_en: "Heated floor", wc_desc: "Chống trượt.", wc_desc_en: "Anti-slip." },
        reviews: [
            { id: 201, avatar: "VQ", color: "#0f766e", maskedName: "V***n", group: "Đi cùng người cao tuổi", stars: 5, date: "2026-10-02", content: "Phòng tắm có sưởi sàn ấm áp cực kỳ hợp với người già.", images: [], helpful: 18 }
        ]
    },
    { id: 3, slug: "ninh-binh-trang-an", title: "Khu sinh thái Tràng An", address: "Ninh Bình", image: "https://images.unsplash.com/photo-1627914026362-e64dbfecf605?auto=format&fit=crop&w=600&q=80", rating: 4.5, slots: 22, support_1: "Bến thuyền có bục", support_2: "Thuyền ghế đệm", support_3: "Nhân viên hỗ trợ", price: 250000, badge_text: "⚠ Xác minh một phần", badge_bg: "#fef3c7", badge_color: "#b45309", tags: ["elderly"], reviews: [] },
    { id: 4, slug: "vinh-phuc-flamingo", title: "Flamingo Đại Lải Resort", address: "Vĩnh Phúc", image: "https://images.unsplash.com/photo-1580977276076-ae4b8c219b8e?auto=format&fit=crop&w=600&q=80", rating: 4.9, slots: 4, support_1: "Villa tầng trệt", support_2: "Xe buggy điện", support_3: "Nút gọi y tế", price: 3500000, badge_text: "✔ Đã xác minh 100%", badge_bg: "#dcfce7", badge_color: "#166534", tags: ["wheelchair", "elderly"], reviews: [] },
    { id: 5, slug: "sapa-fansipan", title: "Cáp treo Fansipan Legend", address: "Sapa, Lào Cai", image: "https://images.unsplash.com/photo-1596710646193-470559f3c706?auto=format&fit=crop&w=600&q=80", rating: 4.7, slots: 15, support_1: "Cabin dừng chậm", support_2: "Thang máy", support_3: "Bình oxy y tế", price: 800000, badge_text: "✔ Đã xác minh 100%", badge_bg: "#dcfce7", badge_color: "#166534", tags: ["wheelchair", "elevator"], reviews: [] },
    { id: 6, slug: "ha-noi-lang-bac", title: "Lăng Chủ tịch Hồ Chí Minh", address: "Hà Nội", image: "https://images.unsplash.com/photo-1583417311756-3bb1dcb301f2?auto=format&fit=crop&w=600&q=80", rating: 4.9, slots: 50, support_1: "Lối ưu tiên", support_2: "Đường cao su", support_3: "Cảnh vệ hỗ trợ", price: 0, badge_text: "✔ Đã xác minh 100%", badge_bg: "#dcfce7", badge_color: "#166534", tags: ["wheelchair", "elderly"], reviews: [] },
    { id: 7, slug: "ninh-binh-bai-dinh", title: "Chùa Bái Đính", address: "Ninh Bình", image: "https://images.unsplash.com/photo-1601007204128-4b77f9cbbf1e?auto=format&fit=crop&w=600&q=80", rating: 4.6, slots: 30, support_1: "Dốc thoải", support_2: "Xe điện", support_3: "Thang máy", price: 200000, badge_text: "⚠ Xác minh một phần", badge_bg: "#fef3c7", badge_color: "#b45309", tags: ["elderly", "elevator"], reviews: [] },
    { id: 8, slug: "ha-noi-bat-trang", title: "Làng gốm Bát Tràng", address: "Hà Nội", image: "https://images.unsplash.com/photo-1562947116-3e74ff5187e1?auto=format&fit=crop&w=600&q=80", rating: 4.4, slots: 20, support_1: "Đường bê tông", support_2: "Thang cuốn", support_3: "Ghế nghỉ", price: 150000, badge_text: "⚠ Xác minh một phần", badge_bg: "#fef3c7", badge_color: "#b45309", tags: ["elderly"], reviews: [] },
    { id: 9, slug: "ha-noi-bao-tang-phu-nu", title: "Bảo tàng Phụ nữ Việt Nam", address: "Hà Nội", image: "https://images.unsplash.com/photo-1582559938554-15f16e10eb9f?auto=format&fit=crop&w=600&q=80", rating: 4.8, slots: 40, support_1: "Thang máy", support_2: "Audio guide", support_3: "Cửa tự động", price: 40000, badge_text: "✔ Đã xác minh 100%", badge_bg: "#dcfce7", badge_color: "#166534", tags: ["wheelchair", "elderly"], reviews: [] },
    { id: 10, slug: "sapa-muong-hoa", title: "Tàu hỏa leo núi Mường Hoa", address: "Lào Cai", image: "https://images.unsplash.com/photo-1518177583699-2708d7486e42?auto=format&fit=crop&w=600&q=80", rating: 4.7, slots: 10, support_1: "Thang máy", support_2: "Chỗ cố định xe lăn", support_3: "Khoảng nghỉ", price: 150000, badge_text: "✔ Đã xác minh 100%", badge_bg: "#dcfce7", badge_color: "#166534", tags: ["wheelchair"], reviews: [] },
    // MIỀN TRUNG
    { id: 11, slug: "hue-dai-noi", title: "Quần thể Di tích Cố đô Huế", address: "Thừa Thiên Huế", image: "https://images.unsplash.com/photo-1569154941061-e231b4725ef1?auto=format&fit=crop&w=600&q=80", rating: 4.7, slots: 25, support_1: "Dốc thoải", support_2: "Bóng râm", support_3: "Xe điện", price: 850000, badge_text: "⚠ Xác minh một phần", badge_bg: "#fef3c7", badge_color: "#b45309", tags: ["elderly"], reviews: [] },
    { id: 12, slug: "quang-nam-hoiana", title: "Hoiana Resort & Golf", address: "Quảng Nam", image: "https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=600&q=80", rating: 4.9, slots: 3, support_1: "Nâng hạ thủy lực", support_2: "Tay vịn inox", support_3: "Bác sĩ", price: 5200000, badge_text: "✔ Đã xác minh 100%", badge_bg: "#dcfce7", badge_color: "#166534", tags: ["wheelchair", "medical"], reviews: [] },
    { id: 13, slug: "da-nang-bana", title: "Sun World Ba Na Hills", address: "Đà Nẵng", image: "https://images.unsplash.com/photo-1593504381045-891cc773e34b?auto=format&fit=crop&w=600&q=80", rating: 4.8, slots: 15, support_1: "Cáp treo rộng", support_2: "Thang máy", support_3: "Trạm sơ cứu", price: 1150000, badge_text: "✔ Đã xác minh 100%", badge_bg: "#dcfce7", badge_color: "#166534", tags: ["wheelchair", "elevator"], reviews: [] },
    { id: 14, slug: "quang-nam-vinwonders", title: "VinWonders Nam Hội An", address: "Quảng Nam", image: "https://images.unsplash.com/photo-1542152648-936653246ebc?auto=format&fit=crop&w=600&q=80", rating: 4.8, slots: 30, support_1: "Đường phẳng", support_2: "Nhà WC chuẩn", support_3: "Phòng y tế", price: 700000, badge_text: "✔ Đã xác minh 100%", badge_bg: "#dcfce7", badge_color: "#166534", tags: ["wheelchair", "elderly"], reviews: [] },
    { id: 15, slug: "da-lat-thung-lung-tinh-yeu", title: "Thung lũng Tình Yêu", address: "Đà Lạt", image: "https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80", rating: 4.6, slots: 18, support_1: "Đường bê tông", support_2: "Mái che", support_3: "Nhân viên hỗ trợ", price: 650000, badge_text: "⚠ Xác minh một phần", badge_bg: "#fef3c7", badge_color: "#b45309", tags: ["elderly"], reviews: [] },
    { id: 16, slug: "da-nang-intercon", title: "InterContinental Danang", address: "Đà Nẵng", image: "https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?auto=format&fit=crop&w=600&q=80", rating: 5.0, slots: 2, support_1: "Nam Tram", support_2: "Phòng chuẩn", support_3: "Quản gia", price: 12000000, badge_text: "✔ Đã xác minh 100%", badge_bg: "#dcfce7", badge_color: "#166534", tags: ["wheelchair", "elderly"], reviews: [] },
    { id: 17, slug: "hoi-an-pho-co", title: "Phố cổ Hội An (Tour)", address: "Hội An", image: "https://images.unsplash.com/photo-1574227492706-f65b24c3688a?auto=format&fit=crop&w=600&q=80", rating: 4.5, slots: 20, support_1: "Lối phẳng", support_2: "Xe điện", support_3: "Hỗ trợ lên xuống", price: 300000, badge_text: "⚠ Xác minh một phần", badge_bg: "#fef3c7", badge_color: "#b45309", tags: ["elderly"], reviews: [] },
    { id: 18, slug: "da-nang-mikazuki", title: "Mikazuki Japanese Resorts", address: "Đà Nẵng", image: "https://images.unsplash.com/photo-1610641818989-c2051b5e2cfd?auto=format&fit=crop&w=600&q=80", rating: 4.8, slots: 8, support_1: "Thang máy", support_2: "Ghế Onsen", support_3: "Dốc 5%", price: 2800000, badge_text: "✔ Đã xác minh 100%", badge_bg: "#dcfce7", badge_color: "#166534", tags: ["wheelchair", "elevator"], reviews: [] },
    { id: 19, slug: "nha-trang-thap-ba", title: "Tắm bùn Tháp Bà", address: "Nha Trang", image: "https://images.unsplash.com/photo-1519449556851-d720047dd38c?auto=format&fit=crop&w=600&q=80", rating: 4.6, slots: 12, support_1: "Tay vịn inox", support_2: "Bục chuyển", support_3: "Cứu hộ", price: 450000, badge_text: "⚠ Xác minh một phần", badge_bg: "#fef3c7", badge_color: "#b45309", tags: ["elderly"], reviews: [] },
    { id: 20, slug: "nha-trang-ponagar", title: "Tháp Ponagar", address: "Nha Trang", image: "https://images.unsplash.com/photo-1598284617154-1506509f6e07?auto=format&fit=crop&w=600&q=80", rating: 4.3, slots: 25, support_1: "Tầng trệt phẳng", support_2: "Yên tĩnh", support_3: "Kiệu (đặt trước)", price: 30000, badge_text: "⚠ Khó khăn xe lăn", badge_bg: "#fee2e2", badge_color: "#991b1b", tags: ["elderly"], reviews: [] },
    // MIỀN NAM
    { id: 21, slug: "phu-quoc-safari", title: "Vinpearl Safari Phú Quốc", address: "Kiên Giang", image: "https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=600&q=80", rating: 4.8, slots: 9, support_1: "Xe bus gầm thấp", support_2: "Ưu tiên", support_3: "Thuê xe lăn", price: 2800000, badge_text: "✔ Đã xác minh 100%", badge_bg: "#dcfce7", badge_color: "#166534", tags: ["wheelchair", "elderly"], reviews: [] },
    { id: 22, slug: "hcm-bao-tang-chung-tich", title: "Bảo tàng Chứng tích", address: "TP.HCM", image: "https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=600&q=80", rating: 4.6, slots: 50, support_1: "Dốc thoải", support_2: "Tai nghe", support_3: "Thang máy", price: 40000, badge_text: "✔ Đã xác minh 100%", badge_bg: "#dcfce7", badge_color: "#166534", tags: ["elevator", "elderly"], reviews: [] },
    { id: 23, slug: "hcm-dinh-doc-lap", title: "Dinh Độc Lập", address: "TP.HCM", image: "https://images.unsplash.com/photo-1583417311756-3bb1dcb301f2?auto=format&fit=crop&w=600&q=80", rating: 4.7, slots: 40, support_1: "Thang máy", support_2: "Đường nhựa", support_3: "Xe điện", price: 65000, badge_text: "✔ Đã xác minh 100%", badge_bg: "#dcfce7", badge_color: "#166534", tags: ["wheelchair", "elevator"], reviews: [] },
    { id: 24, slug: "phu-quoc-hon-thom", title: "Cáp treo Hòn Thơm", address: "Phú Quốc", image: "https://images.unsplash.com/photo-1596710646193-470559f3c706?auto=format&fit=crop&w=600&q=80", rating: 4.9, slots: 20, support_1: "Cabin chậm", support_2: "Nhân viên dìu", support_3: "Trạm y tế", price: 600000, badge_text: "✔ Đã xác minh 100%", badge_bg: "#dcfce7", badge_color: "#166534", tags: ["wheelchair", "medical"], reviews: [] },
    { id: 25, slug: "hcm-landmark-81", title: "Landmark 81 Skyview", address: "TP.HCM", image: "https://images.unsplash.com/photo-1557053910-d7a8d46e3a6a?auto=format&fit=crop&w=600&q=80", rating: 4.8, slots: 15, support_1: "Thang êm", support_2: "Không gờ", support_3: "Ưu tiên", price: 500000, badge_text: "✔ Đã xác minh 100%", badge_bg: "#dcfce7", badge_color: "#166534", tags: ["wheelchair", "elevator"], reviews: [] },
    { id: 26, slug: "can-tho-victoria", title: "Victoria Cần Thơ Resort", address: "Cần Thơ", image: "https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=600&q=80", rating: 4.8, slots: 6, support_1: "Lối gỗ", support_2: "Tầng trệt", support_3: "Lên thuyền", price: 2500000, badge_text: "✔ Đã xác minh 100%", badge_bg: "#dcfce7", badge_color: "#166534", tags: ["elderly"], reviews: [] },
    { id: 27, slug: "hcm-can-gio", title: "Khu sinh thái Cần Giờ", address: "TP.HCM", image: "https://images.unsplash.com/photo-1627914026362-e64dbfecf605?auto=format&fit=crop&w=600&q=80", rating: 4.4, slots: 20, support_1: "Cầu phao", support_2: "Không bậc", support_3: "Xe điện", price: 150000, badge_text: "⚠ Xác minh một phần", badge_bg: "#fef3c7", badge_color: "#b45309", tags: ["elderly"], reviews: [] },
    { id: 28, slug: "vung-tau-marina", title: "Bến du thuyền Marina", address: "Vũng Tàu", image: "https://images.unsplash.com/photo-1562947116-3e74ff5187e1?auto=format&fit=crop&w=600&q=80", rating: 4.5, slots: 15, support_1: "Cầu phẳng", support_2: "Ghế nghỉ", support_3: "Hỗ trợ", price: 100000, badge_text: "⚠ Xác minh một phần", badge_bg: "#fef3c7", badge_color: "#b45309", tags: ["elderly"], reviews: [] },
    { id: 29, slug: "phu-quoc-jw-marriott", title: "JW Marriott Phú Quốc", address: "Phú Quốc", image: "https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=600&q=80", rating: 5.0, slots: 4, support_1: "Buggy", support_2: "Accessible Room", support_3: "Chuông y tế", price: 8500000, badge_text: "✔ Đã xác minh 100%", badge_bg: "#dcfce7", badge_color: "#166534", tags: ["wheelchair", "medical"], reviews: [] },
    { id: 30, slug: "hcm-nguyen-hue", title: "Phố đi bộ Nguyễn Huệ", address: "TP.HCM", image: "https://images.unsplash.com/photo-1582559938554-15f16e10eb9f?auto=format&fit=crop&w=600&q=80", rating: 4.7, slots: 100, support_1: "Đá siêu phẳng", support_2: "Bục vuốt", support_3: "An ninh", price: 0, badge_text: "✔ Đã xác minh 100%", badge_bg: "#dcfce7", badge_color: "#166534", tags: ["wheelchair", "elderly"], reviews: [] }
];

// ============================================================================
// 3. CÁC HÀM TIỆN ÍCH
// ============================================================================
function t(key, params = {}) {
    let str = (LOCALES[getLang()] && LOCALES[getLang()][key]) || LOCALES["vi"][key] || key;
    Object.keys(params).forEach(k => { str = str.replace(`{${k}}`, params[k]); });
    return str;
}

function getDestinationStats(dest) {
    const reviews = dest.reviews || [];
    const total = reviews.length;
    if (total === 0) return { avg: "5.0", total: 0, dist: {5:100, 4:0, 3:0, 2:0, 1:0}, counts: {5:0,4:0,3:0,2:0,1:0} };
    const sum = reviews.reduce((acc, r) => acc + r.stars, 0);
    const avg = (sum / total).toFixed(1);
    const counts = { 5: 0, 4: 0, 3: 0, 2: 0, 1: 0 };
    reviews.forEach(r => { counts[r.stars] = (counts[r.stars] || 0) + 1; });
    return { avg, total, counts };
}

function formatCurrency(vnd) {
    if (getLang() === "en") return "VND " + Number(vnd).toLocaleString("en-US");
    return Number(vnd).toLocaleString("vi-VN") + " đ";
}
function formatDate(isoDate) {
    const d = new Date(isoDate);
    if (isNaN(d)) return isoDate;
    if (getLang() === "en") return d.toLocaleDateString("en-US", { year: "numeric", month: "short", day: "2-digit" });
    return d.toLocaleDateString("vi-VN", { day: "2-digit", month: "2-digit", year: "numeric" });
}
function removeVietnameseTones(str) {
    return (str || "").normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/đ/g, "d").replace(/Đ/g, "D").toLowerCase();
}
function getField(obj, field) {
    if (getLang() === "en" && obj[field + "_en"] && obj[field + "_en"].trim() !== "") return obj[field + "_en"];
    return obj[field] || "";
}

// ============================================================================
// 4. DANH SÁCH 30 ĐIỂM ĐẾN PHÂN TRANG
// ============================================================================
let currentPage = 1;
const itemsPerPage = 6; 
let searchKeyword = "";
let activeFilterChips = new Set();

function renderDestinationsPaginated() {
    const container = document.getElementById('destinationList');
    if(!container) return;

    const cleanQ = removeVietnameseTones(searchKeyword.trim());
    let filtered = DESTINATIONS_DB.filter(d => {
        const matchText = cleanQ === "" || removeVietnameseTones(d.title + " " + d.address).includes(cleanQ);
        const matchTags = Array.from(activeFilterChips).every(tag => d.tags && d.tags.includes(tag));
        return matchText && matchTags;
    });

    if (filtered.length === 0) {
        container.innerHTML = `<div style="grid-column: 1/-1; text-align:center; padding: 40px;">Không tìm thấy điểm đến nào phù hợp.</div>`;
        document.getElementById('paginationContainer').innerHTML = '';
        return;
    }

    const totalPages = Math.ceil(filtered.length / itemsPerPage);
    if(currentPage > totalPages) currentPage = 1;

    const startIndex = (currentPage - 1) * itemsPerPage;
    const currentTours = filtered.slice(startIndex, startIndex + itemsPerPage);

    container.innerHTML = currentTours.map(item => {
        const title = getField(item, "title");
        const address = getField(item, "address");
        const stats = getDestinationStats(item);
        const badge = getField(item, "badge_text");
        return `
        <div class="dest-card tour-card" style="border: 1px solid #cbd5e1; border-radius: 16px; overflow: hidden; background: #fff; padding-bottom: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); transition: 0.2s;">
            <div style="position: relative; height: 200px; overflow: hidden; background: #e2e8f0;">
                <img src="${item.image}" style="width: 100%; height: 100%; object-fit: cover;" alt="${title}">
                <div style="position: absolute; top: 12px; left: 12px; background: ${item.badge_bg}; color: ${item.badge_color}; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 700; border: 1px solid rgba(0,0,0,0.05);">
                    ${badge}
                </div>
                <div style="position: absolute; bottom: 12px; right: 12px; background: #0f766e; color: #fff; padding: 4px 10px; border-radius: 6px; font-size: 13px; font-weight: 700;">Còn ${item.slots} suất</div>
            </div>
            <div style="padding: 16px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                    <h3 style="margin: 0; font-size: 17px; font-weight: 800; color: #0f172a; line-height: 1.3;">${title}</h3>
                    <span style="color: #f59e0b; font-weight: 800; font-size: 14px; white-space: nowrap;">★ ${stats.avg}</span>
                </div>
                <div style="font-size: 13px; color: #475569; font-weight: 600; margin-bottom: 16px;">📍 ${address}</div>
                <div style="background: #f8fafc; padding: 12px; border-radius: 10px; font-size: 13px; color: #475569; margin-bottom: 16px; border: 1px solid #f1f5f9;">
                    <div style="margin-bottom: 6px;"><strong>🤝 Hỗ trợ:</strong> ${getField(item, "support_1")}</div>
                    <div style="margin-bottom: 6px;"><strong>🛋️ Nghỉ chân:</strong> ${getField(item, "support_2")}</div>
                    <div><strong>🧑‍⚕️ Nhân viên:</strong> ${getField(item, "support_3")}</div>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <strong style="color: #0f766e; font-size: 18px;">${formatCurrency(item.price)}</strong>
                    <div style="display: flex; gap: 8px;">
                        <a href="detail.html?id=${item.id}" style="background: #f1f5f9; color: #0f766e; border: 1.5px solid #cbd5e1; padding: 8px 12px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 700;">Thẩm định</a>
                        <a href="booking.html?id=${item.id}&title=${encodeURIComponent(title)}&price=${item.price}" style="background: #0f766e; color: #fff; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 700;">Đặt chỗ</a>
                    </div>
                </div>
            </div>
        </div>
        `;
    }).join('');

    renderPagination(totalPages);
}

function renderPagination(totalPages) {
    const container = document.getElementById('paginationContainer');
    if(!container) return;
    let html = '';
    for(let i = 1; i <= totalPages; i++) {
        if(i === currentPage) {
            html += `<button onclick="goToPage(${i})" style="background:#0f766e; color:#fff; border:none; width:40px; height:40px; border-radius:8px; font-weight:800; cursor:pointer; transition:0.2s;">${i}</button>`;
        } else {
            html += `<button onclick="goToPage(${i})" style="background:#fff; border:1px solid #cbd5e1; color:#475569; width:40px; height:40px; border-radius:8px; font-weight:800; cursor:pointer; transition:0.2s;">${i}</button>`;
        }
    }
    container.innerHTML = html;
}

function goToPage(page) {
    currentPage = page; 
    renderDestinationsPaginated(); 
    document.getElementById('destinationList').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// ============================================================================
// 5. SHOPEE REVIEW TỰ ĐỘNG
// ============================================================================
let currentReviewFilter = "all";
let currentReviewSort = "helpful"; 
let visibleReviewCount = 4;
let helpfulClickedSet = new Set();
let activeReviewsPool = [];

function getAllPlatformReviews() {
    let all = [];
    DESTINATIONS_DB.forEach(d => {
        (d.reviews || []).forEach(r => {
            all.push({ ...r, destTitle: getField(d, "title"), destSlug: d.slug });
        });
    });
    return all;
}

function renderShopeeReviews(reviewsArray) {
    activeReviewsPool = reviewsArray;
    const root = document.getElementById("shopeeReviewSection");
    if (!root) return;

    const total = reviewsArray.length;
    const sum = reviewsArray.reduce((acc, r) => acc + r.stars, 0);
    const avg = total > 0 ? (sum / total).toFixed(1) : "5.0";
    const counts = { 5: 0, 4: 0, 3: 0, 2: 0, 1: 0, img: 0, cmt: 0 };
    reviewsArray.forEach(r => {
        counts[r.stars] = (counts[r.stars] || 0) + 1;
        if (r.images && r.images.length > 0) counts.img++;
        if (r.content && r.content.trim().length > 0) counts.cmt++;
    });

    let filtered = reviewsArray.filter(r => {
        if (currentReviewFilter === "all") return true;
        if (currentReviewFilter === "img") return r.images && r.images.length > 0;
        if (currentReviewFilter === "cmt") return r.content && r.content.trim().length > 0;
        return r.stars === Number(currentReviewFilter);
    });

    filtered.sort((a, b) => {
        if (currentReviewSort === "newest") return new Date(b.date) - new Date(a.date);
        const aHelp = a.helpful + (helpfulClickedSet.has(a.id) ? 1 : 0);
        const bHelp = b.helpful + (helpfulClickedSet.has(b.id) ? 1 : 0);
        return bHelp - aHelp;
    });

    const displayed = filtered.slice(0, visibleReviewCount);

    root.innerHTML = `
        <style>
            .sort-row { display: flex; align-items: center; gap: 12px; margin-bottom: 24px; padding: 16px 20px; background: #f1f5f9; border-radius: 12px; }
            .btn-sort { background: #fff; border: 1px solid #cbd5e1; color: #334155; padding: 8px 16px; border-radius: 8px; font-size: 15px; font-weight: 700; cursor: pointer; transition: 0.2s; }
            .btn-sort.active { background: #0f766e; color: #fff; border-color: #0f766e; }
        </style>
        <div class="shopee-overview-box">
            <div class="shopee-score-col">
                <div class="shopee-big-score">${avg} <span style="font-size:22px; font-weight:700; color:#475569;">/ 5</span></div>
                <div class="shopee-stars">★★★★★</div>
                <div style="font-size:16px; font-weight:700; color:#475569; margin-bottom:14px;">${total} Đánh giá</div>
                <div class="shopee-bars">
                    ${[5,4,3,2,1].map(star => {
                        const pct = total > 0 ? Math.round((counts[star] / total) * 100) : 0;
                        return `<div class="tp-bar-row"><span style="width:48px;">${star} ★</span><div class="tp-bar-bg"><div class="tp-bar-fill" style="width:${pct}%;"></div></div><span style="width:42px; text-align:right;">${pct}%</span></div>`;
                    }).join("")}
                </div>
            </div>
            <div class="shopee-filter-col">
                <div class="shopee-chip-row">
                    ${buildShopeeChip("all", `Tất cả (${total})`)}
                    ${buildShopeeChip("5", `5 Sao (${counts[5]})`)}
                    ${buildShopeeChip("4", `4 Sao (${counts[4]})`)}
                    ${buildShopeeChip("3", `3 Sao (${counts[3]})`)}
                    ${buildShopeeChip("2", `2 Sao (${counts[2]})`)}
                    ${buildShopeeChip("1", `1 Sao (${counts[1]})`)}
                    ${buildShopeeChip("img", `Có Hình Ảnh (${counts.img})`)}
                    ${buildShopeeChip("cmt", `Có Bình Luận (${counts.cmt})`)}
                </div>
            </div>
        </div>
        <div class="sort-row">
            <span style="font-weight:700;">Sắp xếp theo:</span>
            <button class="btn-sort ${currentReviewSort === 'helpful' ? 'active' : ''}" onclick="setShopeeSort('helpful')">Được thích nhiều nhất</button>
            <button class="btn-sort ${currentReviewSort === 'newest' ? 'active' : ''}" onclick="setShopeeSort('newest')">Mới nhất</button>
        </div>
        <div class="shopee-review-list">
            ${displayed.length === 0 ? `<div style="text-align:center; padding:40px; font-weight:600;">Chưa có đánh giá nào.</div>` : displayed.map(r => buildSingleReviewHTML(r)).join("")}
        </div>
        ${filtered.length > visibleReviewCount ? `<div style="text-align:center; margin-top:24px;"><button onclick="loadMoreReviews()" class="btn-load-more-rv"><i class="fa-solid fa-chevron-down"></i> Xem thêm ${filtered.length - visibleReviewCount} đánh giá</button></div>` : ""}
    `;
}

function buildShopeeChip(key, label) {
    const isActive = String(currentReviewFilter) === String(key);
    return `<button type="button" class="shopee-chip ${isActive ? 'active' : ''}" onclick="setShopeeFilter('${key}')">${ isActive ? '<i class="fa-solid fa-check"></i> ' : '' }${label}</button>`;
}

function buildSingleReviewHTML(r) {
    const starsStr = "★".repeat(r.stars) + "☆".repeat(5 - r.stars);
    const isLiked = helpfulClickedSet.has(r.id);
    const helpfulCount = r.helpful + (isLiked ? 1 : 0);

    return `
        <article class="tp-review-item">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:10px;">
                <div style="display:flex; gap:14px; align-items:center;">
                    <div class="tp-avatar" style="background:${r.color || '#0f766e'};">${r.avatar}</div>
                    <div>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <strong style="font-size:18px; color:#0f172a;">${r.maskedName}</strong>
                            <span class="verified-trip-badge"><i class="fa-solid fa-circle-check"></i> Đã xác minh</span>
                        </div>
                        <div style="color:#f59e0b; font-size:18px; margin-top:2px;">${starsStr}</div>
                    </div>
                </div>
                <div style="font-size:15px; color:#64748b; font-weight:600;">${formatDate(r.date)}</div>
            </div>
            <div style="font-size:14px; color:#64748b; background:#e2e8f0; display:inline-block; padding:4px 12px; border-radius:8px; font-weight:700; margin-bottom:12px;">👥 Khách: ${r.group}</div>
            <p style="margin:0 0 14px 0; color:#1e293b; font-size:17px; line-height:1.6; font-weight:500;">"${r.content}"</p>
            ${r.images && r.images.length > 0 ? `<div class="rv-img-grid">${r.images.map(imgUrl => `<img src="${imgUrl}" class="rv-img-thumb" style="width:80px; height:80px;" alt="Review">`).join("")}</div>` : ""}
            <div style="display:flex; justify-content:flex-end; margin-top:16px;">
                <button type="button" class="btn-helpful ${isLiked ? 'liked' : ''}" onclick="toggleHelpful(${r.id})"><i class="fa-solid fa-thumbs-up"></i> Hữu ích (${helpfulCount})</button>
            </div>
        </article>
    `;
}

function setShopeeFilter(key) { currentReviewFilter = key; visibleReviewCount = 4; renderShopeeReviews(activeReviewsPool); }
function setShopeeSort(type) { currentReviewSort = type; visibleReviewCount = 4; renderShopeeReviews(activeReviewsPool); }
function loadMoreReviews() { visibleReviewCount += 5; renderShopeeReviews(activeReviewsPool); }
function toggleHelpful(id) { helpfulClickedSet.has(id) ? helpfulClickedSet.delete(id) : helpfulClickedSet.add(id); renderShopeeReviews(activeReviewsPool); }

// ============================================================================
// KHỞI CHẠY TỔNG
// ============================================================================
document.addEventListener('DOMContentLoaded', () => {
    applyLanguage(getLang());
    
    // Nếu ở index.html
    if(document.getElementById('destinationList')) {
        renderDestinationsPaginated();
        renderShopeeReviews(getAllPlatformReviews());
    }
});