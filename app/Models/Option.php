<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'option_type_id', 'label', 'value'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function optionType()
    {
        return $this->belongsTo(OptionType::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}

