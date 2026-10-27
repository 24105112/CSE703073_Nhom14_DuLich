// ============================================================================
// BỘ TỪ ĐIỂN ĐA NGÔN NGỮ TỰ ĐỘNG CHO TOÀN BỘ WEBSITE
// ============================================================================
const DICTIONARY = {
    "en": {
        "Dịch vụ": "Services",
        "Bản tin": "Newsletter",
        "Về chúng tôi": "About Us",
        "Đăng nhập Đăng ký": "Log in / Sign up",
        "Đăng nhập": "Log in",
        "Du lịch Không Rào Cản Tại Việt Nam": "Barrier-Free Tourism in Vietnam",
        "Nền tảng OTA duy nhất kiểm định thực tế độ dốc xe lăn, thang máy và tiện ích người cao tuổi.": "The only OTA platform field-verifying wheelchair slopes, elevators, and senior facilities.",
        "Điểm Đến Đã Kiểm Định Thực Tế": "Field-Verified Destinations",
        "Du thuyền Ambassador Vịnh Hạ Long": "Ambassador Cruise Ha Long Bay",
        "Quảng Ninh, Việt Nam": "Quang Ninh, Vietnam",
        "Khu nghỉ dưỡng Topas Ecolodge": "Topas Ecolodge Resort",
        "Sapa, Lào Cai": "Sapa, Lao Cai",
        "Quần thể Di tích Cố đô Huế": "Hue Imperial Citadel Complex",
        "Thừa Thiên Huế, Việt Nam": "Thua Thien Hue, Vietnam",
        "Xem chi tiết →": "View Details →",
        "Gia nhập cộng đồng AccessTravel": "Join the AccessTravel Community",
        "Trở thành người đầu tiên nhận thông tin về các điểm đến trợ năng mới nhất, ưu đãi độc quyền và tin tức truyền cảm hứng du lịch.": "Be the first to get updates on accessible destinations, exclusive deals, and inspiring travel news.",
        "Tham gia ngay": "Join Now",
        "NHẬP ĐỊA CHỈ EMAIL CỦA BẠN TẠI ĐÂY": "ENTER YOUR EMAIL ADDRESS HERE",
        "Xác Nhận Đặt Lịch & Giữ Chỗ": "Confirm Booking & Hold Slot",
        "Thông tin khách hàng đại diện": "Lead Passenger Information",
        "Yêu cầu hạ tầng & Trợ năng đặc biệt": "Special Infrastructure & Accessibility Requests",
        "Tổng cộng": "Total",
        "Tiếp tục thanh toán": "Proceed to Payment",
        "Thanh toán an toàn": "Secure SSL Payment"
    }
};

// Hàm quét toàn bộ chữ trên trang và đổi ngôn ngữ tự động
function changeLanguage(lang) {
    localStorage.setItem('at_lang', lang);
    
    // Đổi hiển thị nút trên Header
    const btnFlag = document.getElementById('currentLangFlag');
    const btnText = document.getElementById('currentLangText');
    if(btnFlag && btnText) {
        if(lang === 'en') {
            btnFlag.src = "https://flagcdn.com/w20/us.png";
            btnText.innerText = "English";
        } else {
            btnFlag.src = "https://flagcdn.com/w20/vn.png";
            btnText.innerText = "Tiếng Việt";
        }
    }

    if (lang === 'vi') {
        window.location.reload(); // Quay lại tiếng Việt gốc
        return;
    }

    // Tự động quét và dịch mọi thẻ text trên web
    const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, null, false);
    let node;
    while (node = walker.nextNode()) {
        let text = node.nodeValue.trim();
        if (text && DICTIONARY['en'][text]) {
            node.nodeValue = node.nodeValue.replace(text, DICTIONARY['en'][text]);
        }
    }
    
    // Đóng Modal chọn ngôn ngữ nếu đang mở
    const modal = document.getElementById('langModal');
    if(modal) modal.style.display = 'none';
}

// Tự động chạy lại ngôn ngữ đã lưu khi load trang
document.addEventListener('DOMContentLoaded', () => {
    const savedLang = localStorage.getItem('at_lang');
    if (savedLang === 'en') {
        changeLanguage('en');
    }
});