<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'admin_name' => $this->faker->name, // Tên ngẫu nhiên
            'admin_email' => $this->faker->unique()->safeEmail, // Email ngẫu nhiên
            'admin_password' => Hash::make('defaultpassword'), // Mã hóa mật khẩu an toàn
            'admin_phone' => $this->faker->phoneNumber, // Số điện thoại ngẫu nhiên
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
