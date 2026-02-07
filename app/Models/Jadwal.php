<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    protected $fillable = [
        'stm_item_id',
        'jam_sesi_id',
        'ruang_id',
        'weekday',
        'jam_awal',
        'jam_akhir',
        'is_locked',
        'sks_jadwal', // opsional untuk penyesuaian charter jadwal
    ];

    protected $casts = [
        'is_locked' => 'boolean',
        'jam_awal'  => 'datetime:H:i',
        'jam_akhir' => 'datetime:H:i',
    ];

    /**
     * Relasi: Jadwal milik STM Item
     */
    public function stmItem()
    {
        return $this->belongsTo(StmItem::class, 'stm_item_id');
    }

    /**
     * Relasi: Jadwal mengacu ke JamSesi
     */
    public function jamSesi()
    {
        return $this->belongsTo(JamSesi::class, 'jam_sesi_id');
    }

    /**
     * Accessor: jam efektif (override jika ada)
     */
    public function getJamMulaiAttribute()
    {
        return $this->jam_awal ?: optional($this->jamSesi)->jam_mulai;
    }

    public function getJamSelesaiAttribute()
    {
        return $this->jam_akhir ?: optional($this->jamSesi)->jam_selesai;
    }

    /**
     * Accessor: weekday dari jam_sesi
     */
    public function getWeekdayAttribute()
    {
        return optional($this->jamSesi)->weekday;
    }
}
