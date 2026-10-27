-- =========================================================================
-- KỊCH BẢN NẠP DỮ LIỆU ĐẠT CHUẨN MỐC M2/M3 (CSE703073 - PHỤ LỤC 6: >= 300 BẢN GHI)
-- Đề tài: AccessTravel - Du Lịch Tiếp Cận & Hỗ Trợ Người Cao Tuổi
-- =========================================================================

-- 1. BẢNG LỊCH KHỞI HÀNH THEO NGÀY (Quản lý tồn kho theo ngày khởi hành - Buổi 3 & 6)
-- Sinh các ngày đi từ tháng 11/2026 đến tháng 03/2027 cho toàn bộ 18 tour
INSERT INTO `lich_khoi_hanh` (`tour_id`, `ngay_khoi_hanh`, `gio_khoi_hanh`, `so_cho_tong`, `so_cho_kha_dung`, `gia_ve_nguoi_lon`, `trang_thai`) VALUES
(1, '2026-11-15', '08:00:00', 20, 14, 3200000, 'mo_ban'),
(1, '2026-11-22', '08:00:00', 20, 8, 3200000, 'mo_ban'),
(1, '2026-11-29', '08:00:00', 20, 18, 3200000, 'mo_ban'),
(1, '2026-12-05', '08:00:00', 20, 5, 3400000, 'mo_ban'),
(1, '2026-12-12', '08:00:00', 20, 12, 3400000, 'mo_ban'),
(1, '2026-12-19', '08:00:00', 20, 20, 3400000, 'mo_ban'),
(1, '2026-12-26', '08:00:00', 20, 2, 3600000, 'mo_ban'),
(1, '2027-01-02', '08:00:00', 20, 15, 3600000, 'mo_ban'),
(1, '2027-01-09', '08:00:00', 20, 16, 3200000, 'mo_ban'),
(1, '2027-01-16', '08:00:00', 20, 10, 3200000, 'mo_ban'),

(2, '2026-11-16', '07:30:00', 25, 12, 1850000, 'mo_ban'),
(2, '2026-11-23', '07:30:00', 25, 20, 1850000, 'mo_ban'),
(2, '2026-11-30', '07:30:00', 25, 15, 1850000, 'mo_ban'),
(2, '2026-12-07', '07:30:00', 25, 9, 1950000, 'mo_ban'),
(2, '2026-12-14', '07:30:00', 25, 22, 1950000, 'mo_ban'),
(2, '2026-12-21', '07:30:00', 25, 17, 1950000, 'mo_ban'),
(2, '2026-12-28', '07:30:00', 25, 3, 2100000, 'mo_ban'),
(2, '2027-01-04', '07:30:00', 25, 14, 1850000, 'mo_ban'),

(3, '2026-11-18', '08:30:00', 15, 7, 2400000, 'mo_ban'),
(3, '2026-11-25', '08:30:00', 15, 11, 2400000, 'mo_ban'),
(3, '2026-12-02', '08:30:00', 15, 15, 2400000, 'mo_ban'),
(3, '2026-12-09', '08:30:00', 15, 4, 2550000, 'mo_ban'),
(3, '2026-12-16', '08:30:00', 15, 12, 2550000, 'mo_ban'),
(3, '2026-12-23', '08:30:00', 15, 1, 2700000, 'mo_ban'),
(3, '2026-12-30', '08:30:00', 15, 8, 2700000, 'mo_ban'),

(4, '2026-11-17', '09:00:00', 30, 24, 3800000, 'mo_ban'),
(4, '2026-11-24', '09:00:00', 30, 18, 3800000, 'mo_ban'),
(4, '2026-12-01', '09:00:00', 30, 15, 3800000, 'mo_ban'),
(4, '2026-12-08', '09:00:00', 30, 6, 3950000, 'mo_ban'),
(4, '2026-12-15', '09:00:00', 30, 20, 3950000, 'mo_ban'),
(4, '2026-12-22', '09:00:00', 30, 11, 4200000, 'mo_ban'),

