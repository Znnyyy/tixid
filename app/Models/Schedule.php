<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;

    protected $fillable = ['cinema_id', 'movie_id', 'hour', 'price',];

    // casts: memastikan format data 
    protected function casts(): array
    {
        return [
            // mengubah format data hour dari time ke array
            'hour' => 'array',
        ];
    }

    // karena schedule memegang posisi kedua (many to one: schedule dan cinema)
    // cinema pegang posisi pertama dan jenis relasinya (one) jdi gunakan tunggal
    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
