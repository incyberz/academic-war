<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stm extends Model
{
    use HasFactory;

    protected $table = 'stm';

    protected $fillable = [
        'tahun_ajar_id',
        'dosen_id',
        'unit_penugasan_id',
        'nomor_surat',
        'tanggal_surat',
        'penandatangan_nama',
        'penandatangan_jabatan',
        'total_sks_tugas',
        'total_sks_beban',
        'total_sks_honor',
        'status',
    ];

    /**
     * Relasi: STM → Tahun Ajar
     */
    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class);
    }

    /**
     * Relasi: STM → Dosen (via users)
     * NB: ini memang snapshot administratif, bukan entitas dosen akademik
     */
    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    /**
     * Relasi: STM → Unit Penugasan
     */
    public function unitPenugasan()
    {
        return $this->belongsTo(UnitPenugasan::class);
    }

    /**
     * Relasi: STM → Detail STM (rekap sumber utama SKS)
     */
    public function details()
    {
        return $this->hasMany(StmMk::class);
    }
}
