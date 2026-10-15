<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Collaboration extends Model
{
    protected $fillable = [
        'campaign_id',
        'influencer_profile_id',
        'application_id',
        'status',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function influencerProfile(): BelongsTo
    {
        return $this->belongsTo(InfluencerProfile::class);
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(CampaignApplication::class);
    }

    public function contentSubmissions(): HasMany
    {
        return $this->hasMany(ContentSubmission::class);
    }
}
