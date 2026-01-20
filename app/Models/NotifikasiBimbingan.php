<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotifikasiBimbingan extends Model
{
    protected $table = 'notifikasi_bimbingan';

    protected $fillable = [
        'peserta_bimbingan_id',
        'sesi_bimbingan_id',
        'channel',            // whatsapp | system
        'status_sesi',        // diajukan | revisi | selesai
        'status_waktu',       // ontime | telat | kritis
        'pesan_tambahan',
        'sent_by',
        'sent_at',
    ];

    public function peserta()
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
