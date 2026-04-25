<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubBabLaporan extends Model
{
    use HasFactory;

    protected $table = 'sub_bab_laporan';

    protected $fillable = [
        'bab_laporan_id',
        'kode',
        'nama',
        'urutan',
        'deskripsi',

        // gamifikasi
        'poin',
        'is_wajib',

        // bukti (JPG only)
        'petunjuk_bukti',
        'contoh_bukti',

        // workflow
        'can_revisi',

        // kontrol
        'is_active',
        'is_locked',
    ];

    protected $casts = [
        'urutan'     => 'integer',
        'poin'       => 'integer',
        'is_wajib'   => 'boolean',
        'can_revisi' => 'boolean',
        'is_active'  => 'boolean',
        'is_locked'  => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Relasi
    |--------------------------------------------------------------------------
    */

    public function bab()
    {
        return $this->belongsTo(BabLaporan::class, 'bab_laporan_id');
    }

    public function checklists()
    {
        return $this->morphMany(Checklist::class, 'checklistable')
            ->orderBy('urutan');
    }

    public function bukti()
    {
        return $this->hasMany(BuktiSubBabLaporan::class, 'sub_bab_laporan_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeByBab($query, $babId)
    {
        return $query->where('bab_laporan_id', $babId);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers - Checklist
    |--------------------------------------------------------------------------
    */

    public function checklistsAktif()
    {
        return $this->checklists()->where('is_active', true);
    }

    public function checklistsWajib()
    {
        return $this->checklistsAktif()->where('is_wajib', true);
    }

    public function checklistsChallenge()
    {
        return $this->checklistsAktif()->where('is_wajib', false);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers - Agregasi
    |--------------------------------------------------------------------------
    */

    public function totalChecklist()
    {
        return $this->checklistsAktif()->count();
    }

    public function totalChecklistWajib()
    {
        return $this->checklistsWajib()->count();
    }

    public function totalPoinChecklist()
    {
        return $this->checklistsAktif()->sum('poin');
    }

    public function totalPoinWajib()
    {
        return $this->checklistsWajib()->sum('poin');
    }

    public function totalPoinChallenge()
    {
        return $this->checklistsChallenge()->sum('poin');
    }

    public function totalPoinSemua()
    {
        return (int) $this->poin + (int) $this->totalPoinChecklist();
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers - Validasi Submission
    |--------------------------------------------------------------------------
    */

    public function isChecklistWajibTerpenuhi(array $checkedIds = [])
    {
        $totalWajib = $this->totalChecklistWajib();

        if ($totalWajib === 0) {
            return true;
        }

        $checkedWajib = $this->checklistsWajib()
            ->whereIn('id', $checkedIds)
            ->count();

        return $checkedWajib === $totalWajib;
    }

    public function hitungXpDariChecklist(array $checkedIds = [])
    {
        if (empty($checkedIds)) {
            return 0;
        }

        return $this->checklistsAktif()
            ->whereIn('id', $checkedIds)
            ->sum('poin');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor (opsional tapi enak dipakai di Blade)
    |--------------------------------------------------------------------------
    */

    public function getTotalPoinAttribute()
    {
        return $this->totalPoinSemua();
    }


    /*
    |--------------------------------------------------------------------------
    | Helper
    |--------------------------------------------------------------------------
    */

    /**
     * Format label lengkap (contoh: 3.1 - Analisis Kebutuhan Sistem)
     */
    public function getLabelAttribute()
    {
        return "{$this->kode} - {$this->nama}";
    }

    public function getJumlahBuktiAttribute()
    {
        // kalau sudah eager load withCount, pakai itu
        if (array_key_exists('bukti_count', $this->attributes)) {
            return $this->attributes['bukti_count'];
        }

        // fallback (kalau belum pakai withCount)
        return $this->bukti()->count();
    }
}
