<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SesiBimbingan extends Model
{
    use HasFactory;

    protected $table = 'sesi_bimbingan';

    protected $fillable = [
        'peserta_bimbingan_id',
        'bab_laporan_id',          // Bab awal, Bab I, II, dst
        'tahapan_bimbingan_id',    // Tahapan (proposal, skripsi, dst)
        'status_sesi_bimbingan',   // config/status_sesi_bimbingan.php
        'revisi_id',   // referensi revisi mengacu ke
        'topik',
        'pesan_mhs',
        'nama_dokumen',
        'pesan_dosen',
        'is_offline',
        'tanggal_offline',
        'jam_offline',
        'lokasi_offline',
        'file_bimbingan',
        'file_review',
        'tanggal_review',
        'tanggal_revisi',
        'last_reminder_at', // notif whatsapp dari mhs
        'reminder_count', // batasan 1x per minggu

    ];

    protected $casts = [
        'tanggal_review' => 'datetime',
        'tanggal_revisi' => 'datetime',
        'tanggal_offline' => 'date',
        'last_reminder_at' => 'datetime',
        'is_offline'     => 'boolean',
    ];

    /* ======================
     * RELATIONS
     * ====================== */

    /** 
     * Sesi dimiliki oleh satu peserta bimbingan
     */
    public function pesertaBimbingan(): BelongsTo
    {
        return $this->belongsTo(
            PesertaBimbingan::class,
            'peserta_bimbingan_id'
        );
    }

    /**
     * Bab laporan yang dibahas pada sesi ini
     */
    public function babLaporan(): BelongsTo
    {
        return $this->belongsTo(
            BabLaporan::class,
            'bab_laporan_id'
        );
    }

    /**
     * Tahapan bimbingan (proposal, skripsi, yudisium, dll)
     */
    public function tahapanBimbingan(): BelongsTo
    {
        return $this->belongsTo(
            TahapanBimbingan::class,
            'tahapan_bimbingan_id'
        );
    }
    public function lastReminder()
    {
        return $this->last_reminder_at->format('d M Y H:i');
    }
}
