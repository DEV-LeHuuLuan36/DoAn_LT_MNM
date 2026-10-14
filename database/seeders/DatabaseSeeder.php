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
                'category_id' => $cats['muc-khac']->id,
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
     * Vẽ hình chữ nhật bo góc bằng PHP GD
     */
    private function drawRoundedRect($im, int $x1, int $y1, int $x2, int $y2, int $radius, int $color): void
    {
        if ($radius <= 0) {
            imagefilledrectangle($im, $x1, $y1, $x2, $y2, $color);
            return;
        }
        $radius = min($radius, (int)(abs($x2 - $x1) / 2), (int)(abs($y2 - $y1) / 2));
        imagefilledrectangle($im, $x1 + $radius, $y1, $x2 - $radius, $y2, $color);
        imagefilledrectangle($im, $x1, $y1 + $radius, $x1 + $radius, $y2 - $radius, $color);
        imagefilledrectangle($im, $x2 - $radius, $y1 + $radius, $x2, $y2 - $radius, $color);

        $d = $radius * 2;
        imagefilledarc($im, $x1 + $radius, $y1 + $radius, $d, $d, 180, 270, $color, IMG_ARC_PIE);
        imagefilledarc($im, $x2 - $radius, $y1 + $radius, $d, $d, 270, 360, $color, IMG_ARC_PIE);
        imagefilledarc($im, $x2 - $radius, $y2 - $radius, $d, $d, 0, 90, $color, IMG_ARC_PIE);
        imagefilledarc($im, $x1 + $radius, $y2 - $radius, $d, $d, 90, 180, $color, IMG_ARC_PIE);
    }

    /**
     * Tự động sinh ảnh minh họa Flat Vector Illustration 800x500 bằng PHP GD
     * Tuyệt đối không vẽ badge "Đồ bị mất", không vẽ tên trường/địa điểm/danh mục chồng lên ảnh
     */
    private function generateIllustrationImage(string $filename, string $title, string $categoryName, string $locationName, string $type): void
    {
        $targetFile = public_path('images/' . $filename);

        $width = 800;
        $height = 500;
        $im = imagecreatetruecolor($width, $height);

        // Bảng màu pastel chuyển sắc dịu nhẹ theo từng nhóm đồ vật
        $palettes = [
            'dien-thoai' => ['r1' => 241, 'g1' => 245, 'b1' => 249, 'r2' => 226, 'g2' => 232, 'b2' => 240], // Slate pastel
            'giay-to-the-sinh-vien' => ['r1' => 240, 'g1' => 253, 'b1' => 250, 'r2' => 204, 'g2' => 251, 'b2' => 241], // Teal pastel
            'vi-bop' => ['r1' => 255, 'g1' => 251, 'b1' => 235, 'r2' => 254, 'g2' => 243, 'b2' => 199], // Amber pastel
            'tai-nghe-thiet-bi-dien-tu' => ['r1' => 250, 'g1' => 245, 'b1' => 255, 'r2' => 237, 'g2' => 233, 'b2' => 254], // Purple pastel
            'chia-khoa' => ['r1' => 255, 'g1' => 241, 'b1' => 242, 'r2' => 254, 'g2' => 226, 'b2' => 226], // Rose pastel
            'sach-vo-tai-lieu' => ['r1' => 240, 'g1' => 249, 'b1' => 255, 'r2' => 224, 'g2' => 242, 'b2' => 254], // Sky pastel
            'binh-nuoc-do-dung-ca-nhan' => ['r1' => 240, 'g1' => 253, 'b1' => 244, 'r2' => 220, 'g2' => 252, 'b2' => 231], // Mint pastel
        ];

        $lowerCat = mb_strtolower($categoryName);
        $slug = 'dien-thoai';
        if (str_contains($lowerCat, 'ví') || str_contains($lowerCat, 'bóp')) $slug = 'vi-bop';
        elseif (str_contains($lowerCat, 'giấy') || str_contains($lowerCat, 'thẻ') || str_contains($lowerCat, 'sinh viên')) $slug = 'giay-to-the-sinh-vien';
        elseif (str_contains($lowerCat, 'tai nghe') || str_contains($lowerCat, 'điện tử') || str_contains($lowerCat, 'sạc') || str_contains($lowerCat, 'pin')) $slug = 'tai-nghe-thiet-bi-dien-tu';
        elseif (str_contains($lowerCat, 'chìa')) $slug = 'chia-khoa';
        elseif (str_contains($lowerCat, 'sách') || str_contains($lowerCat, 'vở') || str_contains($lowerCat, 'tài liệu') || str_contains($lowerCat, 'giáo trình')) $slug = 'sach-vo-tai-lieu';
        elseif (str_contains($lowerCat, 'bình') || str_contains($lowerCat, 'cá nhân') || str_contains($lowerCat, 'nước') || str_contains($lowerCat, 'áo') || str_contains($lowerCat, 'khác')) $slug = 'binh-nuoc-do-dung-ca-nhan';

        $p = $palettes[$slug] ?? $palettes['dien-thoai'];

        // 1. Tô nền gradient dọc dịu nhẹ
        for ($y = 0; $y < $height; $y++) {
            $factor = $y / $height;
            $r = (int)($p['r1'] + ($p['r2'] - $p['r1']) * $factor);
            $g = (int)($p['g1'] + ($p['g2'] - $p['g1']) * $factor);
            $b = (int)($p['b1'] + ($p['b2'] - $p['b1']) * $factor);
            $lineColor = imagecolorallocate($im, $r, $g, $b);
            imageline($im, 0, $y, $width, $y, $lineColor);
        }

        // Bảng màu đồ họa
        $white = imagecolorallocate($im, 255, 255, 255);
        $darkText = imagecolorallocate($im, 30, 41, 59);
        $subText = imagecolorallocate($im, 100, 116, 139);
        $shadowColor = imagecolorallocatealpha($im, 0, 0, 0, 115);

        // Đổ bóng mềm dưới chân đồ vật
        imagefilledellipse($im, 400, 345, 240, 32, $shadowColor);

        // 2. Vẽ hình minh họa Flat Vector Illustration trung tâm theo danh mục
        switch ($slug) {
            case 'dien-thoai':
                // Thân máy Smartphone
                $phoneBody = imagecolorallocate($im, 30, 41, 59);
                $this->drawRoundedRect($im, 335, 75, 465, 335, 26, $phoneBody);

                // Màn hình hiển thị
                $phoneScreen = imagecolorallocate($im, 37, 99, 235);
                $this->drawRoundedRect($im, 345, 90, 455, 320, 18, $phoneScreen);

                // Điểm nhấn giao diện màn hình
                $screenGlow = imagecolorallocate($im, 96, 165, 250);
                $this->drawRoundedRect($im, 345, 180, 455, 320, 18, $screenGlow);

                // Cụm Dynamic Island / Loa thoại
                $notch = imagecolorallocate($im, 15, 23, 42);
                $this->drawRoundedRect($im, 385, 98, 415, 112, 7, $notch);

                // Thanh điều hướng Home Bar
                $homeBar = imagecolorallocatealpha($im, 255, 255, 255, 30);
                $this->drawRoundedRect($im, 380, 310, 420, 314, 2, $homeBar);
                break;

            case 'giay-to-the-sinh-vien':
                // Thẻ sinh viên viền xám sáng
                $cardBorder = imagecolorallocate($im, 203, 213, 225);
                $this->drawRoundedRect($im, 278, 98, 522, 312, 18, $cardBorder);
                $this->drawRoundedRect($im, 280, 100, 520, 310, 16, $white);

                // Băng tiêu đề xanh HUIT ở phía trên
                $huitNavy = imagecolorallocate($im, 0, 51, 102);
                $this->drawRoundedRect($im, 280, 100, 520, 148, 16, $huitNavy);
                imagefilledrectangle($im, 280, 125, 520, 148, $huitNavy);

                // Vạch tượng trưng tên trường trên thẻ
                $headerGold = imagecolorallocate($im, 255, 204, 0);
                $this->drawRoundedRect($im, 300, 118, 440, 128, 4, $white);
                $this->drawRoundedRect($im, 450, 118, 500, 128, 4, $headerGold);

                // Khung ảnh chân dung 3x4
                $photoBg = imagecolorallocate($im, 226, 232, 240);
                $this->drawRoundedRect($im, 305, 165, 375, 260, 8, $photoBg);
                $avatarColor = imagecolorallocate($im, 148, 163, 184);
                imagefilledellipse($im, 340, 195, 32, 32, $avatarColor);
                $this->drawRoundedRect($im, 320, 220, 360, 260, 10, $avatarColor);

                // Các vạch thông tin sinh viên (Họ tên, MSSV, Khoa, Lớp)
                $lineColor1 = imagecolorallocate($im, 51, 65, 85);
                $lineColor2 = imagecolorallocate($im, 100, 116, 139);
                $lineColor3 = imagecolorallocate($im, 148, 163, 184);
                $lineColor4 = imagecolorallocate($im, 203, 213, 225);
                $this->drawRoundedRect($im, 395, 172, 495, 182, 4, $lineColor1);
                $this->drawRoundedRect($im, 395, 198, 475, 206, 3, $lineColor2);
                $this->drawRoundedRect($im, 395, 220, 500, 228, 3, $lineColor3);
                $this->drawRoundedRect($im, 395, 242, 460, 250, 3, $lineColor4);

                // Con chip thông minh vàng
                $chipGold = imagecolorallocate($im, 234, 179, 8);
                $this->drawRoundedRect($im, 395, 270, 440, 295, 5, $chipGold);
                break;

            case 'vi-bop':
                // Thân ví da gấp
                $walletBrown = imagecolorallocate($im, 120, 53, 15);
                $walletDark = imagecolorallocate($im, 69, 26, 3);
                $walletLight = imagecolorallocate($im, 180, 83, 9);
                $this->drawRoundedRect($im, 280, 110, 520, 310, 22, $walletBrown);

                // Các lớp ngăn đựng thẻ bên trong ví
                $this->drawRoundedRect($im, 295, 125, 505, 200, 14, $walletLight);
                $this->drawRoundedRect($im, 295, 155, 505, 295, 14, $walletDark);

                // Quai gài và nút khóa kim loại màu vàng
                $this->drawRoundedRect($im, 460, 185, 535, 240, 14, $walletDark);
                $claspGold = imagecolorallocate($im, 250, 204, 21);
                imagefilledellipse($im, 505, 212, 22, 22, $claspGold);
                $claspInner = imagecolorallocate($im, 202, 138, 4);
                imagefilledellipse($im, 505, 212, 12, 12, $claspInner);
                break;

            case 'tai-nghe-thiet-bi-dien-tu':
                // Hộp sạc tai nghe bo tròn
                $caseShadow = imagecolorallocate($im, 203, 213, 225);
                $this->drawRoundedRect($im, 328, 98, 472, 312, 38, $caseShadow);
                $this->drawRoundedRect($im, 330, 100, 470, 310, 36, $white);

                // Đường rãnh mở nắp
                $groove = imagecolorallocate($im, 226, 232, 240);
                imagefilledrectangle($im, 330, 168, 470, 172, $groove);

                // Rãnh ngón tay mở hộp
                $this->drawRoundedRect($im, 385, 165, 415, 175, 4, $caseShadow);

                // Đèn LED báo nguồn màu xanh lá
                $greenLed = imagecolorallocate($im, 34, 197, 94);
                imagefilledellipse($im, 400, 205, 10, 10, $greenLed);
                break;

            case 'chia-khoa':
                // Vòng xâu chìa khóa kim loại
                $silver = imagecolorallocate($im, 148, 163, 184);
                imagefilledellipse($im, 360, 150, 96, 96, $silver);
                $innerRingColor = imagecolorallocate($im, (int)$p['r1'], (int)$p['g1'], (int)$p['b1']);
                imagefilledellipse($im, 360, 150, 72, 72, $innerRingColor);

                // Remote Smartkey xe máy màu đen
                $fobBody = imagecolorallocate($im, 30, 41, 59);
                $this->drawRoundedRect($im, 405, 150, 475, 290, 20, $fobBody);
                $buttonSilver = imagecolorallocate($im, 203, 213, 225);
                $this->drawRoundedRect($im, 425, 180, 455, 205, 6, $buttonSilver);
                $this->drawRoundedRect($im, 425, 220, 455, 245, 6, $buttonSilver);

                // Chìa khóa đồng truyền thống
                $goldKey = imagecolorallocate($im, 234, 179, 8);
                $goldDark = imagecolorallocate($im, 161, 98, 7);
                imagefilledellipse($im, 360, 195, 52, 52, $goldKey);
                imagefilledellipse($im, 360, 195, 20, 20, $innerRingColor);
                imagefilledrectangle($im, 353, 215, 367, 320, $goldKey);
                imagefilledrectangle($im, 367, 260, 377, 272, $goldKey);
                imagefilledrectangle($im, 367, 285, 379, 297, $goldKey);
                imagefilledrectangle($im, 367, 308, 375, 318, $goldDark);
                break;

            case 'sach-vo-tai-lieu':
                // Các lớp giấy của cuốn sách
                $pagesBg = imagecolorallocate($im, 241, 245, 249);
                $pagesLine = imagecolorallocate($im, 203, 213, 225);
                $this->drawRoundedRect($im, 310, 95, 495, 315, 16, $pagesLine);
                imagefilledrectangle($im, 470, 105, 495, 310, $pagesBg);
                imagefilledrectangle($im, 325, 300, 490, 312, $pagesBg);

                // Bìa sách màu xanh dương đậm
                $coverBlue = imagecolorallocate($im, 29, 78, 216);
                $spineDark = imagecolorallocate($im, 30, 58, 138);
                $this->drawRoundedRect($im, 305, 90, 480, 305, 14, $coverBlue);
                $this->drawRoundedRect($im, 305, 90, 335, 305, 14, $spineDark);
                imagefilledrectangle($im, 320, 90, 335, 305, $spineDark);

                // Ô nhãn trắng ghi tên sách
                $this->drawRoundedRect($im, 355, 140, 460, 190, 8, $white);
                $titleBar = imagecolorallocate($im, 30, 41, 59);
                $this->drawRoundedRect($im, 370, 155, 445, 163, 3, $titleBar);
                $this->drawRoundedRect($im, 370, 170, 430, 176, 2, $subText);

                // Dải ruy băng đánh dấu trang màu đỏ
                $ribbonRed = imagecolorallocate($im, 239, 68, 68);
                imagefilledrectangle($im, 395, 295, 410, 335, $ribbonRed);
                break;

            case 'binh-nuoc-do-dung-ca-nhan':
            default:
                // Thân bình nước giữ nhiệt / đồ cá nhân
                $bottleBlue = imagecolorallocate($im, 14, 165, 233);
                $bottleGrip = imagecolorallocate($im, 2, 132, 199);
                $capDark = imagecolorallocate($im, 51, 65, 85);
                $capSilver = imagecolorallocate($im, 203, 213, 225);

                // Quai xách nắp bình
                $this->drawRoundedRect($im, 385, 70, 415, 105, 8, $capDark);

                // Nắp bình giữ nhiệt
                $this->drawRoundedRect($im, 365, 95, 435, 135, 10, $capDark);
                imagefilledrectangle($im, 360, 130, 440, 140, $capSilver);

                // Thân bình dáng trụ
                $this->drawRoundedRect($im, 350, 138, 450, 325, 22, $bottleBlue);

                // Đai bọc silicon chống trượt
                $this->drawRoundedRect($im, 350, 205, 450, 260, 6, $bottleGrip);
                $whiteAlpha = imagecolorallocatealpha($im, 255, 255, 255, 90);
                $this->drawRoundedRect($im, 365, 220, 435, 224, 2, $whiteAlpha);
                $this->drawRoundedRect($im, 365, 235, 435, 239, 2, $whiteAlpha);
                break;
        }

        // 3. Tên món đồ duy nhất nhỏ gọn, tinh tế ở dưới hình vẽ
        $fontBold = 'C:/Windows/Fonts/arialbd.ttf';
        if (file_exists($fontBold) && function_exists('imagettftext')) {
            $fontSize = 18;
            if (mb_strlen($title) > 35) {
                $fontSize = 15;
            }
            $bbox = imagettfbbox($fontSize, 0, $fontBold, $title);
            $textWidth = abs($bbox[2] - $bbox[0]);
            $x = (int)(($width - $textWidth) / 2);
            imagettftext($im, $fontSize, 0, $x, 410, $darkText, $fontBold, $title);
        } else {
            $x = (int)(($width - strlen($title) * 9) / 2);
            imagestring($im, 5, max(20, $x), 400, $title, $darkText);
        }

        imagepng($im, $targetFile);
        imagedestroy($im);
    }
}
