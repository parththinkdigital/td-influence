<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_profile_id',
        'title',
        'campaign_name',
        'slug',
        'category_id',
        'campaign_type',
        'industry_id',
        'objective',
        'description',
        'talent_type',
        'number_required',
        'gender_req',
        'age_min',
        'age_max',
        'height_min_cm',
        'height_max_cm',
        'experience_req',
        'languages_req',
        'look_requirements',
        'work_mode',
        'country',
        'state',
        'city',
        'venue',
        'address',
        'travel_required',
        'travel_reimbursement',
        'accommodation_provided',
        'transport_provided',
        'application_deadline',
        'shoot_date',
        'start_time',
        'end_time',
        'duration_days',
        'backup_date',
        'call_time',
        'budget_type',
        'budget_min',
        'budget_max',
        'currency',
        'status',
    ];

    protected $casts = [
        'languages_req' => 'array',
        'travel_required' => 'boolean',
        'travel_reimbursement' => 'boolean',
        'accommodation_provided' => 'boolean',
        'transport_provided' => 'boolean',
        'application_deadline' => 'date',
        'shoot_date' => 'date',
        'backup_date' => 'date',
        'budget_min' => 'decimal:2',
        'budget_max' => 'decimal:2',
    ];

    public function brandProfile(): BelongsTo
    {
        return $this->belongsTo(BrandProfile::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function deliverables(): HasMany
    {
        return $this->hasMany(CampaignDeliverable::class);
    }

    public function usageRight(): HasOne
    {
        return $this->hasOne(CampaignUsageRight::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(CampaignQuestion::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(CampaignApplication::class)->latest();
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
