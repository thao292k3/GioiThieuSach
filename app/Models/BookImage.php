<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookImage extends Model
{
    use HasFactory;
    protected $table = 'book_images';

    protected $fillable = ['book_id', 'path'];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'book_id');
    }
}
