<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users'; // Bảng `users`
    protected $primaryKey = 'user_id'; // Khóa chính là `user_id`

    // Các cột có thể được gán giá trị hàng loạt
    protected $fillable = [
        'name',
        'phone',
        'address',
        'email',
        'password',
        'role',
    ];

    // Ẩn các cột không cần hiển thị
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Định nghĩa kiểu dữ liệu cho các cột
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function favorites()
    {
        // return $this->hasMany(Favorite::class, 'favorites', 'user_id', 'book_id');
        return $this->hasMany(Favorite::class, 'user_id', 'user_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'user_id', 'user_id');
    }

}