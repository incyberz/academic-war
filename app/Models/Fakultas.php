<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    // Nama tabel
    protected $table = 'fakultas';

    // Field yang boleh diisi
    protected $fillable = [
        'kode',
        'urutan',
        'nama',
    ];
}
