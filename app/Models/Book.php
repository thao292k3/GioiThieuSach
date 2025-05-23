<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Book extends Model
{
    use HasFactory;
    public $appenends = ['favorited'];
    protected $table = 'books';
    protected $primaryKey = 'book_id';
    public $incrementing = true; // Nếu khóa chính là số tự tăng
    protected $keyType = 'int'; // Kiểu dữ liệu của khóa chính
    protected $fillable = [
        'title',
        'slug',
        'author',
        'publisher',
        'published_date',
        'isbn',
        'price',
        'description',
        'cover_image',
        'pdf_file',
        'status',
        'category_id',
        'stock',
        'sale_price',
    ];
    public function cat()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }


    public function cover_images()
    {
        return $this->hasMany(BookImage::class, 'book_id', 'book_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'book_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'book_id', 'book_id');
    }
    // app/Models/Book.php
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'book_id', 'user_id');
    }

    public function getFavoritedAttribute()
    {
        $favorited = Favorite::where(['book_id' => $this->book_id, 'user_id' => Auth::user()->user_id])->first();
        return $favorited ? true : false;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}
