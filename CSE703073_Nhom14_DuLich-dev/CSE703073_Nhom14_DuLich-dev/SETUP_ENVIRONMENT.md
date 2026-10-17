# (DEV ENVIRONMENT)

- Người thực hiện: Hoàng Xuân Hoàn (V5 - SysAdmin/DevOps)
- Ngày cập nhật: Buổi 1

## 1. Yêu cầu phần mềm
- Git phiên bản 2.x trở lên.
- Node.js (v18+) hoặc PHP (8.x) tuỳ theo Stack nhóm chọn.
- Database: MySQL hoặc PostgreSQL.

## 2. Các bước cài đặt chi tiết
1. Clone repository về máy local:
   `git clone <URL_REPOSITORY>`
2. Tạo tệp `.env` từ tệp mẫu:
   `cp .env.example .env`
3. Cài đặt các gói phụ thuộc (Dependencies):
   `npm install` (hoặc `composer install`)
4. Khởi chạy dự án ở môi trường Local:
   `npm run dev` (hoặc server local tương ứng)