<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

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

    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'ruang_id');
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


    public static function isBentrokKelasInput(
        int $kelasId,
        int $weekday,
        $jamAwal,
        $jamAkhir,
        ?int $excludeJadwalId = null
    ): bool {
        $query = DB::table('jadwal')
            ->join('stm_item', 'stm_item.id', '=', 'jadwal.stm_item_id')
            ->where('stm_item.kelas_id', $kelasId)
            ->where('jadwal.weekday', $weekday)
            ->where('jadwal.jam_awal', '<', $jamAkhir)
            ->where('jadwal.jam_akhir', '>', $jamAwal);

        if ($excludeJadwalId) {
            $query->where('jadwal.id', '!=', $excludeJadwalId);
        }

        return $query->exists();
    }
}
