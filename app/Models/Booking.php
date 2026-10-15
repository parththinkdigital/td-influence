<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'application_id',
        'brand_profile_id',
        'talent_profile_id',
        'agreed_fee',
        'platform_fee',
        'total_amount',
        'shoot_date',
        'location',
        'usage_rights',
        'revisions_included',
        'exclusivity_days',
        'contract_terms',
        'status',
    ];

    protected $casts = [
        'agreed_fee' => 'decimal:2',
        'platform_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'revisions_included' => 'integer',
        'exclusivity_days' => 'integer',
        'contract_terms' => 'array',
        'shoot_date' => 'date',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(CampaignApplication::class);
    }

    public function brandProfile(): BelongsTo
    {
        return $this->belongsTo(BrandProfile::class);
    }

    public function talentProfile(): BelongsTo
    {
        return $this->belongsTo(TalentProfile::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(DeliverableSubmission::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function disputes(): HasMany
    {
        return $this->hasMany(Dispute::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
