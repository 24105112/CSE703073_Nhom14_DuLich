<?php
$path = __DIR__ . '/frontend/index.html';
if(!file_exists($path)) die("Khong tim thay index.html");
$html = file_get_contents($path);

// Xóa trắng khối script hiển thị cũ đang bị lỗi do không bắt được lỗi Database
$html = preg_replace('/<script>\s*const SAMPLE_IMAGES.*?<\/script>/is', '', $html);$html = preg_replace('/<script id="core-app-js">.*?<\/script>/is', '', $html);

$js = <<<'JS'
<script id="core-app-js">
const SAMPLE_IMAGES = [
    'https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=800&q=80'
];

// DỮ LIỆU DỰ PHÒNG (MOCK DATA) - TỰ KÍCH HOẠT KHI MÁY BỊ LỖI DATABASE
const MOCK_DATA = [
    { id: 1, title: 'Du thuyền Trợ Năng 304', address: 'Phú Quốc, Việt Nam', price: 4150000, available_slots: 2, ramp_slope: 4.5, review_rating: 4.8, senior_support: 'Ghế nghỉ mỗi 50m & xe điện', rest_area: 'Khu nghỉ yên tĩnh', staff_support: 'Nhân viên y tế 24/7', verify_label: 'Đã xác minh thực tế' },
    { id: 2, title: 'Khu nghỉ dưỡng Cao Tuổi Hội An', address: 'Hội An, Quảng Nam', price: 1710000, available_slots: 5, ramp_slope: 5.0, review_rating: 4.9, senior_support: 'Lối đi xe lăn phủ khắp', rest_area: 'Phòng tầng trệt', staff_support: 'Hỗ trợ dìu khách', verify_label: 'Chuẩn Barrier-Free' },
    { id: 3, title: 'Chùa Bái Đính - Lối riêng', address: 'Ninh Bình, Việt Nam', price: 850000, available_slots: 0, ramp_slope: 6.0, review_rating: 4.6, senior_support: 'Xe điện đưa đón tận nơi', rest_area: 'Trạm nghỉ chân liên tục', staff_support: 'Có người đẩy xe lăn', verify_label: 'Đã xác minh thực tế' }
];

function selectBodyProfile(mode, btn) {
    document.querySelectorAll('.fit-pill').forEach(b => b.classList.remove('active'));
    if(btn) btn.classList.add('active');
    loadDestinations(1);
}

