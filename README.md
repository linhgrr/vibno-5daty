# Vibno Blog Project

## Giới thiệu
Vibno Blog là một ứng dụng blog tương tự như [Viblo](https://viblo.asia), cung cấp các chức năng như đăng ký, đăng nhập, viết bài, xem bài viết, comment trong bài viết, follow người dùng khác, và vote up/vote down bài viết.

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
AuthController: Xử lý đăng ký và đăng nhập người dùng.

PostController: Xử lý các hành động liên quan đến bài viết như tạo, sửa, xóa, và xem bài viết.

CommentController: Xử lý comment trong bài viết.

FollowController: Xử lý chức năng follow/unfollow giữa các người dùng.

### Models
User: Model đại diện cho người dùng.

Post: Model đại diện cho bài viết.

Comment: Model đại diện cho bình luận.

Follow: Model đại diện cho mối quan hệ follow giữa các người dùng.

### Routes
api.php: Định nghĩa các route API cho ứng dụng.

web.php: Định nghĩa các route web cho ứng dụng.

### Database
Migrations: Các file migration để tạo bảng cơ sở dữ liệu.

Factories: Các factory để tạo dữ liệu mẫu cho testing.

Seeders: Các seeder để điền dữ liệu mẫu vào cơ sở dữ liệu.

## Quy trình làm việc
Người dùng đăng ký/đăng nhập.

Người dùng tạo bài viết mới.

Người dùng xem các bài viết.

Người dùng comment trong bài viết.

Người dùng follow các người dùng khác.

Người dùng vote up/vote down bài viết.

## Cài đặt

### Yêu cầu hệ thống

PHP >= 7.4

Composer

MySQL

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

Sử dụng bcrypt để mã hóa mật khẩu người dùng.

Sử dụng Laravel Passport để xác thực và bảo vệ các API endpoints.

Kiểm tra quyền truy cập trước khi thực hiện các hành động CRUD trên bài viết và bình luận.
