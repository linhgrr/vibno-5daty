# Vibno Blog Project

## Giới thiệu
Vibno Blog là một ứng dụng blog tương tự như [Viblo](https://viblo.asia), cung cấp các chức năng như đăng ký, đăng nhập, upload avatar, viết sửa xóa bài, xem bài viết, comment trong bài viết, follow người dùng khác, và vote up/vote down bài viết.

## Yêu cầu chức năng
- Đăng ký, Đăng nhập
- Viết bài
- Xem bài viết
- Comment trong bài viết
- Follow users khác
- Vote up/vote down bài viết

## Cấu trúc thư mục

Dưới đây là cấu trúc thư mục của project:

```plaintext
vibno-9day/
|-- app/
|   |-- Console/
|   |-- Exceptions/
|   |-- Http/
|   |   |-- Controllers/
|   |   |   |-- AuthController.php
|   |   |   |-- PostController.php
|   |   |   |-- CommentController.php
|   |   |   |-- FollowController.php
|   |   |-- Middleware/
|   |-- Models/
|   |   |-- User.php
|   |   |-- Post.php
|   |   |-- Comment.php
|   |   |-- Follow.php
|   |-- Providers/
|
|-- bootstrap/
|-- config/
|-- database/
|   |-- factories/
|   |-- migrations/
|   |-- seeders/
|
|-- public/
|-- resources/
|   |-- views/
|-- routes/
|   |-- api.php
|   |-- web.php
|
|-- storage/
|-- tests/
|-- vendor/
|
|-- .env
|-- artisan
|-- composer.json
|-- package.json
|-- README.md
|-- server.php
```
## Mô tả các thành phần chính:

### Controllers
- **AuthController**: Xử lý đăng ký và đăng nhập người dùng.

- **PostController**: Xử lý các hành động liên quan đến bài viết như tạo, sửa, xóa, và xem bài viết.

- **CommentController**: Xử lý comment trong bài viết.

- **FollowController**: Xử lý chức năng follow/unfollow giữa các người dùng.

### Models
- **User**: Model đại diện cho người dùng.

- **Post**: Model đại diện cho bài viết.

- **Comment**: Model đại diện cho bình luận.

- **Follow**: Model đại diện cho mối quan hệ follow giữa các người dùng.

### Routes
- **api.php**: Định nghĩa các route API cho ứng dụng.

- **web.php**: Định nghĩa các route web cho ứng dụng.

### Database
- **Migrations**: Các file migration để tạo bảng cơ sở dữ liệu.

- **Factories**: Các factory để tạo dữ liệu mẫu cho testing.

- **Seeders**: Các seeder để điền dữ liệu mẫu vào cơ sở dữ liệu.

## Quy trình làm việc

1. **Người dùng đăng ký/đăng nhập**
    - Người dùng có thể tạo tài khoản mới hoặc đăng nhập vào tài khoản hiện có.

2. **Người dùng tạo bài viết mới**
    - Sau khi đăng nhập, người dùng có thể tạo các bài viết mới để chia sẻ nội dung.
    - Người dùng có thể chỉnh sửa nội dung hoặc xóa bài viết của mình.

3. **Người dùng xem các bài viết**
    - Người dùng có thể duyệt và xem các bài viết đã được đăng trên nền tảng.

4. **Người dùng comment trong bài viết**
    - Người dùng có thể để lại nhận xét và thảo luận trong phần bình luận của mỗi bài viết.

5. **Người dùng follow các người dùng khác**
    - Người dùng có thể theo dõi các tài khoản khác để cập nhật những bài viết mới từ họ.

6. **Người dùng vote up/vote down bài viết**
    - Người dùng có thể bầu chọn bài viết bằng cách vote up hoặc vote down để thể hiện quan điểm cá nhân.
  
7. **Người dùng chỉnh sửa thông tin cá nhân**
    - Người dùng có thể chỉnh sửa tên, email và ảnh đại diện của mình. 


## Cài đặt

### Yêu cầu hệ thống

- PHP >= 7.4

- Composer

- MySQL

### Các bước cài đặt
Clone repository:
```
git clone https://github.com/linhgrr/vibno-9day.git
cd vibno-9day
```
Cài đặt các package:
```
composer install
npm install
npm run dev
```
Tạo file .env và cấu hình kết nối cơ sở dữ liệu:

```
cp .env.example .env
php artisan key:generate
```
Chạy migration và seeder:
```
php artisan migrate --seed
```
Khởi động server:
```
php artisan serve
```
## Bảo mật
### Xác Thực Người Dùng
- **Xác Thực Người Dùng**: Sử dụng hệ thống xác thực tích hợp của Laravel (`Auth::attempt`), kiểm tra quyền truy cập trước khi thực hiện các hành động CRUD trên bài viết và bình luận..
- **Quản Lý Phiên Làm Việc**: Đảm bảo xử lý phiên làm việc an toàn với cấu hình mặc định của Laravel.
- **Bảo Vệ CSRF**: Kích hoạt mặc định để bảo vệ chống lại các cuộc tấn công giả mạo yêu cầu giữa các trang.
  
### Quản Lý Mật Khẩu
- **Mã Hóa**: Mật khẩu được mã hóa bằng `bcrypt` của Laravel để đảm bảo lưu trữ an toàn.

### Xác Thực Dữ Liệu Đầu Vào
- **Xác Thực Biểu Mẫu**: Sử dụng xác thực biểu mẫu của Laravel để làm sạch và xác thực đầu vào người dùng, ngăn chặn các cuộc tấn công SQL injection và các cuộc tấn công thông thường khác.

### Xử Lý Lỗi
- **Trang Lỗi Tùy Chỉnh**: Cung cấp các trang lỗi tùy chỉnh để ngăn chặn rò rỉ thông tin.

## 


