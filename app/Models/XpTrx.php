<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class XpTrx extends Model
{
    protected $table = 'xp_trx';

    protected $fillable = [
        'user_id',
        'aktivitas_gamifikasi_id',
        'xp',
        'arah',
        'saldo_setelah',
        'keterangan',
    ];

    protected $casts = [
        'xp' => 'integer',
        'saldo_setelah' => 'integer',
    ];

    /* =====================
     |  RELATIONS
     ===================== */

    public function aktivitas()
    {
        return $this->belongsTo(
            AktivitasGamifikasi::class,
            'aktivitas_gamifikasi_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* =====================
     |  SCOPES
     ===================== */

    public function scopeMasuk($query)
    {
        return $query->where('arah', '+');
    }

    public function scopeKeluar($query)
    {
        return $query->where('arah', '-');
    }
}
