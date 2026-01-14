<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PesertaBimbingan extends Model
{
    protected $table = 'peserta_bimbingan';

    protected $fillable = [
        'mhs_id',
        'bimbingan_id',
        'ditunjuk_oleh',
        'status',
        'keterangan',
        'progress',
        'terakhir_topik',
        'terakhir_bimbingan',
        'terakhir_reviewed',
        'current_tahapan_bimbingan_id',
    ];

    /* ================= RELASI ================= */

    public function mahasiswa()
    {
        return $this->belongsTo(Mhs::class, 'mhs_id');
    }

    public function penunjuk()
    {
        return $this->belongsTo(User::class, 'ditunjuk_oleh');
    }

    public function bimbingan()
    {
        return $this->belongsTo(Bimbingan::class, 'bimbingan_id');
    }

    public function sesiBimbingan(): HasMany
    {
        return $this->hasMany(SesiBimbingan::class, 'peserta_bimbingan_id');
    }

    public function tahapanBimbingan()
    {
        return $this->belongsTo(TahapanBimbingan::class, 'current_tahapan_bimbingan_id', 'id');
    }

    /* ================= HELPER LOGIC ================= */

    /**
     * Sesi bimbingan terakhir (apa pun statusnya)
     */
    public function lastBimbingan()
    {
        return $this->sesiBimbingan()
            ->latest('created_at')
            ->first();
    }

    /**
     * Sesi bimbingan terakhir yang valid/disetujui
     * status_sesi_bimbingan > 1
     */
    public function lastValidBimbingan()
    {
        return $this->sesiBimbingan()
            ->where('status_sesi_bimbingan', '>', 1)
            ->latest('created_at')
            ->first();
    }

    /**
     * Jumlah sesi revisi
     * status_sesi_bimbingan < 0
     */
    public function revisiCount(): int
    {
        return $this->sesiBimbingan()
            ->where('status_sesi_bimbingan', '<', 0)
            ->count();
    }

    /**
     * Jumlah sesi perlu review
     * status_sesi_bimbingan = 0 atau 1
     */
    public function reviewCount(): int
    {
        return $this->sesiBimbingan()
            ->whereIn('status_sesi_bimbingan', [0, 1])
            ->count();
    }


    public function sesiPerluReview()
    {
        return $this->hasMany(SesiBimbingan::class, 'peserta_bimbingan_id')
            ->whereIn('status_sesi_bimbingan', [0, 1]);
    }

    public function sesiRevisi()
    {
        return $this->hasMany(SesiBimbingan::class, 'peserta_bimbingan_id')
            ->where('status_sesi_bimbingan', '<', 0);
    }

    public function sesiDisetujui()
    {
        return $this->hasMany(SesiBimbingan::class, 'peserta_bimbingan_id')
            ->where('status_sesi_bimbingan', '>', 1);
    }
}
