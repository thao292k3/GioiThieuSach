<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'status', 'image'];
    protected $primaryKey = 'category_id';

    //1-n
    public function books()
    {
        return $this->hasMany(Book::class, 'category_id', 'category_id')->orderBy('created_at', 'DESC');
    }
}