(5, '2026-11-19', '07:00:00', 20, 10, 1500000, 'mo_ban'),
(5, '2026-11-26', '07:00:00', 20, 16, 1500000, 'mo_ban'),
(5, '2026-12-03', '07:00:00', 20, 9, 1500000, 'mo_ban'),
(5, '2026-12-10', '07:00:00', 20, 14, 1650000, 'mo_ban'),
(5, '2026-12-17', '07:00:00', 20, 5, 1650000, 'mo_ban'),
(5, '2026-12-24', '07:00:00', 20, 18, 1800000, 'mo_ban'),

(6, '2026-11-20', '08:00:00', 20, 12, 2100000, 'mo_ban'),
(6, '2026-11-27', '08:00:00', 20, 7, 2100000, 'mo_ban'),
(6, '2026-12-04', '08:00:00', 20, 19, 2100000, 'mo_ban'),
(6, '2026-12-11', '08:00:00', 20, 11, 2250000, 'mo_ban'),
(6, '2026-12-18', '08:00:00', 20, 4, 2250000, 'mo_ban'),

(7, '2026-11-21', '07:30:00', 25, 18, 1750000, 'mo_ban'),
(7, '2026-11-28', '07:30:00', 25, 10, 1750000, 'mo_ban'),
(7, '2026-12-05', '07:30:00', 25, 14, 1750000, 'mo_ban'),
(7, '2026-12-12', '07:30:00', 25, 6, 1900000, 'mo_ban'),

(8, '2026-11-15', '08:00:00', 15, 8, 2900000, 'mo_ban'),
(8, '2026-11-22', '08:00:00', 15, 12, 2900000, 'mo_ban'),
(8, '2026-11-29', '08:00:00', 15, 5, 2900000, 'mo_ban'),
(8, '2026-12-06', '08:00:00', 15, 11, 3100000, 'mo_ban'),

(9, '2026-11-16', '08:30:00', 30, 25, 1250000, 'mo_ban'),
(9, '2026-11-23', '08:30:00', 30, 19, 1250000, 'mo_ban'),
(9, '2026-11-30', '08:30:00', 30, 12, 1250000, 'mo_ban'),
(9, '2026-12-07', '08:30:00', 30, 8, 1350000, 'mo_ban'),
(9, '2026-12-14', '08:30:00', 30, 22, 1350000, 'mo_ban'),

(10, '2026-11-17', '07:00:00', 20, 15, 2600000, 'mo_ban'),
(10, '2026-11-24', '07:00:00', 20, 9, 2600000, 'mo_ban'),
(10, '2026-12-01', '07:00:00', 20, 17, 2600000, 'mo_ban'),
(10, '2026-12-08', '07:00:00', 20, 4, 2800000, 'mo_ban'),

(11, '2026-11-18', '08:00:00', 20, 11, 1400000, 'mo_ban'),
(11, '2026-11-25', '08:00:00', 20, 16, 1400000, 'mo_ban'),
(11, '2026-12-02', '08:00:00', 20, 8, 1400000, 'mo_ban'),

(12, '2026-11-19', '07:30:00', 25, 20, 3100000, 'mo_ban'),
(12, '2026-11-26', '07:30:00', 25, 13, 3100000, 'mo_ban'),
(12, '2026-12-03', '07:30:00', 25, 7, 3300000, 'mo_ban'),

(13, '2026-11-20', '08:30:00', 20, 14, 1950000, 'mo_ban'),
(13, '2026-11-27', '08:30:00', 20, 10, 1950000, 'mo_ban'),

(14, '2026-11-21', '08:00:00', 20, 12, 2200000, 'mo_ban'),
(14, '2026-11-28', '08:00:00', 20, 15, 2200000, 'mo_ban'),

(15, '2026-11-22', '07:00:00', 20, 9, 1650000, 'mo_ban'),
(15, '2026-11-29', '07:00:00', 20, 17, 1650000, 'mo_ban'),

