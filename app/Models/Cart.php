<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'book_id',
        'price',
        'quantity'
    ];

    public function prod()
    {
        return $this->hasOne(Book::class, 'book_id', 'book_id');
    }
}
