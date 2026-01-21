<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusSesiBimbingan;
use App\Enums\StatusTerakhirBimbingan;

class NotifikasiBimbingan extends Model
{
    protected $table = 'notifikasi_bimbingan';

    protected $fillable = [
        'peserta_bimbingan_id',
        'sesi_bimbingan_id',
        'channel',            // default null | whatsapp | email | push
        'status_sesi_bimbingan',        // 
        'status_terakhir_bimbingan',       // ontime | telat | kritis
        'sent_by',
        'sent_at',
        'status_pengiriman', // null | 1=berhasil | -1=invalid no wa
        'verified_at', // null || saat dosen approve notif nya terkirim ke mhs bimbingannya
    ];

    protected $casts = [
        'status_sesi_bimbingan'     => StatusSesiBimbingan::class,
        'status_terakhir_bimbingan' => StatusTerakhirBimbingan::class,
        'sent_at'                   => 'datetime',
    ];


    public function pesertaBimbingan()
    {
        return $this->belongsTo(PesertaBimbingan::class);
    }

    /* =======================
       STATUS MAPPING
    ======================= */

    public function labelStatusSesi(): string
    {
        return match ($this->status_sesi) {
            'diajukan' => '📨 Diajukan – menunggu review',
            'revisi'   => '🔁 Revisi diperlukan',
            'selesai'  => '✅ Selesai / Disetujui',
            default    => '-',
        };
    }

    public function labelStatusWaktu(): string
    {
        return match ($this->status_waktu) {
            'ontime'  => '🟢 On Time (progres baik)',
            'telat'   => '🟡 Terlambat (perlu perhatian)',
            'kritis'  => '🔴 Kritis (segera tindak lanjut)',
            default   => '-',
        };
    }
}
