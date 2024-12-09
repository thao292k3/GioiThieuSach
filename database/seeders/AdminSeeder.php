<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { {
            // Tạo admin bằng factory
            Admin::factory()->create([
                'admin_name' => 'SuperAdmin',
                'admin_email' => 'superadmin@example.com',
                'admin_password' => bcrypt('securepassword'), // Mã hóa mật khẩu
                'admin_phone' => '1234567890',
            ]);

            // Hoặc tạo nhiều admin mẫu
            Admin::factory()->count(10)->create();
        }
    }
}
