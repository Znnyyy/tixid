<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cinema extends Model
{
    //mendaftarkan soft delete
    use SoftDeletes;

    // mendaftarkan coloumn yg akan di isi
    protected $fillable = ['name', 'location'];
}
