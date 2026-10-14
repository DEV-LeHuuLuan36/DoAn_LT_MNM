<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin account
        User::updateOrCreate(
            ['email' => 'admin@huit.edu.vn'],
            [
                'name' => 'Quản trị viên HUIT',
                'password' => Hash::make('123456'),
                'phone' => '0901234567',
                'student_code' => 'ADMIN01',
                'role' => 'admin',
                'is_locked' => false,
            ]
        );

        // Nhóm 4 thành viên
        $students = [
            [
                'name' => 'Lê Hữu Luân',
                'email' => '2001230482@huit.edu.vn',
                'student_code' => '2001230482',
                'phone' => '0912345678',
            ],
            [
                'name' => 'Nguyễn Khánh Duy',
                'email' => '2001230124@huit.edu.vn',
                'student_code' => '2001230124',
                'phone' => '0923456789',
            ],
            [
                'name' => 'Trương Quang Diệu',
                'email' => '2001230097@huit.edu.vn',
                'student_code' => '2001230097',
                'phone' => '0934567890',
            ],
            [
                'name' => 'Phạm Hải Nguyên',
                'email' => '2001230581@huit.edu.vn',
                'student_code' => '2001230581',
                'phone' => '0945678901',
            ],
        ];

        foreach ($students as $stu) {
            User::updateOrCreate(
                ['email' => $stu['email']],
                [
                    'name' => $stu['name'],
                    'student_code' => $stu['student_code'],
                    'phone' => $stu['phone'],
                    'password' => Hash::make('123456'),
                    'role' => 'user',
                    'is_locked' => false,
                ]
            );
        }
    }
}
