<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ebook extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'category_id',
        'title',
        'author',
        'year',
        'cover_image_path',
        'ebook_file_path',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
