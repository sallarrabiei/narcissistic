<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'feature_image', 'content', 'reading_time', 'enable_comment', 'meta_description', 'slug'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
