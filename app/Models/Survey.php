<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'short_description', 'description', 'slug', 'price', 'analysis_text', 'analysis_conditions', 'meta_description'];
    protected $casts = [
        'analysis_conditions' => 'array',
    ];


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
    // public function tags()
    // {
    //     return $this->hasMany(Tag::class);
    // }
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'survey_tag');
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

}

