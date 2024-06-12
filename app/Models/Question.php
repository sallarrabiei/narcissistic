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

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'question_tag');
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function optionType()
    {
        return $this->belongsTo(OptionType::class);
    }

    // public function responses()
    // {
    //     return $this->hasMany(Response::class);
    // }
    public function responses()
    {
        return $this->hasMany(Response::class);
    }


    protected static function boot()
    {
        parent::boot();

        static::created(function ($question) {
            $question->addOptions();
        });
    }

    private function addOptions()
    {
        $options = [];

        if ($this->optionType->name === 'Not at all TO Very Much (0-5 score)') {
            $options = [
                ['label' => 'Not at all like me', 'value' => 0],
                ['label' => 'Slightly like me', 'value' => 1],
                ['label' => 'Somewhat like me', 'value' => 2],
                ['label' => 'Moderately like me', 'value' => 3],
                ['label' => 'Quite a bit like me', 'value' => 4],
                ['label' => 'Very much like me', 'value' => 5],
            ];
        } elseif ($this->optionType->name === 'Not at all TO Very Much (1-6 score)') {
            $options = [
                ['label' => 'Not at all like me', 'value' => 1],
                ['label' => 'Slightly like me', 'value' => 2],
                ['label' => 'Somewhat like me', 'value' => 3],
                ['label' => 'Moderately like me', 'value' => 4],
                ['label' => 'Quite a bit like me', 'value' => 5],
                ['label' => 'Very much like me', 'value' => 6],
            ];
        } elseif ($this->optionType->name === 'Agree or Disagree') {
            $options = [
                ['label' => 'Agree', 'value' => 1],
                ['label' => 'Disagree', 'value' => 2],
            ];
        } elseif ($this->optionType->name === 'Yes or No') {
            $options = [
                ['label' => 'Yes', 'value' => 1],
                ['label' => 'No', 'value' => 2],
            ];
        }

        foreach ($options as $option) {
            Option::create([
                'question_id' => $this->id,
                'option_type_id' => $this->option_type_id,
                'label' => $option['label'],
                'value' => $option['value'],
            ]);
        }
    }

}


