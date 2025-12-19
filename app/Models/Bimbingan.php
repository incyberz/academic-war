<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    use HasFactory;

    /**
     * Nama tabel (eksplisit untuk konsistensi)
     */
    protected $table = 'bimbingan';

    /**
     * Kolom yang boleh diisi (mass assignment)
     */
    protected $fillable = [
        'pembimbing_id',
        'jenis_bimbingan_id',
        'tahun_ajar_id',
        'status',
        'catatan',
        'wag',
        'wa_message_template',
        'hari_availables',
        'file_surat_tugas',
        'nomor_surat_tugas',
        'akhir_masa_bimbingan',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke Pembimbing
     * bimbingan.pembimbing_id → pembimbing.id
     */
    public function pembimbing()
    {
        return $this->belongsTo(Pembimbing::class);
    }

    /**
     * Relasi ke Peserta Bimbingan
     * bimbingan.peserta_bimbingan_id → peserta_bimbingan.id
     */
    public function pesertaBimbingan()
    {
        return $this->belongsTo(PesertaBimbingan::class);
    }

    /**
     * Relasi ke Jenis Bimbingan
     * bimbingan.jenis_bimbingan_id → jenis_bimbingan.id
     */
    public function jenisBimbingan()
    {
        return $this->belongsTo(JenisBimbingan::class);
    }

    /**
     * Relasi ke Tahun Ajar
     * bimbingan.tahun_ajar_id → tahun_ajar.id
     */
    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Scope bimbingan aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope bimbingan selesai
     */
    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }
}
