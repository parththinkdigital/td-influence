<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TalentPortfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'talent_profile_id',
        'title',
        'category',
        'description',
        'media_files',
        'brand_worked_with',
        'event_date',
        'location',
        'role_played',
        'campaign_type',
    ];

    protected $casts = [
        'media_files' => 'array',
        'event_date' => 'date',
    ];

    public function talentProfile(): BelongsTo
    {
        return $this->belongsTo(TalentProfile::class);
    }
}
