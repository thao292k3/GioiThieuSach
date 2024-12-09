<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'contacts'; // Tên bảng
    protected $primaryKey = 'contact_id'; // Khóa chính

    protected $fillable = ['name', 'email', 'message', 'status', 'created_at', 'updated_at'];
}
