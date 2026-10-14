# CAMPUS LOST & FOUND - HUIT
## HỆ THỐNG TÌM KIẾM VÀ TRAO TRẢ ĐỒ THẤT LẠC TRONG KHUÔN VIÊN TRƯỜNG

> **ĐỒ ÁN HỌC PHẦN:** Lập trình mã nguồn mở  
> **ĐƠN VỊ:** Khoa Công nghệ Thông tin – Trường Đại học Công Thương TP. Hồ Chí Minh (HUIT)  
> **GIẢNG VIÊN HƯỚNG DẪN:** ThS. Nguyễn Trần Duy Khang  
> **NHÓM THỰC HIỆN:** Nhóm 4  

---

## MỤC LỤC
1. [Giới thiệu tổng quan dự án](#1-giới-thiệu-tổng-quan-dự-án)
2. [Ngôn ngữ lập trình & Công nghệ sử dụng](#2-ngôn-ngữ-lập-trình--công-nghệ-sử-dụng)
3. [Kiến trúc hệ thống & Cơ sở dữ liệu](#3-kiến-trúc-hệ-thống--cơ-sở-dữ-liệu)
4. [Hướng dẫn cài đặt & Triển khai chi tiết](#4-hướng-dẫn-cài-đặt--triển-khai-chi-tiết)
5. [Danh sách tài khoản mẫu](#5-danh-sách-tài-khoản-mẫu)
6. [Hướng dẫn sử dụng hệ thống theo từng vai trò](#6-hướng-dẫn-sử-dụng-hệ-thống-theo-từng-vai-trò)
7. [Kiểm thử tự động (Automated Testing: TC01 – TC14)](#7-kiểm-thử-tự-động-automated-testing-tc01--tc14)

---

## 1. GIỚI THIỆU TỔNG QUAN DỰ ÁN

### 1.1. Bối cảnh & Mục tiêu đề tài
Trong môi trường giảng đường đại học với quy mô hàng chục nghìn sinh viên như Trường Đại học Công Thương TP. HCM (HUIT), tình trạng thất lạc đồ dùng cá nhân (ví tiền, thẻ sinh viên, điện thoại, máy tính bỏ túi, tài liệu học tập, chìa khóa...) diễn ra rất thường xuyên tại thư viện, căn tin, giảng đường và các bãi giữ xe. Các phương thức tìm đồ truyền thống (dán giấy thông báo, đăng tin rải rác trên các hội nhóm mạng xã hội) thường gặp nhiều hạn chế: thông tin bị trôi nhanh, thiếu quy trình đối chiếu quyền sở hữu minh bạch và dễ bị kẻ gian lợi dụng nhận đồ trái phép.

Hệ thống **Campus Lost & Found - HUIT** được xây dựng nhằm giải quyết triệt để vấn đề trên thông qua một nền tảng web tập trung:
- **Chuẩn hóa quy trình:** Đăng tin tìm đồ bị mất và báo nhặt được đồ thất lạc có kiểm duyệt bởi Ban Quản trị.
- **Xác minh quyền sở hữu an toàn:** Cho phép gửi yêu cầu nhận lại đồ (Claim) với mô tả đặc điểm nhận dạng đặc trưng trước khi tiến hành trao trả.
- **Trải nghiệm hiện đại:** Giao diện trực quan thiết kế theo phong cách **Zero-Icon UI** (tối ưu Typography, màu sắc phân cấp tinh tế, không phụ thuộc thư viện icon bên ngoài) và tuân thủ các tiêu chuẩn **Technical SEO & Semantic HTML5**.

### 1.2. Danh sách thành viên & Phân công nhiệm vụ Nhóm 4

| STT | Họ và tên | Mã số sinh viên | Vai trò | Nhiệm vụ chính được phân công |
| :---: | :--- | :---: | :---: | :--- |
| 1 | **Lê Hữu Luân** | `2001230482` | Nhóm trưởng | Khảo sát yêu cầu, thiết kế kiến trúc hệ thống, Database Migrations, thiết kế luồng nghiệp vụ bài đăng (Item), hoàn thiện Báo cáo học thuật |
| 2 | **Nguyễn Khánh Duy** | `2001230124` | Thành viên | Xây dựng chức năng xác thực (Auth), quản lý hồ sơ cá nhân (Profile), đổi mật khẩu và trang quản lý tin đăng của tôi |
| 3 | **Trương Quang Diệu** | `2001230097` | Thành viên | Xây dựng luồng yêu cầu nhận lại đồ (Claim), bình luận (Comment), bộ lọc tìm kiếm nâng cao đa tiêu chí |
| 4 | **Phạm Hải Nguyên** | `2001230581` | Thành viên | Xây dựng phân hệ Quản trị viên (Admin Dashboard, duyệt bài, xử lý Claim bằng Transaction, quản lý Danh mục, Địa điểm, Người dùng) |

---

## 2. NGÔN NGỮ LẬP TRÌNH & CÔNG NGHỆ SỬ DỤNG

Hệ thống được phát triển hoàn toàn trên nền tảng mã nguồn mở hiện đại, đảm bảo tính ổn định, bảo mật và tốc độ xử lý:

- **Ngôn ngữ phía máy chủ (Backend):** PHP `8.3.33 [TS]` (Tương thích chuẩn PHP 8.2+ theo yêu cầu học phần).
- **Web Framework:** Laravel `11.x` (v11.57.0) – áp dụng triệt để mô hình MVC, Eloquent ORM, Migration, Seeder, Request Validation, Session Security, Authentication & Custom Middleware.
- **Cơ sở dữ liệu (Database):** MySQL `9.6.0` (Lưu trữ bảng InnoDB, bảng mã chuẩn `utf8mb4_unicode_ci` hỗ trợ tiếng Việt có dấu đầy đủ).
- **Giao diện người dùng (Frontend):**
  - **Blade Template Engine:** Tách biệt layout cha con, tái sử dụng component.
  - **HTML5 Ngữ nghĩa (Semantic HTML5):** Khai báo đầy đủ các thẻ `<header>`, `<nav>`, `<main>`, `<section>`, `<article>`, `<aside>`, `<footer>`.
  - **CSS Framework:** Bootstrap `5.3.3` kết hợp kiểu dáng tùy biến (Custom CSS) thanh lịch, tối ưu trải nghiệm Responsive trên cả máy tính và điện thoại.
  - **Triết lý thiết kế Zero-Icon UI:** Không sử dụng font icon hoặc SVG, thay thế bằng Typography tiếng Việt rõ ràng, tương phản màu sắc cao và hệ thống Badge trực quan.
  - **Technical SEO:** Khai báo cấu trúc thẻ heading chuẩn mực (duy nhất 1 thẻ `<h1>` mỗi trang), thẻ Meta Robots (`index, follow` cho trang công khai; `noindex, nofollow` cho khu vực quản trị), Open Graph Protocol, Schema.org Structured Data (JSON-LD cho `WebSite` và `BreadcrumbList`).
- **Thư viện đồ họa:** PHP GD – Tự động vẽ và tạo ảnh minh họa đồ vật sắc nét (800x500px) theo dải màu từng danh mục.
- **Môi trường phát triển & Công cụ bổ trợ:**
  - Laragon 2026 (Apache 2.4.68 Port 8080, MySQL Port 3306, Mailpit Port 1025/8025).
  - Composer 2.10.x.
  - Git & GitHub phục vụ quản lý mã nguồn.
  - PHPUnit 10.x phục vụ kiểm thử đơn vị và tích hợp.

---

## 3. KIẾN TRÚC HỆ THỐNG & CƠ SỞ DỮ LIỆU

### 3.1. Sơ đồ cấu trúc thư mục dự án

```
DoAn_LT_MNM/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php        # Quản trị viên: thống kê, duyệt bài, xử lý claim, user
│   │   │   ├── AuthController.php         # Đăng nhập, đăng ký, đăng xuất, kiểm tra khóa tài khoản
│   │   │   ├── CategoryController.php     # Quản lý danh mục (tự sinh slug, chặn xóa khi có bài)
│   │   │   ├── ClaimController.php        # Gửi yêu cầu nhận đồ, chống claim trùng, hủy claim
│   │   │   ├── CommentController.php      # Gửi bình luận và xóa bình luận
│   │   │   ├── ItemController.php         # Lọc tìm kiếm, hiển thị chi tiết, đăng bài, sửa bài
│   │   │   ├── LocationController.php     # Quản lý địa điểm trường học
│   │   │   └── ProfileController.php      # Cập nhật hồ sơ cá nhân, đổi mật khẩu, xem tin cá nhân
│   │   └── Middleware/
│   │       └── AdminMiddleware.php        # Chặn truy cập trái phép vào trang quản trị (403)
│   ├── Models/
│   │   ├── Category.php                   # Model danh mục đồ vật
│   │   ├── Claim.php                      # Model yêu cầu nhận đồ
│   │   ├── Comment.php                    # Model bình luận
│   │   ├── Item.php                       # Model bài đăng thất lạc / nhặt được
│   │   ├── Location.php                   # Model địa điểm trong trường
│   │   └── User.php                       # Model người dùng / sinh viên / admin
│   └── Providers/
│       └── AppServiceProvider.php         # Khai báo cấu hình Bootstrap 5 cho Pagination
├── bootstrap/
│   └── app.php                            # Khai báo alias middleware 'admin'
├── database/
│   ├── migrations/                        # 6 tệp migration tạo các bảng nghiệp vụ
│   └── seeders/                           # 4 Seeder nạp dữ liệu mẫu và sinh ảnh tự động
├── public/
│   ├── images/                            # Thư mục lưu trữ ảnh đồ vật và avatar người dùng
│   ├── .htaccess                          # Cấu hình mod_rewrite Apache
│   └── index.php                          # Front Controller tiếp nhận request
├── resources/
│   └── views/
│       ├── admin/                         # Giao diện dành riêng cho Quản trị viên
│       ├── auth/                          # Giao diện Đăng nhập & Đăng ký tài khoản
│       ├── items/                         # Giao diện Danh sách bài đăng, Chi tiết, Đăng tin, Sửa tin
│       ├── layouts/                       # Layout chung: app.blade.php & admin.blade.php
│       ├── profile/                       # Giao diện Quản lý tài khoản, Tin của tôi, Yêu cầu của tôi
│       └── vendor/pagination/             # View phân trang tiếng Việt tùy biến
├── routes/
│   └── web.php                            # Khai báo toàn bộ định tuyến hệ thống
├── tests/
│   └── Feature/
│       └── CampusLostAndFoundTest.php     # 14 Kịch bản kiểm thử tự động toàn diện (TC01 - TC14)
├── .env.example                           # Tệp mẫu thiết lập biến môi trường
├── composer.json                          # Khai báo các gói thư viện phụ thuộc PHP
└── README.md                              # Tài liệu hướng dẫn sử dụng và triển khai dự án
```

### 3.2. Mô tả chi tiết 6 bảng cơ sở dữ liệu (`campus_lost_found`)

Hệ thống sử dụng chính xác 6 bảng nghiệp vụ liên kết chặt chẽ qua các khóa ngoại:

1. **`users` (Quản lý tài khoản):**
   - `id`: Khóa chính (BigInt Unsigned, Auto Increment).
   - `name`: Họ và tên sinh viên / quản trị viên (Varchar 255).
   - `email`: Địa chỉ email đăng nhập duy nhất (Varchar 255, Unique).
   - `password`: Mật khẩu băm an toàn chuẩn Bcrypt (Varchar 255).
   - `student_code`: Mã số sinh viên HUIT (Varchar 20, Nullable).
   - `phone`: Số điện thoại liên hệ (Varchar 20, Nullable).
   - `avatar`: Tên tệp ảnh đại diện trong `public/images` (Varchar 255, Nullable).
   - `role`: Vai trò người dùng, `admin` hoặc `user` (Enum, Mặc định `user`).
   - `is_locked`: Cờ trạng thái khóa tài khoản (Boolean, Mặc định `false`).
   - `remember_token`, `created_at`, `updated_at`.

2. **`categories` (Danh mục đồ dùng):**
   - `id`: Khóa chính.
   - `name`: Tên danh mục (Varchar 100).
   - `slug`: Chuỗi định danh URL chuẩn SEO duy nhất (Varchar 120, Unique).
   - `description`: Mô tả nhóm đồ vật (Text, Nullable).
   - `created_at`, `updated_at`.

3. **`locations` (Khu vực / Địa điểm khuôn viên trường):**
   - `id`: Khóa chính.
   - `name`: Tên địa điểm như Thư viện, Căn tin, Tòa A, Nhà xe... (Varchar 150).
   - `description`: Mô tả vị trí khuôn viên (Text, Nullable).
   - `created_at`, `updated_at`.

4. **`items` (Bài đăng đồ thất lạc & nhặt được):**
   - `id`: Khóa chính.
   - `user_id`: Khóa ngoại trỏ đến bảng `users` (`cascadeOnDelete`).
   - `category_id`: Khóa ngoại trỏ đến bảng `categories` (`restrictOnDelete` – ngăn xóa danh mục nếu có bài đăng).
   - `location_id`: Khóa ngoại trỏ đến bảng `locations` (`restrictOnDelete` – ngăn xóa địa điểm nếu có bài đăng).
   - `type`: Phân loại tin đăng, `lost` (đồ bị mất) hoặc `found` (đồ nhặt được) (Enum).
   - `title`: Tiêu đề bài viết (Varchar 255).
   - `description`: Mô tả chi tiết đặc điểm tài sản (Text).
   - `image`: Tên tệp ảnh chụp thực tế trong `public/images` (Varchar 255, Nullable).
   - `event_date`: Ngày xảy ra sự việc (Date, Ràng buộc không ở tương lai).
   - `contact_info`: Thông tin số điện thoại / Zalo người liên hệ (Varchar 255, Nullable).
   - `status`: Trạng thái bài đăng: `pending` (chờ duyệt), `approved` (đã duyệt hiển thị), `rejected` (từ chối), `returned` (đã hoàn trả) (Enum, Mặc định `pending`).
   - `created_at`, `updated_at`.

5. **`claims` (Yêu cầu nhận lại đồ):**
   - `id`: Khóa chính.
   - `item_id`: Khóa ngoại trỏ đến bảng `items` (`cascadeOnDelete`).
   - `user_id`: Khóa ngoại trỏ đến sinh viên gửi yêu cầu (`cascadeOnDelete`).
   - `message`: Đặc điểm nhận dạng chứng minh sở hữu (Text, Tối thiểu 20 ký tự).
   - `status`: Trạng thái xử lý: `pending` (chờ duyệt), `approved` (đã duyệt trao trả), `rejected` (từ chối) (Enum, Mặc định `pending`).
   - `admin_note`: Ghi chú đối chiếu của Ban Quản trị (Text, Nullable).
   - `created_at`, `updated_at`.

6. **`comments` (Bình luận & Trao đổi):**
   - `id`: Khóa chính.
   - `item_id`: Khóa ngoại trỏ đến bảng `items` (`cascadeOnDelete`).
   - `user_id`: Khóa ngoại trỏ đến người bình luận (`cascadeOnDelete`).
   - `content`: Nội dung trao đổi (Text, Tối đa 500 ký tự).
   - `created_at`, `updated_at`.

### 3.3. Sơ đồ vòng đời trạng thái bài đăng (State Lifecycle)

```
[Người dùng đăng bài mới] ──► Trạng thái: PENDING (Chờ duyệt)
                                   │
                 ┌─────────────────┴─────────────────┐
                 ▼                                   ▼
          Admin duyệt bài                     Admin từ chối bài
                 │                                   │
                 ▼                                   ▼
          Trạng thái: APPROVED               Trạng thái: REJECTED
                 │
  ┌──────────────┴──────────────┐
  │ Tác giả chỉnh sửa nội dung  │ ──► Tự động quay về PENDING (Chờ duyệt lại)
  └─────────────────────────────┘
                 │
     Sinh viên gửi Claim hợp lệ
                 │
       Admin xác nhận duyệt Claim
                 │
                 ▼
          Trạng thái: RETURNED (Đã trả)
          (Tự động từ chối các Claim còn lại của bài đăng)
```

---

## 4. HƯỚNG DẪN CÀI ĐẶT & TRIỂN KHAI CHI TIẾT

### 4.1. Yêu cầu môi trường
- Hệ điều hành: Windows 10 / 11 (khuyến nghị chạy trên môi trường **Laragon 2026**).
- PHP: Phiên bản `>= 8.2` (môi trường máy chủ đã cấu hình `php-8.3.33-Win32-vs16-x64`).
- MySQL: Phiên bản `>= 8.0` hoặc `9.x`.
- Web Server: Apache hoặc Nginx (kèm mô đun `mod_rewrite`).
- Thư viện mở rộng PHP bắt buộc: `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `gd`, `curl`, `tokenizer`, `xml`.

### 4.2. Các bước cài đặt qua dòng lệnh

Mở cửa sổ dòng lệnh PowerShell hoặc Command Prompt tại thư mục dự án:
```powershell
cd D:\Laragon_code\laragon\www\DoAn_LT_MNM
```

#### Bước 1: Cài đặt các thư viện phụ thuộc của Laravel
```powershell
composer install
```

#### Bước 2: Cấu hình tệp biến môi trường `.env`
Sao chép tệp mẫu hoặc chỉnh sửa tệp `.env` với các tham số kết nối MySQL Laragon:
```env
APP_NAME="Campus Lost & Found - HUIT"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=Asia/Ho_Chi_Minh
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=campus_lost_found
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
```

#### Bước 3: Tạo khóa mã hóa ứng dụng (Application Key)
```powershell
php artisan key:generate
```

#### Bước 4: Tạo cơ sở dữ liệu trong MySQL
Khởi chạy MySQL trên Laragon, sau đó chạy lệnh sau để tạo database nếu chưa có:
```powershell
mysql -u root -e "CREATE DATABASE IF NOT EXISTS campus_lost_found CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

#### Bước 5: Chạy Migrations, Seed dữ liệu mẫu & Tự động sinh ảnh đồ vật
Lệnh dưới đây sẽ tự động tạo đủ 6 bảng, khởi tạo tài khoản Admin và sinh viên, tự động vẽ 19 tệp ảnh `.png` bằng thư viện GD và nạp dữ liệu mẫu hoàn chỉnh:
```powershell
php artisan migrate:fresh --seed
```

### 4.3. Cách khởi chạy và truy cập hệ thống

#### Cách 1: Sử dụng Apache tích hợp sẵn của Laragon (Cổng 8080)
Khởi động Apache trên Laragon và truy cập trực tiếp qua trình duyệt web:
- **Địa chỉ truy cập:** [http://localhost:8080/DoAn_LT_MNM/public](http://localhost:8080/DoAn_LT_MNM/public)
*(Hoặc Virtual Host tự động của Laragon: `http://doan_lt_mnm.test:8080`)*

#### Cách 2: Sử dụng máy chủ nội bộ Artisan Serve
Mở terminal và gõ:
```powershell
php artisan serve --port=8080
```
Sau đó truy cập trình duyệt theo địa chỉ: [http://localhost:8080](http://localhost:8080)

---

## 5. DANH SÁCH TÀI KHOẢN MẪU

Dữ liệu Seeder đã tạo sẵn các tài khoản thử nghiệm với đầy đủ phân quyền:

| Phân quyền | Họ và tên | Địa chỉ Email đăng nhập | Mật khẩu | Ghi chú tài khoản |
| :--- | :--- | :--- | :---: | :--- |
| **Quản trị viên (Admin)** | Ban Quản Trị HUIT | `admin@huit.edu.vn` | `123456` | Có toàn quyền kiểm duyệt bài, xử lý Claim và quản lý hệ thống |
| **Sinh viên (User)** | Lê Hữu Luân | `2001230482@huit.edu.vn` | `123456` | MSSV: `2001230482` – Nhóm trưởng |
| **Sinh viên (User)** | Nguyễn Khánh Duy | `2001230124@huit.edu.vn` | `123456` | MSSV: `2001230124` |
| **Sinh viên (User)** | Trương Quang Diệu | `2001230097@huit.edu.vn` | `123456` | MSSV: `2001230097` |
| **Sinh viên (User)** | Phạm Hải Nguyên | `2001230581@huit.edu.vn` | `123456` | MSSV: `2001230581` |

---

## 6. HƯỚNG DẪN SỬ DỤNG HỆ THỐNG THEO TỪNG VAI TRÒ

### 6.1. Dành cho Khách vãng lai (Guest)
- **Xem bài đăng:** Truy cập trang chủ xem toàn bộ các bài đăng đồ bị mất / nhặt được đã được duyệt hiển thị (`approved`).
- **Tìm kiếm đa tiêu chí:** Lọc đồng thời theo từ khóa tên đồ vật, phân loại (Đồ bị mất / Đồ nhặt được), danh mục (Điện thoại, Ví, Thẻ sinh viên...) và địa điểm (Thư viện, Căn tin, Tòa A...).
- **Xem chi tiết bài đăng:** Xem thông tin đặc điểm, hình ảnh thực tế, ngày xảy ra và các bài viết liên quan.
- **Đăng ký tài khoản sinh viên:** Nhập họ tên, email, MSSV, SĐT và mật khẩu để tham gia hệ thống.

### 6.2. Dành cho Sinh viên đã đăng nhập (User)
- **Đăng tin mới:**
  - Nhấp nút `Đăng tin mới` trên thanh menu.
  - Chọn loại tin: *Tôi bị mất đồ* hoặc *Tôi nhặt được đồ*.
  - Nhập tiêu đề, chọn danh mục, địa điểm, ngày xảy ra (hệ thống chặn chọn ngày tương lai), mô tả chi tiết và tải ảnh minh họa (tối đa 2MB).
  - Tin đăng sau khi gửi sẽ ở trạng thái `Chờ duyệt`.
- **Quản lý tin đăng cá nhân:**
  - Truy cập menu `Tin đăng của tôi` để theo dõi tiến độ duyệt.
  - Được quyền sửa đổi nội dung bài đăng của mình (khi sửa, bài tự động quay về `Chờ duyệt` để đảm bảo tính xác thực).
  - Được quyền xóa bài đăng cá nhân (tự động xóa ảnh trên server).
- **Gửi yêu cầu nhận lại đồ (Claim):**
  - Tại trang chi tiết bài đăng của người khác, nếu phát hiện đó là tài sản của mình, sinh viên điền thông tin đặc điểm nhận dạng đặc trưng vào khung `Yêu cầu nhận lại đồ`.
  - Quy định bắt buộc: Nội dung chứng minh phải có tối thiểu 20 ký tự.
  - Hệ thống ngăn chặn việc tác giả tự claim bài của chính mình và ngăn chặn gửi trùng lặp yêu cầu khi đang có yêu cầu chờ xử lý.
- **Theo dõi yêu cầu nhận đồ:** Vào mục `Yêu cầu nhận đồ đã gửi` để xem trạng thái phản hồi và ghi chú đối chiếu từ Admin. Được phép hủy yêu cầu nếu đang chờ duyệt.
- **Bình luận trao đổi:** Viết bình luận trực tiếp bên dưới bài đăng để hỏi han hoặc cung cấp thông tin.
- **Cập nhật hồ sơ & Đổi mật khẩu:** Thay đổi họ tên, số điện thoại, MSSV, avatar và đổi mật khẩu mới (yêu cầu xác thực mật khẩu hiện tại).

### 6.3. Dành cho Quản trị viên (Admin)
Sau khi đăng nhập tài khoản `admin@huit.edu.vn`, hệ thống tự động mở ra phân hệ Quản trị (`/admin`):
- **Bảng điều khiển (Dashboard):** Thống kê tức thời 4 chỉ số: số tài khoản sinh viên, số bài đăng chờ duyệt, số đồ vật đã hoàn trả thành công, số yêu cầu nhận đồ cần giải quyết. Đồng thời hiển thị danh sách 5 yêu cầu nhận đồ mới nhất.
- **Quản lý bài đăng:** Duyệt nhanh các bài đăng hợp lệ (`Duyệt bài`), từ chối bài vi phạm nội quy (`Từ chối`) hoặc gỡ bỏ (`Xóa`).
- **Xử lý yêu cầu nhận lại đồ (Claim):**
  - Bấm nút `Đối chiếu & Xử lý` tại từng yêu cầu.
  - Đối chiếu mô tả của người gửi với đặc điểm tài sản.
  - Nếu duyệt (`Duyệt – Xác nhận đúng chủ sở hữu`): Hệ thống thực thi trong một Database Transaction duy nhất để:
    1. Cập nhật yêu cầu được duyệt thành `approved`.
    2. Tự động chuyển bài đăng đồ vật sang trạng thái `Đã trả` (`returned`).
    3. Tự động từ chối (`rejected`) tất cả các yêu cầu nhận đồ còn lại của bài đăng đó kèm thông báo rõ ràng.
- **Quản lý Danh mục & Địa điểm:** Thêm mới, chỉnh sửa, tự sinh slug. Ngăn chặn tuyệt đối việc xóa các danh mục hoặc địa điểm đang có bài đăng liên kết.
- **Quản lý Người dùng:** Tìm kiếm sinh viên theo tên/email/MSSV, xem trạng thái, thực hiện khóa/mở khóa tài khoản ngay lập tức, chuyển đổi phân quyền giữa Sinh viên và Quản trị viên.

---

## 7. KIỂM THỬ TỰ ĐỘNG (AUTOMATED TESTING: TC01 – TC14)

Dự án tích hợp bộ kiểm thử tự động toàn diện được viết bằng **PHPUnit** trong tệp [tests/Feature/CampusLostAndFoundTest.php](file:///D:/Laragon_code/laragon/www/DoAn_LT_MNM/tests/Feature/CampusLostAndFoundTest.php). Toàn bộ 14 kịch bản kiểm thử (tương ứng Bảng 4.2 trong báo cáo Word) đều được tự động hóa 100%:

### 7.1. Bảng đặc tả 14 kịch bản kiểm thử

| Mã kịch bản | Tên kiểm thử | Mô tả kịch bản kiểm tra | Kết quả kỳ vọng |
| :---: | :--- | :--- | :--- |
| **TC01** | `test_tc01_user_registration` | Đăng ký tài khoản sinh viên mới với đầy đủ trường dữ liệu hợp lệ | Tạo bản ghi mới trong bảng `users`, tự động đăng nhập và chuyển hướng về trang chủ |
| **TC02** | `test_tc02_user_login_and_locked_check` | Kiểm tra đăng nhập sai mật khẩu, đăng nhập thành công, và đăng nhập khi tài khoản bị admin khóa (`is_locked = true`) | Báo lỗi khi sai mật khẩu, từ chối đăng nhập khi bị khóa; đăng nhập đúng chuyển vào hệ thống |
| **TC03** | `test_tc03_user_logout` | Kiểm tra tính năng đăng xuất tài khoản | Hủy phiên đăng nhập (Session invalidate) và đưa người dùng về trạng thái Guest |
| **TC04** | `test_tc04_browse_and_filter_items` | Lọc bài đăng trang chủ kết hợp đồng thời tiêu chí loại tin (`type`) và danh mục (`category_id`) | Trả về HTTP 200, truyền đúng danh sách bài đăng đã lọc ra View |
| **TC05** | `test_tc05_view_item_details` | Kiểm tra quyền xem bài đăng: khách chỉ xem bài `approved`/`returned`; bài `pending` người ngoài bị chặn (403), chỉ tác giả mới xem được | Chặn 403 đối với khách xem bài chờ duyệt; cho phép tác giả xem bài của mình |
| **TC06** | `test_tc06_create_new_item` | Sinh viên đăng bài viết mới với các trường dữ liệu hợp lệ | Bài viết được lưu vào CSDL với trạng thái mặc định là `pending` chờ kiểm duyệt |
| **TC07** | `test_tc07_create_comment` | Sinh viên đã đăng nhập gửi bình luận vào bài đăng | Lưu bản ghi bình luận vào bảng `comments` liên kết với `item_id` và `user_id` |
| **TC08** | `test_tc08_edit_item_ownership_and_status_reset` | Kiểm tra quyền chỉnh sửa bài đăng: người khác sửa bị chặn (403); chính chủ sửa thì trạng thái tự động reset về `pending` | Chặn 403 kẻ mạo danh; cập nhật thành công và đổi status về `pending` để admin duyệt lại |
| **TC09** | `test_tc09_delete_item` | Kiểm tra quyền xóa bài: sinh viên khác xóa bị chặn (403); chính tác giả xóa thành công | Chặn 403 người lạ; xóa bản ghi khỏi bảng `items` khi chính chủ yêu cầu |
| **TC10** | `test_tc10_pagination_greater_than_9_items` | Kiểm tra phân trang danh sách bài đăng (yêu cầu tối đa 9 bài / trang) | Trang chủ hiển thị `<= 9` bài trên trang hiện tại, tổng số bài `> 9` và thanh phân trang hoạt động |
| **TC11** | `test_tc11_claim_submission_rules` | Kiểm tra các ràng buộc Claim: tác giả không được claim bài của mình (403); mô tả `< 20` ký tự bị lỗi; không được gửi claim thứ 2 khi claim cũ đang pending | Chặn tự claim; bắt buộc mô tả `>= 20` ký tự; ngăn chặn gửi trùng lặp yêu cầu |
| **TC12** | `test_tc12_admin_handles_claim_transaction` | Admin duyệt một Claim: thực thi Transaction đổi trạng thái Item thành `returned` và tự động từ chối tất cả Claim pending khác | Item chuyển sang `returned`, claim được duyệt thành `approved`, các claim pending khác chuyển thành `rejected` |
| **TC13** | `test_tc13_category_delete_prevention` | Admin xóa danh mục: nếu danh mục đang có bài đăng liên kết thì ngăn chặn và báo lỗi; chỉ cho xóa danh mục rỗng | Báo lỗi ngăn xóa danh mục có dữ liệu; cho phép xóa khi danh mục không có bài liên kết |
| **TC14** | `test_tc14_user_management` | Admin thao tác quản lý: khóa tài khoản, mở khóa, nâng quyền Admin, xóa tài khoản; chặn admin tự khóa/xóa chính mình | Thao tác thành công trên tài khoản thành viên; báo lỗi khi admin thao tác trên tài khoản hiện tại |

### 7.2. Lệnh thực thi kiểm thử
Để chạy toàn bộ bài kiểm tra và theo dõi kết quả:
```powershell
php artisan test
```

Kết quả thực thi thực tế trên môi trường máy chủ:
```
   PASS  Tests\Unit\ExampleTest
  ✓ that true is true                                                  0.01s  

   PASS  Tests\Feature\CampusLostAndFoundTest
  ✓ tc01 user registration                                            0.33s  
  ✓ tc02 user login and locked check                                  0.56s  
  ✓ tc03 user logout                                                  0.03s  
  ✓ tc04 browse and filter items                                      0.06s  
  ✓ tc05 view item details                                            0.07s  
  ✓ tc06 create new item                                              0.03s  
  ✓ tc07 create comment                                               0.03s  
  ✓ tc08 edit item ownership and status reset                         0.05s  
  ✓ tc09 delete item                                                  0.05s  
  ✓ tc10 pagination greater than 9 items                              0.03s  
  ✓ tc11 claim submission rules                                       0.04s  
  ✓ tc12 admin handles claim transaction                              0.09s  
  ✓ tc13 category delete prevention                                   0.05s  
  ✓ tc14 user management                                              0.06s  

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response                     0.05s  

  Tests:    16 passed (66 assertions)
  Duration: 1.76s
```

---

## 8. THÔNG TIN BẢN QUYỀN
Dự án được xây dựng phục vụ mục đích học tập và nghiên cứu trong khuôn khổ học phần **Lập trình mã nguồn mở** tại Trường Đại học Công Thương TP. Hồ Chí Minh (HUIT).  
Toàn bộ mã nguồn mở tuân thủ giấy phép [MIT License](https://opensource.org/licenses/MIT).
