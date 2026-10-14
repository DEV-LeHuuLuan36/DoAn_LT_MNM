<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Điện thoại',
                'slug' => 'dien-thoai',
                'description' => 'Các loại điện thoại thông minh, điện thoại bàn phím cơ bản.',
            ],
            [
                'name' => 'Ví / Bóp',
                'slug' => 'vi-bop',
                'description' => 'Ví tiền, bóp đựng giấy tờ, ví cầm tay các loại.',
            ],
            [
                'name' => 'Giấy tờ / Thẻ sinh viên',
                'slug' => 'giay-to-the-sinh-vien',
                'description' => 'Thẻ sinh viên HUIT, CCCD, GPLX, thẻ ngân hàng và giấy tờ tùy thân.',
            ],
            [
                'name' => 'Tai nghe / Thiết bị điện tử',
                'slug' => 'tai-nghe-thiet-bi-dien-tu',
                'description' => 'Tai nghe bluetooth, sạc dự phòng, chuột máy tính, laptop, máy tính cầm tay.',
            ],
            [
                'name' => 'Chìa khóa',
                'slug' => 'chia-khoa',
                'description' => 'Chìa khóa xe máy, chìa khóa phòng trọ, chùm chìa khóa kèm móc khóa.',
            ],
            [
                'name' => 'Sách vở / Tài liệu',
                'slug' => 'sach-vo-tai-lieu',
                'description' => 'Giáo trình, tập vở ghi chép bài học, tài liệu ôn thi.',
            ],
            [
                'name' => 'Bình nước / Đồ dùng cá nhân',
                'slug' => 'binh-nuoc-do-dung-ca-nhan',
                'description' => 'Bình giữ nhiệt, áo khoác, nón bảo hiểm, dù che mưa, kính mắt.',
            ],
            [
                'name' => 'Mục khác',
                'slug' => 'muc-khac',
                'description' => 'Các loại đồ dùng, vật dụng cá nhân khác chưa nằm trong các danh mục trên.',
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => $cat['slug']],
                [
                    'name' => $cat['name'],
                    'description' => $cat['description'],
                ]
            );
        }
    }
}
