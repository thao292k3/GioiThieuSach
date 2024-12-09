<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $table = 'books';
    protected $primaryKey = 'book_id';
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'published_date',
        'isbn',
        'price',
        'sale_price',
        'description',
        'status',
        'category_id',
        'cover_image',
        'pdf_file',
        'stock',
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
}
