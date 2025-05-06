<?php

namespace App\Models;

use App\Mail\OrderMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['email', 'name', 'phone', 'address', 'user_id', 'status', 'token'];


    // public function user()
    // {
    //     return $this->hasOne(User::class, 'user_id', 'user_id'); //quan hệ 1-1 tham chiếu từ bảng user sang oder

    // }

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id', 'user_id');
    // }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function details()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id'); //quan hệ 1-n tham chiếu từ bảng  sang oderdetial

    }

    public function customer()
    {
        return $this->hasONe(User::class, 'user_id', 'id'); //quan hệ 1-1 tham chiếu từ bảng user sang oder
    }
}
