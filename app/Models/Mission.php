<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mission extends Model
{
    protected $table = 'mission';

    protected $fillable = [
        'skill_id',
        'nama',
        'deskripsi',
        'tipe',
        'xp',
        'urutan',
    ];

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }
}