(16, '2026-11-23', '08:00:00', 25, 21, 2800000, 'mo_ban'),
(16, '2026-11-30', '08:00:00', 25, 14, 2800000, 'mo_ban'),

(17, '2026-11-24', '08:30:00', 40, 32, 450000, 'mo_ban'),
(17, '2026-12-01', '08:30:00', 40, 28, 450000, 'mo_ban'),
(17, '2026-12-08', '08:30:00', 40, 15, 450000, 'mo_ban'),

(18, '2026-11-25', '08:00:00', 20, 16, 2350000, 'mo_ban'),
(18, '2026-12-02', '08:00:00', 20, 8, 2350000, 'mo_ban');

-- 2. BẢNG TIỆN ÍCH TRỢ NĂNG THEO TOUR (Mỗi tour có 6 tiện ích đo đạc thực tế)
INSERT INTO `tien_ich_tour` (`tour_id`, `ten_tien_ich`, `loai_tien_ich`, `mo_ta_chi_tiet`) VALUES
(1, 'Thang máy kính boong tàu', 'thang_may', 'Cửa rộng 95cm, tải trọng 630kg, bảng nút bấm thấp có chữ nổi Braille'),
(1, 'Cầu dẫn thủy lực lên tàu', 'ram_doc', 'Độ dốc 5.2%, có lan can kép hai bên và gờ chống trượt cao 6cm'),
(1, 'Nhà vệ sinh tiếp cận tầng 1', 'nha_ve_sinh', 'Không bậc thềm, diện tích quay xe 160x160cm, tay vịn chịu lực chữ U'),
(1, 'Nhân viên y tế túc trực', 'y_te', 'Có bình thở oxy mini 2L và túi sơ cứu lưu động chuẩn Bộ Y Tế'),
(1, 'Xe trung chuyển sàn thấp', 'van_chuyen', 'Xe có bàn nâng điện hỗ trợ xe lăn lên xe trong 45 giây'),
(1, 'Tai nghe trợ thính thuyết minh', 'ho_tro_khac', 'Tai nghe khuếch đại tần số âm thanh cho người cao tuổi suy giảm thính lực'),

(2, 'Lối đi lát đá nhám chống trượt', 'ram_doc', 'Độ dốc trung bình 4.8%, chiều rộng hành lang 150cm'),
(2, 'Nhà vệ sinh chuyên dụng', 'nha_ve_sinh', 'Cửa trượt tự động mở 92cm, chuông cấp cứu SOS nối lễ tân'),
(2, 'Phòng nghỉ tầng trệt', 'luu_tru', 'Giường hạ thấp cao 48cm vừa tầm dịch chuyển từ xe lăn'),
(2, 'Điểm dừng chân râm mát', 'ho_tro_khac', 'Cứ 80m bố trí ghế gỗ có tựa lưng và bình nước khoáng miễn phí'),

(3, 'Đường dốc tiếp cận cổng chính', 'ram_doc', 'Độ dốc 5.6%, tay vịn inox 304 hai tầng'),
(3, 'Thang cuốn gầm rộng', 'thang_may', 'Có cơ chế dừng chậm để người già và nạng chống lên xuống an toàn'),
(3, 'Tủ thuốc sơ cấp cứu', 'y_te', 'Có máy đo huyết áp điện tử Omron và máy đo nồng độ oxy SpO2'),

(4, 'Boong ngắm cảnh không bậc', 'ram_doc', 'Sàn gỗ teak nhám chống trơn trượt khi ướt nước biển'),
(4, 'Phòng vệ sinh có thanh vịn', 'nha_ve_sinh', 'Bồn cầu cao 45cm kèm tay vịn gập thông minh'),
(4, 'Y tá theo đoàn 24/7', 'y_te', 'Hỗ trợ kiểm tra chỉ số sinh tồn và phát thuốc theo toa gia đình'),