async function loadDestinations(page = 1) {
    const listContainer = document.getElementById('destinationList');
    const counter = document.getElementById('recordCounter');
    if(!listContainer) return;

    listContainer.innerHTML = '<p style="grid-column:1/-1; text-align:center; padding:40px; font-weight:bold; color:#0f766e;">⏳ Đang kết nối Server MySQL để tải dữ liệu...</p>';
    if(counter) counter.innerText = 'Đang tải dữ liệu...';

    let items = [];
    let totalPages = 1;
    let totalRecords = 0;
    let isMock = false;

    // Cố gắng gọi Database thật, nếu quá 3 giây không phản hồi hoặc lỗi -> Ném lỗi sang catch
    try {
        const res = await fetch(`../api/search.php?page=${page}&limit=6`, { signal: AbortSignal.timeout(3000) });
        if (!res.ok) throw new Error('API Error');
        const result = await res.json();
        if(result.data && Array.isArray(result.data)) {
            items = result.data;
            totalRecords = result.total_records || items.length;
        } else {
            throw new Error('Lỗi cấu trúc JSON từ PHP');
        }
    } catch (err) {
        console.warn("CẢNH BÁO: XAMPP chưa bật MySQL hoặc PHP lỗi. Kích hoạt Chế độ Offline An toàn!");
        isMock = true;
        // Nhân đôi mảng Mock Data để có dữ liệu cho bro test phân trang
        items = [...MOCK_DATA, ...MOCK_DATA]; 
        totalRecords = items.length;
    }

    // Xử lý Phân trang (Cắt mảng)
    let itemsPerPage = 6;
    let displayItems = items;
    if (items.length > itemsPerPage) {
        let startIndex = (page - 1) * itemsPerPage;
        displayItems = items.slice(startIndex, startIndex + itemsPerPage);
        totalPages = Math.ceil(items.length / itemsPerPage);
    } else if (items.length > 0) {
        totalPages = 1;
    }

    // Hiển thị trạng thái màu đỏ cảnh báo nếu đang dùng Mock Data
    if(counter) {
        counter.innerHTML = `Trang ${page}/${totalPages} • ${totalRecords} địa điểm ${isMock ? '<span style="color:#dc2626; font-weight:bold;">(Chế độ MOCK DATA - Offline)</span>' : 'đã kiểm định'}`;
    }

    listContainer.innerHTML = displayItems.map((item, idx) => {
        const imgUrl = SAMPLE_IMAGES[idx % SAMPLE_IMAGES.length];
        const slots = Number(item.available_slots || 0);
        let badge = `<span style="background:#0f766e; color:#fff; padding:4px 10px; border-radius:8px; font-size:12.5px; font-weight:700;">Còn ${slots} suất</span>`;
        if(slots===0) badge = `<span style="background:#64748b; color:#fff; padding:4px 10px; border-radius:8px; font-size:12.5px; font-weight:700;">Đã kín chỗ</span>`;
        
        return `
        <article style="border:1px solid #e2e8f0; border-radius:12px; overflow:hidden; background:#fff; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05); display:flex; flex-direction:column;">
            <div style="position:relative; height:200px;">
                <img src="${imgUrl}" style="width:100%; height:100%; object-fit:cover;" loading="lazy">
                <div style="position:absolute; top:12px; left:12px; background:#dcfce7; color:#166534; padding:4px 10px; border-radius:8px; font-size:12px; font-weight:bold;">✔ ${item.verify_label || 'Đã xác minh'}</div>
                <div style="position:absolute; bottom:12px; right:12px;">${badge}</div>
            </div>
            <div style="padding:16px; display:flex; flex-direction:column; flex:1;">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">
                    <h3 style="margin:0; font-size:18px; color:#0f172a; flex:1;">${item.title}</h3>
                    <span style="font-weight:700; color:#d97706; font-size:14px; white-space:nowrap; margin-left:8px;">★ ${item.review_rating || '4.8'}</span>
                </div>
                <p style="margin:0 0 12px; color:#64748b; font-size:13.5px;">📍 ${item.address}</p>
                <div style="background:#f8fafc; border:1px solid #f1f5f9; border-radius:8px; padding:10px; margin-bottom:16px; font-size:13px; line-height:1.6; flex:1;">
                    <div style="display:flex; gap:8px;"><span style="width:20px;">👴</span> <span><strong>Hỗ trợ:</strong> ${item.senior_support || 'Ghế nghỉ & xe điện'}</span></div>
                    <div style="display:flex; gap:8px; margin:1px 0;"><span style="width:20px;">🛋️</span> <span><strong>Nghỉ chân:</strong> ${item.rest_area || 'Khu vực yên tĩnh'}</span></div>
                    <div style="display:flex; gap:8px;"><span style="width:20px;">🧑‍⚕️</span> <span><strong>Nhân viên:</strong> ${item.staff_support || 'Trực 24/7'}</span></div>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:auto;">
                    <div style="color:#0f766e; font-weight:800; font-size:17px;">${Number(item.price || 0).toLocaleString('vi-VN')} đ</div>
                    <a href="booking.html?id=${item.id}" style="background:#0f766e; color:#fff; padding:8px 16px; border-radius:8px; text-decoration:none; font-size:14.5px; font-weight:700; transition:0.2s;">Đặt chỗ</a>
                </div>
            </div>
        </article>`;
    }).join('');

    renderPagination(totalPages, page);
}

function renderPagination(totalPages, activePage) {
    const container = document.getElementById('paginationControls');
    if(!container) return;
    container.innerHTML = '';
    if(totalPages <= 1) return;
    
    for (let i = 1; i <= Math.min(totalPages, 5); i++) {
        const btn = document.createElement('button');
        btn.innerText = 'Trang ' + i;
        btn.style.cssText = `margin:0 4px; padding:8px 14px; border-radius:8px; cursor:pointer; font-weight:700; font-size:14px; border:2px solid #0f766e; transition:0.2s; ${i === activePage ? 'background:#0f766e; color:#fff;' : 'background:#fff; color:#0f766e;'}`;
        btn.onclick = () => loadDestinations(i);
        container.appendChild(btn);
    }
}

document.addEventListener('DOMContentLoaded', () => loadDestinations(1));
</script>
JS;

$html = str_replace('</body>', $js . "\n</body>", $html);
file_put_contents($path,$html);
echo "=== DA CAY CO CHE AUTO-MOCK DATA! BAY GIO WEB CHAY BAT TU KHONG CAN MYSQL! ===\n";
?>
