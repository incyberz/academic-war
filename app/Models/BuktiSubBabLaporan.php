<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BuktiSubBabLaporan extends Model
{
    use HasFactory;

    protected $table = 'bukti_sub_bab_laporan';

    protected $fillable = [

        // relasi utama
        'sub_bab_laporan_id',
        'peserta_bimbingan_id',

        // file
        'file_path',

        // workflow (tinyint status)
        'status',

        'catatan',

        // gamifikasi
        'poin_didapat',

        // approval
        'approved_by',
        'approved_at',

        // revisi tracking
        'revisi_ke',
    ];

    protected $casts = [
        'status'       => 'integer',
        'poin_didapat' => 'integer',
        'revisi_ke'    => 'integer',
        'approved_at'  => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    public function subBab()
    {
        return $this->belongsTo(SubBabLaporan::class, 'sub_bab_laporan_id');
    }

    public function peserta()
    {
        return $this->belongsTo(PesertaBimbingan::class, 'peserta_bimbingan_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER STATUS
    |--------------------------------------------------------------------------
    */

    public function getStatusMetaAttribute()
    {
        return config("status_bukti_sub_bab_laporan.{$this->status}");
    }

    public function getStatusLabelAttribute()
    {
        return $this->status_meta['label'] ?? '-';
    }

    public function getStatusEmojiAttribute()
    {
        return $this->status_meta['emoji'] ?? '';
    }

    public function getStatusKeyAttribute()
    {
        return $this->status_meta['key'] ?? null;
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopePending($query)
    {
        return $query->where('status', 0);
    }

    public function scopeRevisi($query)
    {
        return $query->where('status', 1);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 2);
    }
}
