<?php
$path = __DIR__ . '/frontend/index.html';
if(!file_exists($path)) die("Khong tim thay index.html");
$html = file_get_contents($path);

// Xóa bản JS bị lỗi mất bộ lọc
$html = preg_replace('/<script id="core-app-js">.*?<\/script>/is', '', $html);

$js = <<<'JS'
<script id="core-app-js">
const SAMPLE_IMAGES = [
    'https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=800&q=80'
];

const MOCK_DATA = [
    { id: 1, title: 'Du thuyền Trợ Năng 304', address: 'Phú Quốc, Việt Nam', price: 4150000, available_slots: 2, ramp_slope: 4.5, review_rating: 4.8, senior_support: 'Ghế nghỉ mỗi 50m & xe điện', rest_area: 'Khu nghỉ yên tĩnh', staff_support: 'Nhân viên y tế 24/7', verify_label: 'Đã xác minh thực tế' },
    { id: 2, title: 'Khu nghỉ dưỡng Cao Tuổi Hội An', address: 'Hội An, Quảng Nam', price: 1710000, available_slots: 5, ramp_slope: 5.0, review_rating: 4.9, senior_support: 'Lối đi xe lăn phủ khắp', rest_area: 'Phòng tầng trệt', staff_support: 'Hỗ trợ dìu khách', verify_label: 'Chuẩn Barrier-Free' },
    { id: 3, title: 'Chùa Bái Đính - Lối riêng', address: 'Ninh Bình, Việt Nam', price: 850000, available_slots: 0, ramp_slope: 6.0, review_rating: 4.6, senior_support: 'Xe điện đưa đón tận nơi', rest_area: 'Trạm nghỉ chân liên tục', staff_support: 'Có người đẩy xe lăn', verify_label: 'Đã xác minh thực tế' },
    { id: 4, title: 'Resort Trợ Năng 305', address: 'Huế, Việt Nam', price: 1370000, available_slots: 14, ramp_slope: 3.5, review_rating: 4.8, senior_support: 'Hỗ trợ y tế khẩn cấp', rest_area: 'Khu vực yên tĩnh', staff_support: 'Trực 24/7', verify_label: 'Đã xác minh' }
];

function selectBodyProfile(mode, btn) {
    document.querySelectorAll('.fit-pill').forEach(b => b.classList.remove('active'));
    if(btn) btn.classList.add('active');
    
    // Tự động điền bộ lọc theo thể trạng
    if (mode === 'senior') {
        if(document.getElementById('slopeSelect')) document.getElementById('slopeSelect').value = '8';
        if(document.getElementById('wheelchairCheck')) document.getElementById('wheelchairCheck').checked = false;
    } else if (mode === 'wheelchair') {
        if(document.getElementById('slopeSelect')) document.getElementById('slopeSelect').value = '6';
        if(document.getElementById('wheelchairCheck')) document.getElementById('wheelchairCheck').checked = true;
    } else {
        if(document.getElementById('slopeSelect')) document.getElementById('slopeSelect').value = '';
        if(document.getElementById('wheelchairCheck')) document.getElementById('wheelchairCheck').checked = false;
    }
    
    loadDestinations(1);
}

