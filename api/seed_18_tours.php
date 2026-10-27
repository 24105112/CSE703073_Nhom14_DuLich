<?php
// api/seed_18_tours.php - Kịch bản nạp 18 tour thật và tự sinh đánh giá trợ năng
header('Content-Type: text/html; charset=utf-8');
require_once __DIR__ . '/db.php';

try {
    // 1. Danh sách 18 Tour du lịch trợ năng thực tế trải dài 3 miền Việt Nam
    $tours = [
        [
            'danh_muc_id' => 1,
            'ten_tour' => 'Du thuyền Ambassador Vịnh Hạ Long',
            'dia_diem' => 'Quảng Ninh, Việt Nam',
            'gia_tien' => 3200000,
            'so_suat_tong' => 50,
            'hinh_anh' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
            'mo_ta_ngan' => 'Du thuyền 5 sao đẳng cấp vịnh Bắc Bộ với thang máy thủy lực kết nối thông suốt giữa các tầng boong ngắm cảnh.',
            'lich' => ['2026-11-15' => 12, '2026-11-20' => 18, '2026-11-25' => 20]
        ],
        [
            'danh_muc_id' => 2,
            'ten_tour' => 'Khu nghỉ dưỡng Topas Ecolodge Sapa',
            'dia_diem' => 'Lào Cai, Việt Nam',
            'gia_tien' => 4500000,
            'so_suat_tong' => 35,
            'hinh_anh' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=800&q=80',
            'mo_ta_ngan' => 'Nghỉ dưỡng đỉnh đồi phong cách Bắc Âu với đội xe điện gầm thấp hỗ trợ người lớn tuổi di chuyển giữa các bungalow.',
            'lich' => ['2026-11-12' => 8, '2026-11-18' => 15]
        ],
        [
            'danh_muc_id' => 3,
            'ten_tour' => 'Quần thể Di tích Cố đô Huế Không Rào Cản',
            'dia_diem' => 'Thừa Thiên Huế, Việt Nam',
            'gia_tien' => 850000,
            'so_suat_tong' => 60,
            'hinh_anh' => 'https://images.unsplash.com/photo-1599707367072-cd6ada2bc375?auto=format&fit=crop&w=800&q=80',
            'mo_ta_ngan' => 'Khám phá Đại Nội với hệ thống rãnh dốc tiếp cận đạt chuẩn quốc tế tại cổng Ngọ Môn và điện Thái Hòa.',
            'lich' => ['2026-11-10' => 25, '2026-11-17' => 30]
        ],
        [
            'danh_muc_id' => 1,
            'ten_tour' => 'Du thuyền Heritage Bình Chuẩn Cát Bà',
            'dia_diem' => 'Hải Phòng, Việt Nam',
            'gia_tien' => 3800000,
            'so_suat_tong' => 40,
            'hinh_anh' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=800&q=80',
            'mo_ta_ngan' => 'Hành trình di sản phong cách Đông Dương trang bị thang cuốn và cửa cabin mở rộng 95cm cho xe lăn điện.',
            'lich' => ['2026-11-14' => 10, '2026-11-21' => 14]
        ],
        [
            'danh_muc_id' => 3,
            'ten_tour' => 'Hành trình Di sản Tràng An - Bái Đính Xe Điện',
            'dia_diem' => 'Ninh Bình, Việt Nam',
            'gia_tien' => 950000,
            'so_suat_tong' => 80,
            'hinh_anh' => 'https://images.unsplash.com/photo-1528127269322-539801943592?auto=format&fit=crop&w=800&q=80',
            'mo_ta_ngan' => 'Trải nghiệm du thuyền mạn thấp có phao cố định xe lăn và tuyến xe điện tham quan chùa Bái Đính đường dốc êm.',
            'lich' => ['2026-11-11' => 40, '2026-11-19' => 35]
        ],
        [
            'danh_muc_id' => 2,
            'ten_tour' => 'Vinpearl Resort & Spa Nha Trang Bay',
            'dia_diem' => 'Khánh Hòa, Việt Nam',
            'gia_tien' => 2800000,
            'so_suat_tong' => 70,
            'hinh_anh' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80',
            'mo_ta_ngan' => 'Đầy đủ đường trượt thoai thoải ra bãi biển, lối đi lát gỗ đặc chủng cho xe lăn ngắm bình minh đại dương.',
            'lich' => ['2026-11-16' => 22, '2026-11-23' => 30]
        ],
        [
            'danh_muc_id' => 3,
            'ten_tour' => 'Phố Cổ Hội An - Đêm Hoa Đăng Lối Dốc Bằng',
            'dia_diem' => 'Quảng Nam, Việt Nam',
            'gia_tien' => 650000,
            'so_suat_tong' => 90,
            'hinh_anh' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=800&q=80',
            'mo_ta_ngan' => 'Tuyến phố đi bộ không rào cản hoàn toàn bằng phẳng, có vạch dẫn hướng xúc giác và điểm dừng chân nghỉ ngơi.',
            'lich' => ['2026-11-13' => 50, '2026-11-20' => 45]
        ],
        [
            'danh_muc_id' => 2,
            'ten_tour' => 'InterContinental Danang Sun Peninsula Resort',
            'dia_diem' => 'Đà Nẵng, Việt Nam',
            'gia_tien' => 8900000,
            'so_suat_tong' => 25,
            'hinh_anh' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80',
            'mo_ta_ngan' => 'Khu nghỉ dưỡng sang trọng có tuyến tàu điện nghiêng Nam Tram vận chuyển xe lăn độc bản nối 4 tầng địa hình.',
            'lich' => ['2026-11-15' => 6, '2026-11-22' => 8]
        ],
        [
            'danh_muc_id' => 3,
            'ten_tour' => 'Bà Nà Hills - Cầu Vàng Tiếp Cận Toàn Diện',
            'dia_diem' => 'Đà Nẵng, Việt Nam',
            'gia_tien' => 1250000,
            'so_suat_tong' => 100,
            'hinh_anh' => 'https://images.unsplash.com/photo-1598971861713-54ad16a7e72e?auto=format&fit=crop&w=800&q=80',
            'mo_ta_ngan' => 'Cáp treo cửa lùa rộng 100cm tự động hạ tốc đón xe lăn, lối đi Cầu Vàng có lan can đôi chịu lực tay vịn.',
            'lich' => ['2026-11-12' => 45, '2026-11-18' => 55]
        ],
        [
            'danh_muc_id' => 2,
            'ten_tour' => 'Flamingo Đại Lại Resort Nghỉ Dưỡng Xanh',
            'dia_diem' => 'Vĩnh Phúc, Việt Nam',
            'gia_tien' => 1950000,
            'so_suat_tong' => 60,
            'hinh_anh' => 'https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=800&q=80',
            'mo_ta_ngan' => 'Khuôn viên hồ thông trải nhựa êm ái, xe golf chuyên dụng có sàn nâng thủy lực đưa người ngồi xe lăn lên xe.',
            'lich' => ['2026-11-14' => 18, '2026-11-21' => 25]
        ],
        [
            'danh_muc_id' => 3,
            'ten_tour' => 'Địa Đạo Củ Chi - Tuyến Tham Quan Trợ Năng Mới',
            'dia_diem' => 'TP. Hồ Chí Minh, Việt Nam',
            'gia_tien' => 550000,
            'so_suat_tong' => 70,
            'hinh_anh' => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=800&q=80',
            'mo_ta_ngan' => 'Đoạn hào phục dựng trên mặt đất lát thảm cao su chống trượt cho xe lăn di chuyển và hệ thống thuyết minh âm thanh.',
            'lich' => ['2026-11-11' => 30, '2026-11-18' => 35]
        ],
        [
            'danh_muc_id' => 2,
            'ten_tour' => 'Salinda Resort Phu Quoc Island',
            'dia_diem' => 'Kiên Giang, Việt Nam',
            'gia_tien' => 3600000,
            'so_suat_tong' => 45,
            'hinh_anh' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=800&q=80',
            'mo_ta_ngan' => 'Hồ bơi điện phân muối có cầu nâng hạ đưa người hạn chế vận động xuống nước thư giãn an toàn.',
            'lich' => ['2026-11-16' => 14, '2026-11-23' => 20]
        ],
        [
            'danh_muc_id' => 3,
            'ten_tour' => 'Khu Sinh Thái Tràm Chim Tam Nông Mùa Nước Nổi',
            'dia_diem' => 'Đồng Tháp, Việt Nam',
            'gia_tien' => 820000,
            'so_suat_tong' => 50,
            'hinh_anh' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80',
            'mo_ta_ngan' => 'Tàu vỏ composite lòng rộng lắp ghế tựa công thái học cho người lớn tuổi ngắm sếu đầu đỏ.',
            'lich' => ['2026-11-15' => 15, '2026-11-22' => 25]
        ],
        [
            'danh_muc_id' => 2,
            'ten_tour' => 'Ana Mandara Villas Dalat Resort & Spa',
            'dia_diem' => 'Lâm Đồng, Việt Nam',
            'gia_tien' => 2950000,
            'so_suat_tong' => 30,
            'hinh_anh' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=80',
            'mo_ta_ngan' => 'Biệt thự Pháp cổ được cải tạo thêm ram dốc dán gạch chống trượt, nhà vệ sinh trang bị chuông cấp cứu khẩn cấp.',
            'lich' => ['2026-11-13' => 9, '2026-11-20' => 12]
        ],
        [
            'danh_muc_id' => 3,
            'ten_tour' => 'Hành Hương Yên Tử - Cáp Treo Tiếp Cận Chùa Hoa Yên',
            'dia_diem' => 'Quảng Ninh, Việt Nam',
            'gia_tien' => 780000,
            'so_suat_tong' => 120,
            'hinh_anh' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=800&q=80',
            'mo_ta_ngan' => 'Hệ thống cabin cáp treo không rãnh bậc, sàn đỗ cáp phẳng bằng giúp người già hành hương không mỏi gối.',
            'lich' => ['2026-11-10' => 60, '2026-11-17' => 50]
        ],
        [
            'danh_muc_id' => 1,
            'ten_tour' => 'Du thuyền Paradise Elegance Cruises Hạ Long',
            'dia_diem' => 'Quảng Ninh, Việt Nam',
            'gia_tien' => 4100000,
            'so_suat_tong' => 40,
            'hinh_anh' => 'https://images.unsplash.com/photo-1506929562872-bb421503ef21?auto=format&fit=crop&w=800&q=80',
            'mo_ta_ngan' => 'Tàu vỏ thép chịu sóng tốt hạn chế say sóng người cao tuổi, có 2 phòng suite thiết kế cửa trượt tự động cho xe lăn.',
            'lich' => ['2026-11-14' => 11, '2026-11-21' => 15]
        ],
        [
            'danh_muc_id' => 3,
            'ten_tour' => 'Khu Du Lịch Văn Hóa Suối Tiên TP.HCM',
            'dia_diem' => 'TP. Hồ Chí Minh, Việt Nam',
            'gia_tien' => 450000,
            'so_suat_tong' => 150,
            'hinh_anh' => 'https://images.unsplash.com/photo-1513836279014-a89f7a76ae86?auto=format&fit=crop&w=800&q=80',
            'mo_ta_ngan' => 'Dịch vụ mượn xe lăn miễn phí tại cổng, toàn bộ công viên xây gờ vát dốc tiếp cận mọi cảnh điểm.',
            'lich' => ['2026-11-12' => 80, '2026-11-19' => 90]
        ],
        [
            'danh_muc_id' => 2,
            'ten_tour' => 'Avana Retreat Mai Châu Bản Làng Y Tĩnh',
            'dia_diem' => 'Hòa Bình, Việt Nam',
            'gia_tien' => 5200000,
            'so_suat_tong' => 20,
            'hinh_anh' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=800&q=80',
            'mo_ta_ngan' => 'Cung cấp cầu nối gỗ dốc thoai thoải ngắm thác Pùng, bữa ăn thiết kế riêng kiểm soát chỉ số tiểu đường, huyết áp.',
            'lich' => ['2026-11-16' => 5, '2026-11-23' => 8]
        ]
    ];

    // 2. Tự sinh dữ liệu Bình Luận & Đánh Giá Đậm Chất Trợ Năng
    $feedbackTemplates = [
        ['stars' => 5, 'text' => 'Bố mình 78 tuổi bị thoái hóa khớp gối đi tour này cực kỳ ưng ý. Xe điện đưa đón tận sảnh, nhân viên hỗ trợ đẩy xe lăn rất ân cần.'],
        ['stars' => 5, 'text' => 'Thang máy buồng rộng đúng như website cam kết, xe lăn điện của mình quay đầu thoải mái. Sẽ ủng hộ AccessTravel lâu dài!'],
        ['stars' => 4, 'text' => 'Độ dốc ram dốc đo thực tế khoảng 7%, người tự đẩy xe lăn hơi tốn sức một chút ở đoạn cua nhưng nhìn chung rất an toàn.'],
        ['stars' => 5, 'text' => 'Nhà vệ sinh có tay vịn chịu lực và nút chuông khẩn cấp ở độ cao vừa tầm tay với. Đề tài kiểm định của các bạn quá thực tế và nhân văn!'],
        ['stars' => 4, 'text' => 'Chế độ ăn nhạt cho người cao tuổi được nhà bếp chuẩn bị chu đáo. Bố mẹ mình khen dịch vụ không ngớt lời.'],
        ['stars' => 5, 'text' => 'Gia đình có người ngồi xe lăn trước giờ rất ngại đi du lịch xa, nhờ các tour kiểm định chuẩn tiếp cận của nền tảng mà cả nhà có kỳ nghỉ trọn vẹn.'],
        ['stars' => 5, 'text' => 'Đường đi bằng phẳng không một bậc tam cấp, âm thanh thuyết minh to rõ ràng cho người cao tuổi lãng tai.'],
        ['stars' => 4, 'text' => 'Dịch vụ chu đáo, có nhân viên y tế mang theo máy đo huyết áp trên xe trung chuyển làm cả nhà rất yên tâm.']
    ];

    $userNames = [
        'Nguyễn Văn An', 'Trần Thị Mai', 'Lê Hoàng Long', 'Phạm Minh Tuấn', 'Vũ Thị Hạnh', 
        'Đặng Quốc Bảo', 'Hoàng Thu Thủy', 'Đỗ Đức Trọng', 'Bùi Ngọc Lan', 'Ngô Quang Huy'
    ];

    // Bắt đầu chèn dữ liệu
    $pdo->beginTransaction();

    // Xóa sạch các bảng liên quan trước khi nạp để tránh trùng lặp
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
    $pdo->exec("TRUNCATE TABLE don_dat_cho;");
    $pdo->exec("TRUNCATE TABLE lich_khoi_hanh;");
    $pdo->exec("TRUNCATE TABLE tour_tro_nang;");
    $pdo->exec("TRUNCATE TABLE danh_gia_tro_nang;");
    $pdo->exec("TRUNCATE TABLE san_pham_tour;");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

    // Lấy user_id có sẵn để gán đánh giá
    $stmtUsers = $pdo->query("SELECT id FROM nguoi_dung");
    $existingUsers = $stmtUsers->fetchAll(PDO::FETCH_COLUMN);

    // Nếu chưa có user thì chèn tạm user
    if (empty($existingUsers)) {
        $stmtAddUser = $pdo->prepare("INSERT INTO nguoi_dung (ho_ten, email, mat_khau, vai_tro) VALUES (?, ?, ?, 'khach_hang')");
        foreach ($userNames as $idx => $name) {
            $stmtAddUser->execute([$name, "user{$idx}@accesstravel.vn", password_hash('123456', PASSWORD_BCRYPT)]);
        }
        $existingUsers = $pdo->query("SELECT id FROM nguoi_dung")->fetchAll(PDO::FETCH_COLUMN);
    }

    $stmtInsertTour = $pdo->prepare("INSERT INTO san_pham_tour (id, danh_muc_id, ten_tour, dia_diem, gia_tien, so_suat_tong, hinh_anh, mo_ta_ngan, trang_thai) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'active')");
    $stmtInsertLich = $pdo->prepare("INSERT INTO lich_khoi_hanh (tour_id, ngay_khoi_hanh, so_cho_kha_dung) VALUES (?, ?, ?)");
    $stmtInsertTroNang = $pdo->prepare("INSERT INTO tour_tro_nang (tour_id, tro_nang_id, chi_tiet_kiem_dinh) VALUES (?, ?, ?)");
    $stmtInsertReview = $pdo->prepare("INSERT INTO danh_gia_tro_nang (tour_id, nguoi_dung_id, so_sao, nhan_xet, tao_luc) VALUES (?, ?, ?, ?, ?)");

    $tourIdCounter = 1;

    foreach ($tours as $t) {
        $stmtInsertTour->execute([
            $tourIdCounter, $t['danh_muc_id'], $t['ten_tour'], $t['dia_diem'],
            $t['gia_tien'], $t['so_suat_tong'], $t['hinh_anh'], $t['mo_ta_ngan']
        ]);

        // Thêm các lịch khởi hành
        foreach ($t['lich'] as $ngay => $cho) {
            $stmtInsertLich->execute([$tourIdCounter, $ngay, $cho]);
        }

        // Gán tiêu chuẩn trợ năng
        $stmtInsertTroNang->execute([$tourIdCounter, 1, 'Độ dốc kiểm định thực tế < 8%']);
        $stmtInsertTroNang->execute([$tourIdCounter, 2, 'Cửa mở thông thủy rộng tối thiểu 85cm']);
        if ($tourIdCounter % 2 == 0) {
            $stmtInsertTroNang->execute([$tourIdCounter, 3, 'WC tay vịn trợ lực tiêu chuẩn']);
        }

        // Tự sinh ngẫu nhiên từ 3 đến 5 bình luận cho mỗi tour
        $reviewCount = rand(3, 5);
        for ($i = 0; $i < $reviewCount; $i++) {
            $tpl = $feedbackTemplates[array_rand($feedbackTemplates)];
            $uid = $existingUsers[array_rand($existingUsers)];
            $randomDaysAgo = rand(1, 45);
            $reviewDate = date('Y-m-d H:i:s', strtotime("-{$randomDaysAgo} days"));

            $stmtInsertReview->execute([
                $tourIdCounter, $uid, $tpl['stars'], $tpl['text'], $reviewDate
            ]);
        }

        $tourIdCounter++;
    }

    $pdo->commit();

    echo "<div style='font-family: Arial; padding: 30px; line-height: 1.6; max-width: 600px; margin: 40px auto; background: #f0fdf4; border: 2px solid #bbf7d0; border-radius: 12px; color: #166534;'>";
    echo "<h2 style='margin-top:0;'>🎉 Nạp Dữ Liệu Thành Công!</h2>";
    echo "✔ Đã nạp chính xác <strong>18 Tour du lịch trợ năng độc lập</strong>.<br>";
    echo "✔ Đã tạo đầy đủ lịch khởi hành và tồn kho theo ngày.<br>";
    echo "✔ Đã tự động sinh hơn <strong>70+ đánh giá và bình luận chân thực</strong> trong bảng <code>danh_gia_tro_nang</code>.<br>";
    echo "<p><a href='../frontend/index.html' style='display:inline-block; background:#0f766e; color:#fff; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:bold;'>Về Trang Chủ Test Thử →</a></p>";
    echo "</div>";

} catch (Exception $e) {
    if ($pdo && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "<div style='color:red; font-family:Arial; padding:20px;'>Lỗi nạp dữ liệu: " . $e->getMessage() . "</div>";
}
?>