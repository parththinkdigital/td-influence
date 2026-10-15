<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TalentAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'talent_profile_id',
        'date',
        'status',
        'note',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function talentProfile(): BelongsTo
    {
        return $this->belongsTo(TalentProfile::class);
    }
}
