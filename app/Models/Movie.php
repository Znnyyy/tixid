<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{

    protected $fillable = ['title', 'genre', 'duration', 'director', 'age_rating', 'poster', 'description', 'actived'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
