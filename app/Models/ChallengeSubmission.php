<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeSubmission extends Model
{
    use HasFactory;

    protected $table = 'challenge_submission';

    protected $fillable = [
        'challenge_id',
        'mhs_id',
        'status',
        'apresiasi_xp',
        'feedback',
        'submitted_at',
        'approved_at',
    ];

    protected $casts = [
        'apresiasi_xp' => 'integer',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'draft',
        'apresiasi_xp' => 0,
    ];

    /**
     * Relasi ke Challenge
     */
    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    /**
     * Relasi ke Mahasiswa
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mhs::class, 'mhs_id');
    }

    /**
     * Scope untuk status tertentu
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk submission yang sudah dikirim
     */
    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }

    /**
     * Scope untuk submission yang disetujui
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
