<?php
$frontendDir = __DIR__ . '/frontend';
if (!is_dir($frontendDir)) mkdir($frontendDir, 0777, true);

$bookingFile = $frontendDir . '/booking.html';

// Tạo trang booking.html cơ bản nếu chưa có, hoặc đọc file cũ
if (!file_exists($bookingFile)) {
    $html = '<!DOCTYPE html><html lang="vi"><head><meta charset="UTF-8"><title>Đặt Chỗ | AccessTravel</title><style>body{font-family:system-ui; background:#f8fafc; margin:0; padding:20px;}</style></head><body><div style="max-width:800px; margin:auto; background:#fff; padding:20px; border-radius:12px;"><h2>Chi Tiết Điểm Đến & Đặt Chỗ</h2><p>Phần thông tin tour (Đã làm ở các bước trước)...</p></div></body></html>';
} else {
    $html = file_get_contents($bookingFile);
}

// Xóa module review cũ (nếu có) để tránh trùng lặp
$html = preg_replace('/<!-- ACCESSIBLE REVIEW MODULE -->.*?<!-- END ACCESSIBLE REVIEW MODULE -->/is', '', $html);

// Bộ code Giao diện Review Đặc thù
$reviewModule = <<<'HTML'
<!-- ACCESSIBLE REVIEW MODULE -->
<link href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" rel="stylesheet">
<style>
    .review-section { max-width: 800px; margin: 30px auto; background: #fff; padding: 30px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); font-family: system-ui, sans-serif; }
    .review-header { display: flex; gap: 30px; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #e2e8f0; }
    .overall-score { text-align: center; }
    .overall-score h1 { font-size: 48px; color: #0f172a; margin: 0; line-height: 1; }
    .overall-score .stars { color: #f59e0b; font-size: 20px; margin: 10px 0; }
    .overall-score p { margin: 0; color: #64748b; font-size: 14px; font-weight: 600; }
    
    .criteria-list { flex: 1; }
    .criteria-item { margin-bottom: 12px; }
    .criteria-label { display: flex; justify-content: space-between; font-size: 14px; font-weight: 700; color: #334155; margin-bottom: 6px; }
    .progress-bg { height: 8px; background: #e2e8f0; border-radius: 10px; overflow: hidden; }
    .progress-bar { height: 100%; background: #0f766e; border-radius: 10px; }
    
    .review-card { padding: 20px 0; border-bottom: 1px solid #f1f5f9; }
    .review-card:last-child { border-bottom: none; }
    .reviewer-info { display: flex; align-items: center; gap: 12px; margin-bottom: 10px; }
    .avatar { width: 40px; height: 40px; background: #0f766e; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px; }
    .reviewer-name { font-weight: 700; color: #0f172a; margin: 0; }
    .reviewer-tag { background: #dcfce7; color: #166534; font-size: 11px; padding: 2px 8px; border-radius: 10px; font-weight: 700; }
    .review-text { color: #475569; font-size: 14.5px; line-height: 1.6; margin: 0 0 10px 0; }
    .review-tags span { display: inline-block; background: #f1f5f9; color: #475569; font-size: 12px; padding: 4px 10px; border-radius: 6px; margin-right: 6px; font-weight: 600; }
    
    .write-review-btn { background: #0f766e; color: #fff; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 700; font-size: 15px; cursor: pointer; transition: 0.2s; width: 100%; margin-top: 20px; }
    .write-review-btn:hover { background: #0d9488; }
</style>

<div class="review-section">
    <h3 style="margin-top:0; font-size:22px; color:#0f172a;">Khách hàng nói gì về mức độ Trợ năng?</h3>
    
    <div class="review-header">
        <div class="overall-score">
            <h1>4.8</h1>
            <div class="stars">★★★★★</div>
            <p>128 bài đánh giá</p>
        </div>
        
        <div class="criteria-list">
            <div class="criteria-item">
                <div class="criteria-label"><span><i class="fa fa-wheelchair"></i> Độ bằng phẳng cho xe lăn</span> <span>4.9/5</span></div>
                <div class="progress-bg"><div class="progress-bar" style="width: 98%;"></div></div>
            </div>
            <div class="criteria-item">
                <div class="criteria-label"><span><i class="fa fa-user-md"></i> Sự nhiệt tình của nhân viên hỗ trợ</span> <span>4.8/5</span></div>
                <div class="progress-bg"><div class="progress-bar" style="width: 96%;"></div></div>
            </div>
            <div class="criteria-item">
                <div class="criteria-label"><span><i class="fa fa-bath"></i> Tiện ích phòng (Tay vịn, chống trượt)</span> <span>4.7/5</span></div>
                <div class="progress-bg"><div class="progress-bar" style="width: 94%;"></div></div>
            </div>
        </div>
    </div>

    <div class="review-list">
        <!-- Review 1 -->
        <div class="review-card">
            <div class="reviewer-info">
                <div class="avatar">A</div>
                <div>
                    <h4 class="reviewer-name">Gia đình Bác An <span class="reviewer-tag">✔ Đã xác minh trải nghiệm</span></h4>
                    <div style="color:#f59e0b; font-size:14px; margin-top:2px;">★★★★★ <span style="color:#94a3b8; font-size:12px; margin-left:8px;">2 ngày trước</span></div>
                </div>
            </div>
            <p class="review-text">"Tôi đưa bố 75 tuổi đi nghỉ dưỡng. Đường đi xe lăn cực kỳ mượt mà, không có bậc thang gắt. Đặc biệt các bạn nhân viên y tế trực 24/7 rất nhiệt tình dìu ông cụ xuống bể bơi. Gia đình rất an tâm!"</p>
            <div class="review-tags">
                <span><i class="fa fa-thumbs-up"></i> Nhân viên tận tâm</span>
                <span><i class="fa fa-wheelchair"></i> Xe lăn đi thoải mái</span>
            </div>
        </div>

        <!-- Review 2 -->
        <div class="review-card">
            <div class="reviewer-info">
                <div class="avatar" style="background:#8b5cf6;">M</div>
                <div>
                    <h4 class="reviewer-name">Cô Mai Lan <span class="reviewer-tag">✔ Đã xác minh trải nghiệm</span></h4>
                    <div style="color:#f59e0b; font-size:14px; margin-top:2px;">★★★★☆ <span style="color:#94a3b8; font-size:12px; margin-left:8px;">1 tuần trước</span></div>
                </div>
            </div>
            <p class="review-text">"Nhà vệ sinh thiết kế cực kỳ chuẩn xác, có tay vịn vững chắc và sàn nhám hoàn toàn không sợ trượt ngã. Điểm trừ nhỏ là xe điện nội khu đôi khi phải đợi hơi lâu (khoảng 10 phút)."</p>
            <div class="review-tags">
                <span><i class="fa fa-bath"></i> Toilet an toàn</span>
            </div>
        </div>
    </div>

    <button class="write-review-btn" onclick="alert('Tính năng viết đánh giá sẽ yêu cầu đăng nhập. (Demo)')">
        <i class="fa fa-pencil"></i> Viết đánh giá trải nghiệm của bạn
    </button>
</div>
<!-- END ACCESSIBLE REVIEW MODULE -->
HTML;

// Chèn module vào trước thẻ đóng </body>, hoặc cuối file nếu không có </body>
if (strpos($html, '</body>') !== false) {
    $html = str_replace('</body>', $reviewModule . "\n</body>", $html);
} else {
    $html .= $reviewModule;
}

file_put_contents($bookingFile, $html);
echo "=== DA CAY HE THONG REVIEW DAC THU TRO NANG VAO BOOKING.HTML! ===\n";
?>
