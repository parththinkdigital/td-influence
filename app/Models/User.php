<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'phone_verified_at',
        'whatsapp_opt_in',
        'password',
        'google_id',
        'role',
        'status',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'whatsapp_opt_in' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function isPhoneVerified(): bool
    {
        return ! is_null($this->phone_verified_at);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isBrand(): bool
    {
        return $this->role === 'brand';
    }

    public function isTalent(): bool
    {
        return $this->role === 'talent' || $this->role === 'influencer';
    }

    public function brandProfile(): HasOne
    {
        return $this->hasOne(BrandProfile::class);
    }

    public function talentProfile(): HasOne
    {
        return $this->hasOne(TalentProfile::class);
    }

    public function verifications(): HasMany
    {
        return $this->hasMany(Verification::class);
    }

    public function appNotifications(): HasMany
    {
        return $this->hasMany(AppNotification::class)->latest();
    }

    public function unreadNotificationsCount(): int
    {
        return $this->hasMany(AppNotification::class)->whereNull('read_at')->count();
    }
}
