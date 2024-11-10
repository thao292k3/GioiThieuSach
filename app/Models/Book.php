<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'published_date',
        'isbn',
        'price',
        'description',
        'status',
        'category_id',
        'cover_image'
    ];
    public function cat()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
