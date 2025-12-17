<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodi';
    protected $primaryKey = 'prodi';


    protected $fillable = [
        'fakultas_id',
        'nama',
        'kode',
        'jenjang',
    ];

    /**
     * Relasi ke Fakultas
     * Setiap Prodi dimiliki oleh satu Fakultas
     */
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }

    /**
     * Relasi ke Dosen
     * Satu Prodi memiliki banyak Dosen
     */
    public function dosen()
    {
        return $this->hasMany(Dosen::class);
    }

    /**
     * Relasi lain ke tabel lain (opsional)
     * Misalnya ke Mahasiswa, Kurikulum, MataKuliah, dsb.
     * Bisa ditambahkan kapan saja.
     */
}
