<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jenjang extends Model
{
    protected $table = 'jenjang';

    protected $fillable = [
        'kode',
        'nama',
        'jumlah_semester',
    ];

    protected $casts = [
        'jumlah_semester' => 'integer',
    ];
}