async function loadDestinations(page = 1) {
    const listContainer = document.getElementById('destinationList');
    const counter = document.getElementById('recordCounter');
    if(!listContainer) return;

    // 1. ĐỌC CHUẨN XÁC DỮ LIỆU TỪ BỘ LỌC
    const keyword = document.getElementById('keywordInput') ? document.getElementById('keywordInput').value.trim().toLowerCase() : '';
    const maxSlope = document.getElementById('slopeSelect') ? document.getElementById('slopeSelect').value : '';
    const sortVal = document.getElementById('sortSelect') ? document.getElementById('sortSelect').value : '';
    const hasWc = document.getElementById('wheelchairCheck') ? document.getElementById('wheelchairCheck').checked : false;

    listContainer.innerHTML = '<p style="grid-column:1/-1; text-align:center; padding:40px; font-weight:bold; color:#0f766e;">⏳ Đang phân tích bộ lọc và tải dữ liệu...</p>';

    let items = [];
    let totalRecords = 0;
    let isMock = false;

    try {
        // 2. GẮN ĐIỀU KIỆN LỌC VÀO API
        let url = `../api/search.php?page=${page}&limit=6`;
        if(keyword) url += `&keyword=${encodeURIComponent(keyword)}`;
        if(maxSlope) url += `&max_slope=${encodeURIComponent(maxSlope)}`;
        if(sortVal) url += `&sort=${encodeURIComponent(sortVal)}`;
        if(hasWc) url += `&has_wheelchair=1`;

        const res = await fetch(url, { signal: AbortSignal.timeout(3000) });
        if (!res.ok) throw new Error('API Error');
        const result = await res.json();
        
        if(result.data && Array.isArray(result.data)) {
            items = result.data;
            totalRecords = result.total_records !== undefined ? result.total_records : items.length;
        } else {
            throw new Error('Lỗi cấu trúc JSON');
        }
    } catch (err) {
        isMock = true;
        // 3. THUẬT TOÁN LỌC GIẢ LẬP (MOCK DATA FILTERING) SIÊU ĐỈNH
        let filteredMock = [...MOCK_DATA, ...MOCK_DATA, ...MOCK_DATA].map((m, i) => ({...m, id: i+1})); 
        
        if(keyword) {
            filteredMock = filteredMock.filter(m => m.title.toLowerCase().includes(keyword) || m.address.toLowerCase().includes(keyword));
        }
        if(maxSlope) {
            filteredMock = filteredMock.filter(m => m.ramp_slope <= parseFloat(maxSlope));
        }
        if(sortVal && sortVal.includes('asc')) {
            filteredMock.sort((a,b) => a.price - b.price);
        }
        if(sortVal && sortVal.includes('desc')) {
            filteredMock.sort((a,b) => b.price - a.price);
        }

        items = filteredMock;
        totalRecords = items.length;
    }

    // 4. PHÂN TRANG VÀ HIỂN THỊ
    let itemsPerPage = 6;
    let totalPages = Math.ceil(totalRecords / itemsPerPage) || 1;
    let displayItems = isMock ? items.slice((page - 1) * itemsPerPage, page * itemsPerPage) : items;
    
    // An toàn: nếu API trả về cục to chưa limit thì ta tự limit luôn
    if(!isMock && items.length > itemsPerPage) {
        displayItems = items.slice((page - 1) * itemsPerPage, page * itemsPerPage);
        totalPages = Math.ceil(items.length / itemsPerPage);
    }

    if(counter) {
        counter.innerHTML = `Trang ${page}/${totalPages} • ${totalRecords} điểm đến ${isMock ? '<span style="color:#dc2626; font-weight:bold;">(MOCK DATA)</span>' : 'phù hợp'}`;
    }

    if(displayItems.length === 0) {
        listContainer.innerHTML = '<p style="grid-column:1/-1; text-align:center; padding:40px; font-size:16px;">Không tìm thấy địa điểm phù hợp. Hãy thử chọn mức dốc thoải hơn hoặc bỏ bớt từ khóa.</p>';
        renderPagination(1, 1);
        return;
    }

    listContainer.innerHTML = displayItems.map((item, idx) => {
        const imgUrl = SAMPLE_IMAGES[item.id % SAMPLE_IMAGES.length];
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

document.addEventListener('DOMContentLoaded', () => {
    loadDestinations(1);
    
    // Gắn sự kiện cho nút Lọc
    const filterBtns = document.querySelectorAll('button');
    filterBtns.forEach(btn => {
        if(btn.innerText.includes('Lọc kết quả') || btn.innerText.includes('Lọc Kết Quả')) {
            btn.onclick = (e) => { e.preventDefault(); loadDestinations(1); };
        }
    });
});
</script>
JS;

$html = str_replace('</body>', $js . "\n</body>", $html);
file_put_contents($path,$html);
echo "=== DA KHOI PHUC TRANG THAI LOC! GIO LOC NHU THAT KE CA KHI MAT MANG! ===\n";
?>
