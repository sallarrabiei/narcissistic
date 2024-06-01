<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isSuperAdmin()
    {
        return $this->user_type == 1;
    }

    public function hasPaidForSurvey(Survey $survey)
    {
        // Implement your logic to check if the user has paid for the survey
        // For example, you can check a payments table or a pivot table
        return $this->surveys()->where('survey_id', $survey->id)->exists();
    }

    public function payForSurvey(Survey $survey)
    {
        // Implement your logic to mark the survey as paid for the user
        // For example, adding a record in a pivot table `survey_user`
        $this->surveys()->attach($survey->id);
    }

    public function surveys()
    {
        return $this->belongsToMany(Survey::class, 'survey_user');
    }
}
