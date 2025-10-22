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

    // karena cinema memegang posisi pertama (one to many: cinema dan schedule)
    // memdaftarkan relasi
    // nama relasi tunggal/jamak tergantung jensis relasi. schedule (many) jamak
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
