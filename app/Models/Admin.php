<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    protected $table = 'admin'; // Bảng liên kết
    protected $primaryKey = 'admin_id'; // Khóa chính

    public $timestamps = true;

    protected $fillable = [
        'admin_email',
        'admin_password',
        'admin_name',
        'admin_phone',
    ];

    protected $hidden = [
        'admin_password',

    ];

    // Tùy chỉnh tên trường mật khẩu
    public function getAuthPassword()
    {
        return $this->admin_password;
    }
}
