<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['page_id', 'author', 'content', 'status'];

    protected $attributes = [
        'status' => 'pending', // Set default status to pending
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}


