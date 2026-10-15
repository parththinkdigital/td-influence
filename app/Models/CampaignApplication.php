<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CampaignApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'talent_profile_id',
        'cover_note',
        'quoted_price',
        'selected_portfolio_ids',
        'answers',
        'status',
    ];

    protected $casts = [
        'quoted_price' => 'decimal:2',
        'selected_portfolio_ids' => 'array',
        'answers' => 'array',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function talentProfile(): BelongsTo
    {
        return $this->belongsTo(TalentProfile::class);
    }
}
