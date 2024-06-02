<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreRange extends Model
{
    use HasFactory;

    protected $fillable = ['survey_id', 'min_score', 'max_score', 'description'];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}
