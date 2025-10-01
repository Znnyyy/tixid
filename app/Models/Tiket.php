<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tiket extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'schedule_id', 'promo_id','rows_of_seat', 'quantity', 'total_price', 'date', 'actived'];
}
