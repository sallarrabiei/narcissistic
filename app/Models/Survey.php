<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'short_description', 'description', 'slug', 'price'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // Automatically generate a slug from the title if not provided
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($survey) {
            if (empty($survey->slug)) {
                $survey->slug = Str::slug($survey->title);
            }
        });
    }
}