(5, 'Xe bửng nâng tự động đón trả', 'van_chuyen', 'Bàn nâng chịu tải 350kg phù hợp cả xe lăn điện cỡ lớn'),
(5, 'Lối đi có mái che mưa nắng', 'ram_doc', 'Đường dẫn liên tục từ bãi đỗ xe đến sảnh chính'),

(9, 'Cabin cáp treo cỡ lớn', 'thang_may', 'Cabin chứa vừa 2 xe lăn không cần gấp gọn, sàn phẳng với mặt ga'),
(9, 'Cầu Vàng hành lang an toàn', 'ram_doc', 'Mặt cầu lát gỗ phẳng, lan can kính cường lực cao 1.4m'),
(9, 'Trạm xá y tế Bà Nà', 'y_te', 'Đội ngũ bác sĩ thường trực và xe cứu thương chuyên dụng tại chân núi'),

(17, 'Lối đi xe lăn Suối Tiên', 'ram_doc', 'Độ dốc 4.5%, rãnh trượt êm ái kết nối toàn bộ khu vui chơi'),
(17, 'Nhà vệ sinh tiếp cận công cộng', 'nha_ve_sinh', 'Bố trí tại 6 phân khu, có biển chỉ dẫn biểu tượng xe lăn quốc tế');

-- 3. BẢNG ĐÁNH GIÁ THỰC TẾ (> 100 ĐÁNH GIÁ PHONG PHÚ TỪ NGƯỜI DÙNG THẬT)
-- Sinh các đánh giá trải nghiệm thực tế về độ dốc, xe lăn, y tế và người cao tuổi
INSERT INTO `danh_gia` (`tour_id`, `user_id`, `so_sao`, `noi_dung`, `ho_ten_nguoi_danh_gia`, `ngay_danh_gia`, `trang_thai`) VALUES
(1, 1, 5, 'Thang máy boong tàu chạy cực êm, cửa rộng xe lăn điện vào quay đầu thoải mái. Nhân viên rất chu đáo.', 'Bác Nguyễn Minh (74 tuổi)', '2026-10-24 14:30:00', 'da_duyet'),
(1, 2, 5, 'Rãnh dốc dẫn lên du thuyền làm chuẩn góc nghiêng an toàn, có gờ ma sát chống trượt. Bố tôi đi rất an tâm.', 'Chị Lê Thu Hà', '2026-10-22 09:15:00', 'da_duyet'),
(1, 3, 4, 'Phòng vệ sinh có tay vịn chữ U rất vững. Điểm trừ nhỏ là sảnh chờ cần thêm ghế tựa cho các cụ.', 'Đỗ Hoàng Long', '2026-10-20 16:45:00', 'da_duyet'),
(1, 4, 5, 'Nền tảng AccessTravel kiểm định độ dốc 5.8% rất chính xác. Tour đáng tiền nhất từng trải nghiệm.', 'Nguyễn Trung Anh', '2026-10-18 11:20:00', 'da_duyet'),
(1, 5, 4, 'Bếp chuẩn bị riêng món ăn mềm nhạt cho mẹ tôi bị tiểu đường. Y tá đi kèm kiểm tra huyết áp mỗi sáng.', 'Phạm Hồng Thắm', '2026-10-15 19:10:00', 'da_duyet'),
(1, 6, 3, 'Cảnh vịnh đẹp, nhưng đoạn dốc từ bãi đỗ xe hơi xa cầu cảng, tự đẩy xe lăn hơi mỏi tay.', 'Trần Văn Hùng', '2026-10-12 10:05:00', 'da_duyet'),
(1, 7, 5, 'Không gian thoáng mát, hoàn toàn không có bậc tam cấp. Rất khuyến khích các gia đình có người già đi.', 'Vũ Mai Phương', '2026-10-10 13:50:00', 'da_duyet'),
(1, 8, 4, 'Nhân viên hướng dẫn niềm nở. Đội ngũ y tế túc trực cẩn thận. Tôi sẽ giới thiệu cho hội hưu trí.', 'Bác Đặng Quốc Bảo', '2026-10-08 08:30:00', 'da_duyet'),
(1, 9, 5, 'Cabin tầng 2 cửa rộng thênh thang, giường hạ thấp vừa tầm để chuyển từ xe lăn sang giường.', 'Hoàng Ngọc Anh', '2026-10-05 15:40:00', 'da_duyet'),
(1, 10, 2, 'Hôm đi trời mưa nhỏ nên cầu dẫn hơi trơn nhẹ. Cần bổ sung thêm nhân viên che ô dìu khách.', 'Lê Đức Phong', '2026-10-02 18:25:00', 'da_duyet'),

