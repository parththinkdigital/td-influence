<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CampaignUsageRight extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'channels',
        'duration',
        'geography',
        'exclusivity',
    ];

    protected $casts = [
        'channels' => 'array',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }
}
