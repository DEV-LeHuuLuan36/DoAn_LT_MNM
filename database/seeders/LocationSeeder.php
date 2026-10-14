<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Thư viện',
                'description' => 'Khuôn viên Thư viện trường HUIT, các phòng đọc và khu tự học.',
            ],
            [
                'name' => 'Căn tin',
                'description' => 'Khu dịch vụ ăn uống sinh viên và giảng viên.',
            ],
            [
                'name' => 'Nhà xe',
                'description' => 'Bãi giữ xe máy và xe đạp sinh viên trong khuôn viên trường.',
            ],
            [
                'name' => 'Tòa A',
                'description' => 'Khu giảng đường và các phòng học lý thuyết Tòa A.',
            ],
            [
                'name' => 'Tòa B',
                'description' => 'Khu phòng học thực hành tin học và thí nghiệm Tòa B.',
            ],
            [
                'name' => 'Tòa C',
                'description' => 'Khu văn phòng khoa và các phòng chức năng Tòa C.',
            ],
            [
                'name' => 'Sân thể thao',
                'description' => 'Khu tập luyện thể dục thể thao, sân bóng rổ, cầu lông.',
            ],
            [
                'name' => 'Phòng Công tác sinh viên (CTSV)',
                'description' => 'Văn phòng hỗ trợ sinh viên và tiếp nhận đồ thất lạc chính thức.',
            ],
        ];

        foreach ($locations as $loc) {
            Location::updateOrCreate(
                ['name' => $loc['name']],
                [
                    'description' => $loc['description'],
                ]
            );
        }
    }
}
