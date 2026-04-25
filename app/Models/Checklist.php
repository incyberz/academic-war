<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Checklist extends Model
{
    use HasFactory;

    protected $table = 'checklists';

    protected $fillable = [
        'checklistable_id',
        'checklistable_type',
        'pertanyaan',
        'urutan',
        'poin',
        'is_wajib',
        'is_active',
    ];

    protected $casts = [
        'urutan'    => 'integer',
        'poin'      => 'integer',
        'is_wajib'  => 'boolean',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi
    |--------------------------------------------------------------------------
    */

    public function checklistable()
    {
        return $this->morphTo();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeWajib($query)
    {
        return $query->where('is_wajib', true);
    }

    public function scopeChallenge($query)
    {
        return $query->where('is_wajib', false);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isWajib()
    {
        return $this->is_wajib === true;
    }

    public function isChallenge()
    {
        return !$this->is_wajib;
    }

    public function isAktif()
    {
        return $this->is_active === true;
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor
    |--------------------------------------------------------------------------
    */

    public function getLabelTipeAttribute()
    {
        return $this->is_wajib ? 'Wajib' : 'Challenge';
    }

    public function getLabelPoinAttribute()
    {
        return '+' . $this->poin . ' XP';
    }
}
