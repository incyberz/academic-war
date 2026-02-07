<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JamSesi extends Model
{
    use HasFactory;

    protected $table = 'jam_sesi';

    /**
     * Mass assignment
     */
    protected $fillable = [
        'shift_id',
        'weekday',
        'urutan',
        'jam_mulai',
        'jam_selesai',
        'can_chartered',
        'keterangan',
    ];

    /**
     * Cast attributes
     */
    protected $casts = [
        'can_chartered' => 'boolean',
        'jam_mulai'     => 'datetime:H:i',
        'jam_selesai'   => 'datetime:H:i',
    ];

    /* =======================================================
     | RELATIONS
     ======================================================= */

    /**
     * Jam sesi ini milik satu shift
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    /**
     * Jam sesi ini bisa dipakai oleh banyak jadwal
     */
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jam_sesi_id');
    }


    /* =======================================================
     | SCOPES
     ======================================================= */

    /**
     * Filter berdasarkan hari
     */
    public function scopeWeekday($query, int $weekday)
    {
        return $query->where('weekday', $weekday);
    }

    /**
     * Hanya sesi yang boleh di-charter
     */
    public function scopeCanChartered($query)
    {
        return $query->where('can_chartered', true);
    }

    /**
     * Urutkan natural (urutan sesi)
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }

    /* =======================================================
     | HELPERS / ATTRIBUTES
     ======================================================= */

    /**
     * Label jam: 07:30 - 08:20
     */
    public function getLabelJamAttribute(): string
    {
        return $this->jam_mulai->format('H:i')
            . ' - ' .
            $this->jam_selesai->format('H:i');
    }

    /**
     * Apakah sesi ini default sistem (tidak bisa diambil)?
     */
    public function getIsSystemHiddenAttribute(): bool
    {
        return !$this->can_chartered;
    }

    public function getIsAvailableAttribute(): bool
    {
        return $this->jadwal()->count() === 0 && $this->can_chartered;
    }
}
