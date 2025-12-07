<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    // Nama tabel
    protected $table = 'fakultas';

    // Primary key bukan id, melainkan string 'fakultas'
    protected $primaryKey = 'fakultas';

    // PK bertipe string, bukan increment
    public $incrementing = false;
    protected $keyType = 'string';

    // Field yang boleh diisi
    protected $fillable = [
        'fakultas',
        'urutan',
        'nama',
    ];
}
