<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class XpRule extends Model
{
    protected $table = 'xp_rule';

    protected $fillable = [
        'tipe_aktivitas',
        'xp_dasar',
        'kondisi',
        'berlaku_dari',
        'berlaku_sampai',
        'aktif',
    ];

    protected $casts = [
        'kondisi' => 'array',
        'berlaku_dari' => 'date',
        'berlaku_sampai' => 'date',
        'aktif' => 'boolean',
    ];

    /**
     * Scope rule aktif & berlaku
     */
    public function scopeAktif($query)
    {
        return $query
            ->where('aktif', true)
            ->where(function ($q) {
                $q->whereNull('berlaku_dari')
                    ->orWhere('berlaku_dari', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('berlaku_sampai')
                    ->orWhere('berlaku_sampai', '>=', now());
            });
    }
}
