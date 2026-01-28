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



    protected $casts = [
        'tanggal_surat' => 'date',          // otomatis jadi Carbon
        'total_sks_tugas' => 'integer',
        'total_sks_beban' => 'integer',
        'total_sks_honor' => 'integer',
        'status' => 'string',
        'uuid' => 'string',
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
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    /**
     * Relasi: STM → Unit Penugasan
     */
    public function unitPenugasan()
    {
        return $this->belongsTo(UnitPenugasan::class);
    }


    public function items()
    {
        return $this->hasMany(StmItem::class, 'stm_id');
    }


    # ============================================================
    # HELPERS
    # ============================================================
    public function updateTotalSks()
    {
        $this->total_sks_tugas = $this->items->sum('sks_tugas');
        $this->total_sks_beban = $this->items->sum('sks_beban');
        $this->total_sks_honor = $this->items->sum('sks_honor');
        $this->save();
    }
}
