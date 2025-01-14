<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = ['order_id', 'book_id', 'price', 'quantity'];

    // public function book()
    // {
    //     return $this->hasOne(Book::class, 'book_id', 'book_id'); //quan hệ 1-1 tham chiếu từ bảng detail sang bảng bookbook

    // }
    public function book()

    {
        return $this->belongsTo(Book::class, 'book_id', 'book_id');
    }
}
