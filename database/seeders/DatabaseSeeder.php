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

        // 14 bài đăng approved (đáp ứng TC10 phân trang > 9 bài/trang)
        $approvedItems = [
            [
                'user_id' => $user1->id,
                'category_id' => $cats['dien-thoai']->id,
                'location_id' => $locs['Thư viện']->id,
                'type' => 'lost',
                'title' => 'Để quên điện thoại iPhone 11 màu đen tại bàn đọc tầng 2',
                'description' => 'Mình có để quên một chiếc iPhone 11 màu đen có ốp lưng trong suốt viền xanh tại bàn đọc sách lầu 2 Thư viện chiều ngày hôm qua. Màn hình khóa có hình chú mèo.',
                'event_date' => Carbon::now()->subDays(1)->toDateString(),
                'contact_info' => 'SĐT: 0912345678 (Luân)',
                'status' => 'approved',
            ],
            [
                'user_id' => $user2->id,
                'category_id' => $cats['giay-to-the-sinh-vien']->id,
                'location_id' => $locs['Căn tin']->id,
                'type' => 'found',
                'title' => 'Nhặt được Thẻ sinh viên HUIT mang tên Trần Minh Tâm',
                'description' => 'Trưa nay lúc ăn cơm tại Căn tin bàn số 14, mình có nhặt được 01 thẻ sinh viên khoa CNTT tên Trần Minh Tâm, MSSV: 2001229988. Bạn nào là chủ nhân liên hệ mình để nhận lại nhé.',
                'event_date' => Carbon::now()->toDateString(),
                'contact_info' => 'Liên hệ Duy - 0923456789 hoặc qua zalo',
                'status' => 'approved',
            ],
            [
                'user_id' => $user3->id,
                'category_id' => $cats['vi-bop']->id,
                'location_id' => $locs['Nhà xe']->id,
                'type' => 'lost',
                'title' => 'Rơi ví da nam màu nâu tại khu vực gửi xe máy Tòa B',
                'description' => 'Sáng nay khoảng 7h15 lúc lấy xe tại hầm xe Tòa B mình làm rơi ví da màu nâu hiệu Pedro. Bên trong có GPLX, CCCD và một ít tiền mặt. Rất mong bạn nào nhặt được cho mình chuộc lại.',
                'event_date' => Carbon::now()->subDays(2)->toDateString(),
                'contact_info' => 'Diệu - 0934567890',
                'status' => 'approved',
            ],
            [
                'user_id' => $user4->id,
                'category_id' => $cats['tai-nghe-thiet-bi-dien-tu']->id,
                'location_id' => $locs['Tòa B']->id,
                'type' => 'found',
                'title' => 'Nhặt được hộp sạc tai nghe AirPods Pro màu trắng phòng B302',
                'description' => 'Sau tiết học Kỹ thuật lập trình tại phòng máy B302, mình thấy hộp sạc tai nghe AirPods Pro bỏ quên trên bàn giáo viên. Hiện mình đang giữ, ai mất liên hệ đối chiếu seri.',
                'event_date' => Carbon::now()->subDays(1)->toDateString(),
                'contact_info' => 'Nguyên - 0945678901',
                'status' => 'approved',
            ],
            [
                'user_id' => $user1->id,
                'category_id' => $cats['chia-khoa']->id,
                'location_id' => $locs['Sân thể thao']->id,
                'type' => 'found',
                'title' => 'Chùm chìa khóa xe Honda kèm móc khóa gấu bông màu đỏ',
                'description' => 'Nhặt được ở hàng ghế khán đài sân bóng rổ trường vào chiều thứ Ba. Chùm gồm 2 chìa khóa xe máy Smartkey và 1 chìa khóa phòng trọ.',
                'event_date' => Carbon::now()->subDays(3)->toDateString(),
                'contact_info' => '0912345678',
                'status' => 'approved',
            ],
            [
                'user_id' => $user2->id,
                'category_id' => $cats['sach-vo-tai-lieu']->id,
                'location_id' => $locs['Tòa A']->id,
                'type' => 'lost',
                'title' => 'Mất tập giáo trình Cấu trúc dữ liệu và giải thuật tại phòng A205',
                'description' => 'Chiều qua mình học môn CTDL&GT tại phòng A205 và có bỏ quên cuốn giáo trình bìa xanh lá, bên trong có kẹp nhiều bài tập và ghi chú quan trọng.',
                'event_date' => Carbon::now()->subDays(2)->toDateString(),
                'contact_info' => 'Duy - duy.nk@huit.edu.vn',
                'status' => 'approved',
            ],
            [
                'user_id' => $user3->id,
                'category_id' => $cats['binh-nuoc-do-dung-ca-nhan']->id,
                'location_id' => $locs['Thư viện']->id,
                'type' => 'found',
                'title' => 'Bình giữ nhiệt Lock&Lock màu xanh ngọc tại phòng tự học',
                'description' => 'Bình giữ nhiệt dung tích 500ml màu xanh ngọc bích, có dán sticker anime One Piece, để quên tại góc tự học tầng 1 Thư viện.',
                'event_date' => Carbon::now()->subDays(1)->toDateString(),
                'contact_info' => 'Diệu - 0934567890',
                'status' => 'approved',
            ],
            [
                'user_id' => $user4->id,
                'category_id' => $cats['dien-thoai']->id,
                'location_id' => $locs['Căn tin']->id,
                'type' => 'found',
                'title' => 'Nhặt được điện thoại Samsung Galaxy A54 màu tím nhạt',
                'description' => 'Trưa nay nhặt được máy Samsung màu tím nhạt để trên bàn ăn căn tin. Máy đã hết pin tắt nguồn, đã sạc lên được một chút. Ai là chủ nhân vui lòng đem giấy tờ xác minh.',
                'event_date' => Carbon::now()->toDateString(),
                'contact_info' => 'Nguyên - 0945678901',
                'status' => 'approved',
            ],
            [
                'user_id' => $user1->id,
                'category_id' => $cats['giay-to-the-sinh-vien']->id,
                'location_id' => $locs['Tòa C']->id,
                'type' => 'lost',
                'title' => 'Rơi ví kẹp thẻ chứa Căn cước công dân và thẻ ATM Vietcombank',
                'description' => 'Đoạn đường từ sảnh Tòa C sang văn phòng khoa mình làm rơi bóp kẹp thẻ màu xám. Bên trong có thẻ CCCD mang tên Lê Hữu Luân.',
                'event_date' => Carbon::now()->subDays(4)->toDateString(),
                'contact_info' => '0912345678',
                'status' => 'approved',
            ],
            [
                'user_id' => $user2->id,
                'category_id' => $cats['tai-nghe-thiet-bi-dien-tu']->id,
                'location_id' => $locs['Thư viện']->id,
                'type' => 'lost',
                'title' => 'Tìm chuột không dây Logitech MX Anywhere 3 màu xám tro',
                'description' => 'Hôm qua mình ngồi làm đồ án tại phòng máy tính thư viện lầu 3 và để quên chuột không dây. Chuột có vết xước nhẹ ở nút click trái.',
                'event_date' => Carbon::now()->subDays(2)->toDateString(),
                'contact_info' => '2001230124@huit.edu.vn',
                'status' => 'approved',
            ],
            [
                'user_id' => $user3->id,
                'category_id' => $cats['binh-nuoc-do-dung-ca-nhan']->id,
                'location_id' => $locs['Nhà xe']->id,
                'type' => 'found',
                'title' => 'Nhặt được nón bảo hiểm Royal màu xanh rêu còn mới',
                'description' => 'Bác bảo vệ gửi mình nón bảo hiểm treo trên gương xe máy Wave đỏ ở hàng B nhà xe suốt 2 ngày chưa thấy ai lấy. Bạn nào quên thì liên hệ nhận lại.',
                'event_date' => Carbon::now()->subDays(2)->toDateString(),
                'contact_info' => '0934567890',
                'status' => 'approved',
            ],
            [
                'user_id' => $user4->id,
                'category_id' => $cats['sach-vo-tai-lieu']->id,
                'location_id' => $locs['Tòa B']->id,
                'type' => 'found',
                'title' => 'Tài liệu ôn thi Lập trình mã nguồn mở của Nhóm 4',
                'description' => 'Thấy một bìa hồ sơ màu vàng chứa bản thảo tài liệu báo cáo đồ án và một cuốn sổ tay nhỏ để quên tại ghế đá trước Tòa B.',
                'event_date' => Carbon::now()->subDays(1)->toDateString(),
                'contact_info' => 'Phòng thực hành B301 hoặc gọi 0945678901',
                'status' => 'approved',
            ],
            [
                'user_id' => $user1->id,
                'category_id' => $cats['chia-khoa']->id,
                'location_id' => $locs['Tòa A']->id,
                'type' => 'lost',
                'title' => 'Đánh rơi chìa khóa xe Yamaha Exciter kèm thẻ từ chung cư',
                'description' => 'Sáng nay di chuyển từ cầu thang bộ tầng 3 Tòa A xuống sảnh trệt, mình đánh rơi móc khóa xe máy và thẻ từ thang máy màu xanh dương.',
                'event_date' => Carbon::now()->toDateString(),
                'contact_info' => 'Luân - 0912345678',
                'status' => 'approved',
            ],
            [
                'user_id' => $user2->id,
                'category_id' => $cats['tai-nghe-thiet-bi-dien-tu']->id,
                'location_id' => $locs['Căn tin']->id,
                'type' => 'found',
                'title' => 'Nhặt được sạc dự phòng Baseus 20000mAh màu đen',
                'description' => 'Cục pin sạc dự phòng công suất 65W màu đen nhám để quên cạnh ổ cắm điện căn tin trường trưa hôm nay.',
                'event_date' => Carbon::now()->toDateString(),
                'contact_info' => 'Liên hệ Duy - SĐT: 0923456789',
                'status' => 'approved',
            ],
        ];

        foreach ($approvedItems as $data) {
            Item::create($data);
        }

        // 3 bài pending
        $pendingItems = [
            [
                'user_id' => $user3->id,
                'category_id' => $cats['dien-thoai']->id,
                'location_id' => $locs['Sân thể thao']->id,
                'type' => 'lost',
                'title' => 'Đánh rơi điện thoại Xiaomi Redmi Note 12 khi chơi bóng chuyền',
                'description' => 'Chiều nay lúc 16h mình tham gia đá cầu tại sân thể thao và bị rớt điện thoại Xiaomi màu xanh dương. Mặt lưng có dán tem bảo hành.',
                'event_date' => Carbon::now()->toDateString(),
                'contact_info' => 'Diệu - 0934567890',
                'status' => 'pending',
            ],
            [
                'user_id' => $user4->id,
                'category_id' => $cats['vi-bop']->id,
                'location_id' => $locs['Tòa C']->id,
                'type' => 'found',
                'title' => 'Nhặt được ví nữ mini màu hồng phấn tại hành lang tầng 3',
                'description' => 'Hành lang tầng 3 Tòa C, nhặt được chiếc ví nữ nhỏ màu hồng nhạt. Bên trong có thẻ ngân hàng Agribank và một số giấy tờ.',
                'event_date' => Carbon::now()->toDateString(),
                'contact_info' => 'Nguyên - 0945678901',
                'status' => 'pending',
            ],
            [
                'user_id' => $user1->id,
                'category_id' => $cats['binh-nuoc-do-dung-ca-nhan']->id,
                'location_id' => $locs['Phòng Công tác sinh viên (CTSV)']->id,
                'type' => 'lost',
                'title' => 'Để quên áo khoác dù màu đen có logo HUIT trước phòng CTSV',
                'description' => 'Hôm qua đến phòng CTSV nộp hồ sơ xin giấy xác nhận sinh viên mình có cởi áo khoác vắt trên hàng ghế chờ và quên mang về.',
                'event_date' => Carbon::now()->subDays(1)->toDateString(),
                'contact_info' => '0912345678',
                'status' => 'pending',
            ],
        ];

        foreach ($pendingItems as $data) {
            Item::create($data);
        }

        // 2 bài returned
        $returnedItems = [
            [
                'user_id' => $user2->id,
                'category_id' => $cats['giay-to-the-sinh-vien']->id,
                'location_id' => $locs['Thư viện']->id,
                'type' => 'found',
                'title' => 'ĐÃ TRẢ: Thẻ sinh viên HUIT mang tên Lê Văn Long',
                'description' => 'Đã xác minh và hoàn trả trực tiếp cho bạn Long vào sáng hôm nay tại sảnh chính Thư viện.',
                'event_date' => Carbon::now()->subDays(5)->toDateString(),
                'contact_info' => 'Đã bàn giao hoàn tất',
                'status' => 'returned',
            ],
            [
                'user_id' => $user3->id,
                'category_id' => $cats['chia-khoa']->id,
                'location_id' => $locs['Nhà xe']->id,
                'type' => 'lost',
                'title' => 'ĐÃ TÌM THẤY: Chìa khóa xe máy Sirius màu đen',
                'description' => 'Mình đã nhận lại chùm chìa khóa từ phòng bảo vệ nhà xe Tòa A. Xin chân thành cảm ơn các bạn và các chú bảo vệ!',
                'event_date' => Carbon::now()->subDays(6)->toDateString(),
                'contact_info' => 'Đã giải quyết',
                'status' => 'returned',
            ],
        ];

        foreach ($returnedItems as $data) {
            Item::create($data);
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
}
