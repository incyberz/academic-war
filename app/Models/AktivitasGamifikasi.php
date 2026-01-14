<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AktivitasGamifikasi extends Model
{
    protected $table = 'aktivitas_gamifikasi';

    protected $fillable = [
        'user_id',
        'tipe_aktivitas',
        'source_table',
        'source_id',
        'status'
    ];
}
