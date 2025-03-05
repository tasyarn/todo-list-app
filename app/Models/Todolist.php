<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todolist extends Model
{
    /** @use HasFactory<\Database\Factories\TodolistFactory> */
    use HasFactory;
    protected $fillable = ['user_id', 'task', 'is_completed'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