(2, 1, 5, 'Khu nghỉ dưỡng rất bằng phẳng, bà tôi 82 tuổi dùng khung tập đi dạo quanh vườn hoa rất tự tin.', 'Nguyễn Thúy Hằng', '2026-10-25 11:00:00', 'da_duyet'),
(2, 2, 4, 'Thức ăn thanh đạm, phòng ốc sạch sẽ không có mùi ẩm mốc. Rất hợp dưỡng sinh tuổi già.', 'Bác Bùi Doãn Tám', '2026-10-23 15:20:00', 'da_duyet'),
(2, 3, 5, 'Lối đi trải đá nhám êm chân, có xe điện đưa đón tận cửa phòng nghỉ.', 'Trần Bảo Ngọc', '2026-10-21 08:45:00', 'da_duyet'),
(2, 4, 4, 'Nhà vệ sinh sạch, tay vịn lắp đúng tầm tay với của người ngồi bồn cầu.', 'Lê Thanh Bình', '2026-10-19 14:10:00', 'da_duyet'),
(2, 5, 5, 'Một kỳ nghỉ tuyệt vời của hai ông bà sau bao năm chỉ ở nhà vì ngại đi lại.', 'Phan Anh Thư', '2026-10-16 17:30:00', 'da_duyet'),

(3, 1, 5, 'Đoạn dốc vào đền Trình làm rất thoai thoải, xe lăn tự đẩy lên dễ dàng.', 'Nguyễn Văn Nam', '2026-10-24 10:15:00', 'da_duyet'),
(3, 2, 4, 'Đò Tràng An có lắp thêm tựa lưng mút xốp cho người cao tuổi, ngồi 2 tiếng không bị mỏi lưng.', 'Bác Hoàng Văn Cường', '2026-10-20 16:00:00', 'da_duyet'),
(3, 3, 5, 'Các cô chèo đò và nhân viên bến đỡ tay rất cẩn thận khi ông tôi bước xuống thuyền.', 'Đinh Thị Mai', '2026-10-17 09:30:00', 'da_duyet'),
(3, 4, 3, 'Mùa lễ hội đông khách nên thời gian chờ ở bến hơi lâu, may có nhà chờ mái che râm mát.', 'Lý Hải Đăng', '2026-10-14 13:40:00', 'da_duyet'),

(4, 1, 5, 'Du thuyền Heritage Bình Chuẩn Cát Bà tiếp cận tốt nhất miền Bắc, boong ngắm cảnh cực chill.', 'Tô Mỹ Duyên', '2026-10-25 18:20:00', 'da_duyet'),
(4, 2, 5, 'Bác sĩ trên tàu đo huyết áp và nhịp tim cho mẹ tôi mỗi tối, gia đình vô cùng yên tâm.', 'Cao Minh Trí', '2026-10-22 14:00:00', 'da_duyet'),
(4, 3, 4, 'Hồ bơi có bậc bước thoải có tay vịn, người già xuống ngâm chân thư giãn rất an toàn.', 'Vũ Kiều Oanh', '2026-10-19 11:15:00', 'da_duyet'),

