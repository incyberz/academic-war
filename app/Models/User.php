<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'role_id',
        'whatsapp',
        'gender',
        'avatar',
        'password',
        'status',
        'avatar_verified_at',
        'whatsapp_verified_at',
        'alamat_lengkap'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    // Relation to Dosen
    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'user_id', 'id');
    }


    public function pathAvatar()
    {
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            return asset('storage/' . $this->avatar);
        }

        // auto-null jika file tidak ada
        if ($this->avatar) {
            $this->updateQuietly(['avatar' => null]);
        }

        return asset('img/roles/mhs.png');
    }

    public function properName()
    {
        return ucwords(strtolower($this->name));
    }

    public function whatsappUI(): string
    {
        return empty($this->whatsapp) ? '-' : '628...' . substr($this->whatsapp, -3);
    }


    # ============================================================
    # USER GAMIFICATION
    # ============================================================
    public function getIsPasswordDefaultAttribute(): bool
    {
        // misal default = username
        if (!$this->password) return true;

        return Hash::check($this->username, $this->password);
    }

    // Hitung bonus Profile Integrity
    public function getProfileIntegrityBonusAttribute(): int
    {
        $bonus = 0;

        // Password update
        if (!$this->is_password_default) {
            $bonus += 1; // 1% untuk password
        }

        // Avatar verified
        if ($this->avatar_verified_at) {
            $bonus += 2;
        }

        // Email verified
        if ($this->email_verified_at) {
            $bonus += 1;
        }

        // WhatsApp verified (misal ada field whatsapp_verified_at)
        if ($this->whatsapp_verified_at) {
            $bonus += 1;
        }

        // Data alamat lengkap
        if ($this->alamat_lengkap ?? false) {
            $bonus += 1;
        }

        // Hard cap 5%
        return min($bonus, 5);
    }

    // Hitung progress kelengkapan (0-100%)
    public function getProfileIntegrityProgressAttribute(): int
    {
        $steps = 5; // jumlah komponen
        $completed = 0;

        if (!$this->is_password_default) $completed++;
        if ($this->avatar_verified_at) $completed++;
        if ($this->email_verified_at) $completed++;
        if ($this->whatsapp_verified_at) $completed++;
        if ($this->alamat_lengkap ?? false) $completed++;

        return intval(($completed / $steps) * 100);
    }
}
