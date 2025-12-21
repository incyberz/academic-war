<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodi';


    protected $fillable = [
        'prodi',
        'urutan',
        'fakultas_id',
        'nama',
        'jenjang',
    ];

    /**
     * Relasi ke Fakultas
     * Setiap Prodi dimiliki oleh satu Fakultas
     */
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }

    /**
     * Relasi ke Dosen
     * Satu Prodi memiliki banyak Dosen
     */
    public function dosen()
    {
        return $this->hasMany(Dosen::class, 'prodi_id');
    }
}
