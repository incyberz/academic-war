<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunAjar extends Model
{
    protected $table = 'tahun_ajar';

    /**
     * Primary key bukan auto increment
     */
    public $incrementing = false;

    /**
     * Tipe primary key
     */
    protected $keyType = 'int';

    protected $fillable = [
        'id',               // ⬅️ WAJIB agar bisa mass assign
        'is_active',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    /**
     * Relasi ke tabel bimbingan
     */
    public function bimbingan(): HasMany
    {
        return $this->hasMany(Bimbingan::class, 'tahun_ajar_id', 'id');
    }

    public function getNamaAttribute()
    {
        // Ambil id tahun ajar misal: 20251
        $id = $this->id;

        // Pisahkan tahun dan semester
        $tahun = intdiv($id, 10); // misal 20251 / 10 = 2025
        $semester_digit = $id % 10; // 20251 % 10 = 1

        // Hitung tahun ajar kedua
        $tahun_akhir = $tahun + 1;

        // Tentukan ganjil/genap
        $ganjil_genap = $semester_digit == 1 ? 'Ganjil' : 'Genap';

        return "$tahun/$tahun_akhir $ganjil_genap";
    }
}
