<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // public function questions()
    // {
    //     return $this->belongsToMany(Question::class);
    // }

    public function surveys()
    {
        return $this->belongsToMany(Survey::class, 'survey_tag');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_tag');
    }

}
