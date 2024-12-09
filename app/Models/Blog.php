<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blogs';
    public $timestamps = true;

    protected $fillable = [
        'title',
        'content',
        'image_path',
        'user_id',
        'date',
        'likes',
        'comment_count',
        'status',
        'category_id',
        'likes_count'
    ];

    protected $primaryKey = 'blog_id';

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
