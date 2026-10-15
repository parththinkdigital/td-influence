<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneOtp extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'otp_hash',
        'purpose',
        'verified_at',
        'expires_at',
        'ip_address',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'expires_at' => 'datetime',
    ];
}
