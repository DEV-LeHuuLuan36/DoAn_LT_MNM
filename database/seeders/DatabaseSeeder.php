<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Claim;
use App\Models\Comment;
use App\Models\Item;
use App\Models\Location;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            LocationSeeder::class,
        ]);

        $users = User::where('role', 'user')->get();
        $cats = Category::all()->keyBy('slug');
        $locs = Location::all()->keyBy('name');

        if ($users->isEmpty() || $cats->isEmpty() || $locs->isEmpty()) {
            return;
        }

        $user1 = $users[0]; // Lê Hữu Luân
        $user2 = $users[1]; // Nguyễn Khánh Duy
        $user3 = $users[2]; // Trương Quang Diệu
        $user4 = $users[3]; // Phạm Hải Nguyên

        // Tạo thư mục public/images nếu chưa tồn tại
        if (!is_dir(public_path('images'))) {
            @mkdir(public_path('images'), 0777, true);
        }

        // 14 bài đăng approved (đáp ứng phân trang > 9 bài/trang)
        $approvedItems = [
            [
                'user_id' => $user1->id,
                'category_id' => $cats['dien-thoai']->id,
                'location_id' => $locs['Thư viện']->id,
                'type' => 'lost',
                'title' => 'Để quên điện thoại iPhone 11 màu đen tại bàn đọc tầng 2',
                'short_title' => 'iPhone 11 Đen 64GB',
                'description' => 'Mình có để quên một chiếc iPhone 11 màu đen có ốp lưng trong suốt viền xanh tại bàn đọc sách lầu 2 Thư viện chiều ngày hôm qua. Màn hình khóa có hình chú mèo.',
                'event_date' => Carbon::now()->subDays(1)->toDateString(),
                'contact_info' => 'SĐT: 0912345678 (Luân)',
                'status' => 'approved',
                'image_name' => 'item_1.png',
            ],
            [
                'user_id' => $user2->id,
                'category_id' => $cats['giay-to-the-sinh-vien']->id,
                'location_id' => $locs['Căn tin']->id,
                'type' => 'found',
                'title' => 'Nhặt được Thẻ sinh viên HUIT mang tên Trần Minh Tâm',
                'short_title' => 'Thẻ Sinh Viên HUIT - Trần Minh Tâm',
                'description' => 'Trưa nay lúc ăn cơm tại Căn tin bàn số 14, mình có nhặt được 01 thẻ sinh viên khoa CNTT tên Trần Minh Tâm, MSSV: 2001229988. Bạn nào là chủ nhân liên hệ mình để nhận lại nhé.',
                'event_date' => Carbon::now()->toDateString(),
                'contact_info' => 'Liên hệ Duy - 0923456789 hoặc qua zalo',
                'status' => 'approved',
                'image_name' => 'item_2.png',
            ],
            [
                'user_id' => $user3->id,
                'category_id' => $cats['vi-bop']->id,
                'location_id' => $locs['Nhà xe']->id,
                'type' => 'lost',
                'title' => 'Rơi ví da nam màu nâu tại khu vực gửi xe máy Tòa B',
                'short_title' => 'Ví Da Nam Màu Nâu Pedro',
                'description' => 'Sáng nay khoảng 7h15 lúc lấy xe tại hầm xe Tòa B mình làm rơi ví da màu nâu hiệu Pedro. Bên trong có GPLX, CCCD và một ít tiền mặt. Rất mong bạn nào nhặt được cho mình chuộc lại.',
                'event_date' => Carbon::now()->subDays(2)->toDateString(),
                'contact_info' => 'Diệu - 0934567890',
                'status' => 'approved',
                'image_name' => 'item_3.png',
            ],
            [
                'user_id' => $user4->id,
                'category_id' => $cats['tai-nghe-thiet-bi-dien-tu']->id,
                'location_id' => $locs['Tòa B']->id,
                'type' => 'found',
                'title' => 'Nhặt được hộp sạc tai nghe AirPods Pro màu trắng phòng B302',
                'short_title' => 'Hộp Sạc Tai Nghe AirPods Pro',
                'description' => 'Sau tiết học Kỹ thuật lập trình tại phòng máy B302, mình thấy hộp sạc tai nghe AirPods Pro bỏ quên trên bàn giáo viên. Hiện mình đang giữ, ai mất liên hệ đối chiếu seri.',
                'event_date' => Carbon::now()->subDays(1)->toDateString(),
                'contact_info' => 'Nguyên - 0945678901',
                'status' => 'approved',
                'image_name' => 'item_4.png',
            ],
            [
                'user_id' => $user1->id,
                'category_id' => $cats['chia-khoa']->id,
                'location_id' => $locs['Sân thể thao']->id,
                'type' => 'found',
                'title' => 'Chùm chìa khóa xe Honda kèm móc khóa gấu bông màu đỏ',
                'short_title' => 'Chùm Chìa Khóa Smartkey Honda',
                'description' => 'Nhặt được ở hàng ghế khán đài sân bóng rổ trường vào chiều thứ Ba. Chùm gồm 2 chìa khóa xe máy Smartkey và 1 chìa khóa phòng trọ.',
                'event_date' => Carbon::now()->subDays(3)->toDateString(),
                'contact_info' => '0912345678',
                'status' => 'approved',
                'image_name' => 'item_5.png',
            ],
            [
                'user_id' => $user2->id,
                'category_id' => $cats['sach-vo-tai-lieu']->id,
                'location_id' => $locs['Tòa A']->id,
                'type' => 'lost',
                'title' => 'Mất tập giáo trình Cấu trúc dữ liệu và giải thuật tại phòng A205',
                'short_title' => 'Giáo Trình Cấu Trúc Dữ Liệu',
                'description' => 'Chiều qua mình học môn CTDL&GT tại phòng A205 và có bỏ quên cuốn giáo trình bìa xanh lá, bên trong có kẹp nhiều bài tập và ghi chú quan trọng.',
                'event_date' => Carbon::now()->subDays(2)->toDateString(),
                'contact_info' => 'Duy - duy.nk@huit.edu.vn',
                'status' => 'approved',
                'image_name' => 'item_6.png',
            ],
            [
                'user_id' => $user3->id,
                'category_id' => $cats['binh-nuoc-do-dung-ca-nhan']->id,
                'location_id' => $locs['Thư viện']->id,
                'type' => 'found',
                'title' => 'Bình giữ nhiệt Lock&Lock màu xanh ngọc tại phòng tự học',
                'short_title' => 'Bình Giữ Nhiệt Lock&Lock Xanh Ngọc',
                'description' => 'Bình giữ nhiệt dung tích 500ml màu xanh ngọc bích, có dán sticker anime One Piece, để quên tại góc tự học tầng 1 Thư viện.',
                'event_date' => Carbon::now()->subDays(1)->toDateString(),
                'contact_info' => 'Diệu - 0934567890',
                'status' => 'approved',
                'image_name' => 'item_7.png',
            ],
            [
                'user_id' => $user4->id,
                'category_id' => $cats['dien-thoai']->id,
                'location_id' => $locs['Căn tin']->id,
                'type' => 'found',
                'title' => 'Nhặt được điện thoại Samsung Galaxy A54 màu tím nhạt',
                'short_title' => 'Điện Thoại Samsung Galaxy A54',
                'description' => 'Trưa nay nhặt được máy Samsung màu tím nhạt để trên bàn ăn căn tin. Máy đã hết pin tắt nguồn, đã sạc lên được một chút. Ai là chủ nhân vui lòng đem giấy tờ xác minh.',
                'event_date' => Carbon::now()->toDateString(),
                'contact_info' => 'Nguyên - 0945678901',
                'status' => 'approved',
                'image_name' => 'item_8.png',
            ],
            [
                'user_id' => $user1->id,
                'category_id' => $cats['giay-to-the-sinh-vien']->id,
                'location_id' => $locs['Tòa C']->id,
                'type' => 'lost',
                'title' => 'Rơi ví kẹp thẻ chứa Căn cước công dân và thẻ ATM Vietcombank',
                'short_title' => 'Ví Kẹp Thẻ CCCD & Thẻ ATM',
                'description' => 'Đoạn đường từ sảnh Tòa C sang văn phòng khoa mình làm rơi bóp kẹp thẻ màu xám. Bên trong có thẻ CCCD mang tên Lê Hữu Luân.',
                'event_date' => Carbon::now()->subDays(4)->toDateString(),
                'contact_info' => '0912345678',
                'status' => 'approved',
                'image_name' => 'item_9.png',
            ],
            [
                'user_id' => $user2->id,
                'category_id' => $cats['tai-nghe-thiet-bi-dien-tu']->id,
                'location_id' => $locs['Thư viện']->id,
                'type' => 'lost',
                'title' => 'Tìm chuột không dây Logitech MX Anywhere 3 màu xám tro',
                'short_title' => 'Chuột Không Dây Logitech MX Anywhere 3',
                'description' => 'Hôm qua mình ngồi làm đồ án tại phòng máy tính thư viện lầu 3 và để quên chuột không dây. Chuột có vết xước nhẹ ở nút click trái.',
                'event_date' => Carbon::now()->subDays(2)->toDateString(),
                'contact_info' => '2001230124@huit.edu.vn',
                'status' => 'approved',
                'image_name' => 'item_10.png',
            ],
            [
                'user_id' => $user3->id,
                'category_id' => $cats['binh-nuoc-do-dung-ca-nhan']->id,
                'location_id' => $locs['Nhà xe']->id,
                'type' => 'found',
                'title' => 'Nhặt được nón bảo hiểm Royal màu xanh rêu còn mới',
                'short_title' => 'Nón Bảo Hiểm Royal Xanh Rêu',
                'description' => 'Bác bảo vệ gửi mình nón bảo hiểm treo trên gương xe máy Wave đỏ ở hàng B nhà xe suốt 2 ngày chưa thấy ai lấy. Bạn nào quên thì liên hệ nhận lại.',
                'event_date' => Carbon::now()->subDays(2)->toDateString(),
                'contact_info' => '0934567890',
                'status' => 'approved',
                'image_name' => 'item_11.png',
            ],
            [
                'user_id' => $user4->id,
                'category_id' => $cats['sach-vo-tai-lieu']->id,
                'location_id' => $locs['Tòa B']->id,
                'type' => 'found',
                'title' => 'Tài liệu ôn thi Lập trình mã nguồn mở của Nhóm 4',
                'short_title' => 'Tài Liệu Ôn Thi Lập Trình Mã Nguồn Mở',
                'description' => 'Thấy một bìa hồ sơ màu vàng chứa bản thảo tài liệu báo cáo đồ án và một cuốn sổ tay nhỏ để quên tại ghế đá trước Tòa B.',
                'event_date' => Carbon::now()->subDays(1)->toDateString(),
                'contact_info' => 'Phòng thực hành B301 hoặc gọi 0945678901',
                'status' => 'approved',
                'image_name' => 'item_12.png',
            ],
            [
                'user_id' => $user1->id,
                'category_id' => $cats['chia-khoa']->id,
                'location_id' => $locs['Tòa A']->id,
                'type' => 'lost',
                'title' => 'Đánh rơi chìa khóa xe Yamaha Exciter kèm thẻ từ chung cư',
                'short_title' => 'Chìa Khóa Xe Yamaha & Thẻ Từ',
                'description' => 'Sáng nay di chuyển từ cầu thang bộ tầng 3 Tòa A xuống sảnh trệt, mình đánh rơi móc khóa xe máy và thẻ từ thang máy màu xanh dương.',
                'event_date' => Carbon::now()->toDateString(),
                'contact_info' => 'Luân - 0912345678',
                'status' => 'approved',
                'image_name' => 'item_13.png',
            ],
            [
                'user_id' => $user2->id,
                'category_id' => $cats['tai-nghe-thiet-bi-dien-tu']->id,
                'location_id' => $locs['Căn tin']->id,
                'type' => 'found',
                'title' => 'Nhặt được sạc dự phòng Baseus 20000mAh màu đen',
                'short_title' => 'Sạc Dự Phòng Baseus 20000mAh',
                'description' => 'Cục pin sạc dự phòng công suất 65W màu đen nhám để quên cạnh ổ cắm điện căn tin trường trưa hôm nay.',
                'event_date' => Carbon::now()->toDateString(),
                'contact_info' => 'Liên hệ Duy - SĐT: 0923456789',
                'status' => 'approved',
                'image_name' => 'item_14.png',
            ],
        ];

        foreach ($approvedItems as $data) {
            $cat = Category::find($data['category_id']);
            $loc = Location::find($data['location_id']);
            $this->generateIllustrationImage(
                $data['image_name'],
                $data['short_title'],
                $cat ? $cat->name : 'Đồ dùng',
                $loc ? $loc->name : 'Khuôn viên trường',
                $data['type']
            );

            Item::create([
                'user_id' => $data['user_id'],
                'category_id' => $data['category_id'],
                'location_id' => $data['location_id'],
                'type' => $data['type'],
                'title' => $data['title'],
                'description' => $data['description'],
                'image' => $data['image_name'],
                'event_date' => $data['event_date'],
                'contact_info' => $data['contact_info'],
                'status' => $data['status'],
            ]);
        }

        // 3 bài pending
        $pendingItems = [
            [
                'user_id' => $user3->id,
                'category_id' => $cats['dien-thoai']->id,
                'location_id' => $locs['Sân thể thao']->id,
                'type' => 'lost',
                'title' => 'Đánh rơi điện thoại Xiaomi Redmi Note 12 khi chơi bóng chuyền',
                'short_title' => 'Điện Thoại Xiaomi Redmi Note 12',
                'description' => 'Chiều nay lúc 16h mình tham gia đá cầu tại sân thể thao và bị rớt điện thoại Xiaomi màu xanh dương. Mặt lưng có dán tem bảo hành.',
                'event_date' => Carbon::now()->toDateString(),
                'contact_info' => 'Diệu - 0934567890',
                'status' => 'pending',
                'image_name' => 'item_15.png',
            ],
            [
                'user_id' => $user4->id,
                'category_id' => $cats['vi-bop']->id,
                'location_id' => $locs['Tòa C']->id,
                'type' => 'found',
                'title' => 'Nhặt được ví nữ mini màu hồng phấn tại hành lang tầng 3',
                'short_title' => 'Ví Nữ Mini Màu Hồng Phấn',
                'description' => 'Hành lang tầng 3 Tòa C, nhặt được chiếc ví nữ nhỏ màu hồng nhạt. Bên trong có thẻ ngân hàng Agribank và một số giấy tờ.',
                'event_date' => Carbon::now()->toDateString(),
                'contact_info' => 'Nguyên - 0945678901',
                'status' => 'pending',
                'image_name' => 'item_16.png',
            ],
            [
                'user_id' => $user1->id,
                'category_id' => $cats['binh-nuoc-do-dung-ca-nhan']->id,
                'location_id' => $locs['Phòng Công tác sinh viên (CTSV)']->id,
                'type' => 'lost',
                'title' => 'Để quên áo khoác dù màu đen có logo HUIT trước phòng CTSV',
                'short_title' => 'Áo Khoác Dù Đen Logo HUIT',
                'description' => 'Hôm qua đến phòng CTSV nộp hồ sơ xin giấy xác nhận sinh viên mình có cởi áo khoác vắt trên hàng ghế chờ và quên mang về.',
                'event_date' => Carbon::now()->subDays(1)->toDateString(),
                'contact_info' => '0912345678',
                'status' => 'pending',
                'image_name' => 'item_17.png',
            ],
        ];

        foreach ($pendingItems as $data) {
            $cat = Category::find($data['category_id']);
            $loc = Location::find($data['location_id']);
            $this->generateIllustrationImage(
                $data['image_name'],
                $data['short_title'],
                $cat ? $cat->name : 'Đồ dùng',
                $loc ? $loc->name : 'Khuôn viên trường',
                $data['type']
            );

            Item::create([
                'user_id' => $data['user_id'],
                'category_id' => $data['category_id'],
                'location_id' => $data['location_id'],
                'type' => $data['type'],
                'title' => $data['title'],
                'description' => $data['description'],
                'image' => $data['image_name'],
                'event_date' => $data['event_date'],
                'contact_info' => $data['contact_info'],
                'status' => $data['status'],
            ]);
        }

        // 2 bài returned
        $returnedItems = [
            [
                'user_id' => $user2->id,
                'category_id' => $cats['giay-to-the-sinh-vien']->id,
                'location_id' => $locs['Thư viện']->id,
                'type' => 'found',
                'title' => 'Thẻ sinh viên HUIT mang tên Lê Văn Long',
                'short_title' => 'Thẻ Sinh Viên HUIT - Lê Văn Long',
                'description' => 'Đã xác minh và hoàn trả trực tiếp cho bạn Long vào sáng hôm nay tại sảnh chính Thư viện.',
                'event_date' => Carbon::now()->subDays(5)->toDateString(),
                'contact_info' => 'Đã bàn giao hoàn tất',
                'status' => 'returned',
                'image_name' => 'item_18.png',
            ],
            [
                'user_id' => $user3->id,
                'category_id' => $cats['chia-khoa']->id,
                'location_id' => $locs['Nhà xe']->id,
                'type' => 'lost',
                'title' => 'Chìa khóa xe máy Sirius màu đen',
                'short_title' => 'Chìa Khóa Xe Máy Sirius Đen',
                'description' => 'Mình đã nhận lại chùm chìa khóa từ phòng bảo vệ nhà xe Tòa A. Xin chân thành cảm ơn các bạn và các chú bảo vệ!',
                'event_date' => Carbon::now()->subDays(6)->toDateString(),
                'contact_info' => 'Đã giải quyết',
                'status' => 'returned',
                'image_name' => 'item_19.png',
            ],
        ];

        foreach ($returnedItems as $data) {
            $cat = Category::find($data['category_id']);
            $loc = Location::find($data['location_id']);
            $this->generateIllustrationImage(
                $data['image_name'],
                $data['short_title'],
                $cat ? $cat->name : 'Đồ dùng',
                $loc ? $loc->name : 'Khuôn viên trường',
                $data['type']
            );

            Item::create([
                'user_id' => $data['user_id'],
                'category_id' => $data['category_id'],
                'location_id' => $data['location_id'],
                'type' => $data['type'],
                'title' => $data['title'],
                'description' => $data['description'],
                'image' => $data['image_name'],
                'event_date' => $data['event_date'],
                'contact_info' => $data['contact_info'],
                'status' => $data['status'],
            ]);
        }

        // Tạo dữ liệu Claim mẫu
        $firstFoundItem = Item::where('type', 'found')->where('status', 'approved')->first();
        if ($firstFoundItem) {
            Claim::create([
                'item_id' => $firstFoundItem->id,
                'user_id' => $user3->id,
                'message' => 'Chào bạn, thẻ sinh viên này chính xác là của mình bị rơi trưa nay tại căn tin. Mình có mang theo CCCD và app sinh viên HUIT để đối chiếu thông tin cá nhân.',
                'status' => 'pending',
                'admin_note' => null,
            ]);
        }

        // Tạo claim đã duyệt cho bài returned
        $firstReturnedItem = Item::where('status', 'returned')->first();
        if ($firstReturnedItem) {
            Claim::create([
                'item_id' => $firstReturnedItem->id,
                'user_id' => $user1->id,
                'message' => 'Em là chủ nhân chiếc thẻ, em đã xuất trình CCCD trùng khớp thông tin và nhận lại thẻ thành công.',
                'status' => 'approved',
                'admin_note' => 'Đã đối chiếu thông tin sinh viên và trao trả tại văn phòng.',
            ]);
        }

        // Tạo bình luận mẫu
        $sampleApprovedItem = Item::where('status', 'approved')->first();
        if ($sampleApprovedItem) {
            Comment::create([
                'item_id' => $sampleApprovedItem->id,
                'user_id' => $user2->id,
                'content' => 'Bạn thử ghé quầy lễ tân thư viện hỏi xem, hôm qua mình thấy có chú bảo vệ đi gom đồ bạn đọc để quên đấy!',
            ]);
            Comment::create([
                'item_id' => $sampleApprovedItem->id,
                'user_id' => $user3->id,
                'content' => 'Hy vọng bạn sớm tìm lại được đồ nhé, Thư viện trường mình bảo vệ trực rất cẩn thận.',
            ]);
        }
    }

    /**
     * Tự động sinh ảnh minh họa 800x500 bằng PHP GD
     */
    private function generateIllustrationImage(string $filename, string $title, string $categoryName, string $locationName, string $type): void
    {
        $targetFile = public_path('images/' . $filename);

        $width = 800;
        $height = 500;
        $im = imagecreatetruecolor($width, $height);

        // Bảng màu gradient sắc nét theo danh mục
        $palettes = [
            'dien-thoai' => ['r1' => 15, 'g1' => 43, 'b1' => 72, 'r2' => 30, 'g2' => 75, 'b2' => 115],
            'vi-bop' => ['r1' => 62, 'g1' => 39, 'b1' => 35, 'r2' => 109, 'g2' => 76, 'b2' => 65],
            'giay-to-the-sinh-vien' => ['r1' => 19, 'g1' => 78, 'b1' => 74, 'r2' => 20, 'g2' => 110, 'b2' => 100],
            'tai-nghe-thiet-bi-dien-tu' => ['r1' => 49, 'g1' => 46, 'b1' => 129, 'r2' => 67, 'g2' => 56, 'b2' => 202],
            'chia-khoa' => ['r1' => 136, 'g1' => 19, 'b1' => 55, 'r2' => 190, 'g2' => 24, 'b2' => 70],
            'sach-vo-tai-lieu' => ['r1' => 30, 'g1' => 58, 'b1' => 138, 'r2' => 37, 'g2' => 99, 'b2' => 235],
            'binh-nuoc-do-dung-ca-nhan' => ['r1' => 21, 'g1' => 94, 'b1' => 117, 'r2' => 14, 'g2' => 130, 'b2' => 160],
        ];

        $lowerCat = mb_strtolower($categoryName);
        $slug = 'dien-thoai';
        if (str_contains($lowerCat, 'ví')) $slug = 'vi-bop';
        elseif (str_contains($lowerCat, 'giấy') || str_contains($lowerCat, 'thẻ')) $slug = 'giay-to-the-sinh-vien';
        elseif (str_contains($lowerCat, 'tai nghe') || str_contains($lowerCat, 'điện tử')) $slug = 'tai-nghe-thiet-bi-dien-tu';
        elseif (str_contains($lowerCat, 'chìa')) $slug = 'chia-khoa';
        elseif (str_contains($lowerCat, 'sách') || str_contains($lowerCat, 'tài liệu')) $slug = 'sach-vo-tai-lieu';
        elseif (str_contains($lowerCat, 'bình') || str_contains($lowerCat, 'cá nhân')) $slug = 'binh-nuoc-do-dung-ca-nhan';

        $p = $palettes[$slug] ?? $palettes['dien-thoai'];

        // 1. Tô nền gradient dọc mượt mà
        for ($y = 0; $y < $height; $y++) {
            $factor = $y / $height;
            $r = (int)($p['r1'] + ($p['r2'] - $p['r1']) * $factor);
            $g = (int)($p['g1'] + ($p['g2'] - $p['g1']) * $factor);
            $b = (int)($p['b1'] + ($p['b2'] - $p['b1']) * $factor);
            $lineColor = imagecolorallocate($im, $r, $g, $b);
            imageline($im, 0, $y, $width, $y, $lineColor);
        }

        $white = imagecolorallocate($im, 255, 255, 255);
        $lightGray = imagecolorallocate($im, 226, 232, 240);
        $gold = imagecolorallocate($im, 255, 204, 0);
        $borderColor = imagecolorallocatealpha($im, 255, 255, 255, 95);
        $innerCardBg = imagecolorallocatealpha($im, 0, 0, 0, 105);

        // 2. Vẽ viền khung trang trí tinh tế
        imagerectangle($im, 28, 28, $width - 29, $height - 29, $borderColor);
        imagerectangle($im, 30, 30, $width - 31, $height - 31, $borderColor);

        // 3. Khung nội dung chính mờ
        imagefilledrectangle($im, 55, 120, $width - 55, 420, $innerCardBg);
        imagerectangle($im, 55, 120, $width - 55, 420, $borderColor);

        $fontBold = 'C:/Windows/Fonts/arialbd.ttf';
        $fontRegular = 'C:/Windows/Fonts/arial.ttf';
        $hasTtf = file_exists($fontBold) && function_exists('imagettftext');

        // 4. Nhãn phân loại
        if ($type === 'lost') {
            $badgeBg = imagecolorallocate($im, 220, 53, 69);
            $badgeText = "ĐỒ BỊ MẤT";
        } else {
            $badgeBg = imagecolorallocate($im, 25, 135, 84);
            $badgeText = "ĐỒ NHẶT ĐƯỢC";
        }
        imagefilledrectangle($im, 60, 55, 220, 95, $badgeBg);

        if ($hasTtf) {
            imagettftext($im, 13, 0, 75, 81, $white, $fontBold, $badgeText);
            imagettftext($im, 13, 0, 420, 80, $gold, $fontBold, 'CAMPUS LOST & FOUND - HUIT');

            // Tên đồ vật
            imagettftext($im, 23, 0, 85, 200, $white, $fontBold, $title);

            // Danh mục & Địa điểm
            imagettftext($im, 15, 0, 85, 270, $gold, $fontBold, 'Danh mục: ' . $categoryName);
            imagettftext($im, 15, 0, 85, 315, $lightGray, $fontRegular, 'Địa điểm: ' . $locationName);

            // Dòng nhận diện trường
            imagettftext($im, 12, 0, 85, 385, $lightGray, $fontRegular, 'Trường Đại học Công Thương TP. Hồ Chí Minh (HUIT)');
        } else {
            imagestring($im, 4, 75, 68, $badgeText, $white);
            imagestring($im, 4, 450, 70, 'CAMPUS LOST & FOUND - HUIT', $gold);
            imagestring($im, 5, 85, 190, $title, $white);
            imagestring($im, 4, 85, 260, 'Danh muc: ' . $categoryName, $gold);
            imagestring($im, 4, 85, 300, 'Dia diem: ' . $locationName, $lightGray);
        }

        imagepng($im, $targetFile);
        imagedestroy($im);
    }
}
