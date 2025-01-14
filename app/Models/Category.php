<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    // App\Models\Category.php
    protected $fillable = ['name', 'status', 'description', 'parent_id'];

    protected $primaryKey = 'category_id';

    //1-n
    public function books()
    {
        return $this->hasMany(Book::class, 'category_id', 'category_id')->orderBy('created_at', 'DESC');
    }
}
