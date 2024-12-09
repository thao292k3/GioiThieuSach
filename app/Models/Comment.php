<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'book_id', 'comment', 'status'];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id'); //lấy tham chiếu từ bảng users với comments
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
