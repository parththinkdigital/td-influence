<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TalentRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'talent_profile_id',
        'rate_type',
        'rate_amount',
        'currency',
        'is_negotiable',
        'notes',
    ];

    protected $casts = [
        'rate_amount' => 'decimal:2',
        'is_negotiable' => 'boolean',
    ];

    public function talentProfile(): BelongsTo
    {
        return $this->belongsTo(TalentProfile::class);
    }
}
