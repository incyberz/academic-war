<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpl extends Model
{
    use HasFactory;

    protected $table = 'cpl';

    protected $fillable = [
        'kode_cpl',
        'deskripsi',
        'prodi_id',
    ];

    /**
     * Relasi: CPL dimiliki oleh satu Prodi
     */
    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
}
