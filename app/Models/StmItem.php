<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StmItem extends Model
{
    use HasFactory;

    protected $table = 'stm_item';

    protected $fillable = [
        'kur_mk_id',
        'kelas_id',
        'stm_mk_id',
        'kapasitas',
        'is_open',
    ];

    /**
     * Relasi: StmItem → KurMk (MK dalam kurikulum)
     */
    public function kurMk()
    {
        return $this->belongsTo(KurMk::class);
    }

    /**
     * Relasi: StmItem → Kelas aktual
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Relasi: StmItem → STM Detail (dosen pengampu)
     * nullable → belum dijadwalkan
     */
    public function stmMk()
    {
        return $this->belongsTo(StmMk::class);
    }
}