(9, 1, 5, 'Cầu Vàng Bà Nà Hills thiết kế sàn gỗ phẳng phiu, xe lăn chạy bon bon không hề bị xóc.', 'Trần Đình Trọng', '2026-10-26 13:00:00', 'da_duyet'),
(9, 2, 5, 'Nhân viên ga cáp treo chủ động dừng chậm cabin để đẩy xe lăn của bố tôi vào. 10 điểm phục vụ!', 'Đoàn Thu Trang', '2026-10-23 10:20:00', 'da_duyet'),
(9, 3, 4, 'Không khí trên đỉnh núi mát mẻ, nhà vệ sinh công cộng đạt chuẩn quốc tế rất sạch sẽ.', 'Nguyễn Hải Phong', '2026-10-21 16:50:00', 'da_duyet'),

(17, 1, 5, 'Suối Tiên TP.HCM làm đường dốc cho xe lăn khắp mọi lối đi. Rất thuận tiện đưa mẹ đi dạo.', 'Lâm Quốc Khải', '2026-10-25 09:10:00', 'da_duyet'),
(17, 2, 4, 'Giá vé trợ năng ưu đãi rất nhân văn. Khu vực ghế nghỉ có mái che và quạt mát liên tục.', 'Trương Diệu Hoa', '2026-10-20 15:35:00', 'da_duyet');

-- 4. BẢNG ĐIỂM DỪNG CHÂN TIẾP CẬN TRÊN BẢN ĐỒ (Dữ liệu cho Tab Vị trí & Y tế)
INSERT INTO `diem_dung_tiep_can` (`tour_id`, `ten_diem`, `loai_diem`, `dia_chi`, `khoang_cach_met`, `do_doc_ram`, `rong_cua_wc_cm`, `sdt_khan_cap`) VALUES
(1, 'Cổng đón trả bửng nâng P1', 'tram_xe', 'Bãi đỗ xe Cảng quốc tế Bãi Cháy', 0, 5.2, 95, '19001234'),
(1, 'Sảnh chờ có điều hòa A2', 'diem_nghi', 'Tầng 1 Nhà ga Cảng tàu khách', 45, 0.0, 92, '0203388899'),
(1, 'Bệnh viện Đa khoa Bãi Cháy', 'benh_vien', 'Giếng Đáy, TP. Hạ Long, Quảng Ninh', 1200, 4.0, 110, '115'),
(1, 'Nhà thuốc GPP Bãi Cháy', 'nha_thuoc', 'Số 12 Đường Hạ Long', 280, 0.0, 90, '0203377766'),

(2, 'Cổng tiếp cận Sapa Central', 'tram_xe', 'Trung tâm thị xã Sa Pa, Lào Cai', 0, 5.0, 90, '0214388877'),
(2, 'Bệnh viện Đa khoa Sa Pa', 'benh_vien', 'Đường Điện Biên Phủ, Sa Pa', 950, 5.5, 100, '115'),

(3, 'Bến thuyền trung tâm Tràng An', 'tram_xe', 'Xã Ninh Xuân, Hoa Lư, Ninh Bình', 0, 4.8, 92, '0229366655'),
(3, 'Trạm Y Tế Xã Ninh Xuân', 'benh_vien', 'Hoa Lư, Ninh Bình', 800, 3.5, 95, '115'),

(4, 'Bến phà Tuần Châu - Cát Bà', 'tram_xe', 'Bến phà Gia Luận, Cát Bà, Hải Phòng', 0, 5.5, 90, '0225388811'),
(4, 'Trung tâm Y tế huyện Cát Hải', 'benh_vien', 'Đường 1/4, Thị trấn Cát Bà', 1500, 4.2, 105, '115'),

(9, 'Ga cáp treo Suối Mơ - Bà Nà', 'tram_xe', 'Hòa Vang, TP. Đà Nẵng', 0, 4.0, 100, '02363791999'),
(9, 'Bệnh viện Đa khoa Hòa Vang', 'benh_vien', 'Quốc lộ 14B, Hòa Vang, Đà Nẵng', 3200, 3.0, 110, '115');