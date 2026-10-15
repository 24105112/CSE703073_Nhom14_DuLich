# NHẬT KÝ SỬA LỖI BACKEND (FIX LOG) - BUỔI 08
**Người thực hiện:** Nguyễn Trung Anh (V3 - Phát triển máy chủ)
**Ngày thực hiện:** Buổi 08

### Danh sách các vấn đề Backend đã xử lý:
1. **Fix lỗi CORS Headers:** Bổ sung `Access-Control-Allow-Origin` và xử lý request `OPTIONS` ở đầu các API.
2. **Fix lỗi Phông chữ tiếng Việt JSON:** Thêm cờ `JSON_UNESCAPED_UNICODE` để API trả về chữ tiếng Việt chuẩn.
3. **Tối ưu câu truy vấn Search & Phân trang:** Viết lại mảng `$where` ghép bằng `IMPLODE(' AND ')` và sử dụng Prepared Statements an toàn chống SQL Injection.
4. **Xử lý ngoại lệ Máy trạng thái đơn:** Đơn hết hạn hoặc hủy ngang tự động `UPDATE accessible_destinations SET available_slots = available_slots + ?`.