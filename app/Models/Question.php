<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['survey_id', 'text', 'option_type_id'];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
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


