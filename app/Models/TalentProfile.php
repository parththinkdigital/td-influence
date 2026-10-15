<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TalentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'username',
        'display_name',
        'profile_image',
        'gender',
        'dob',
        'city',
        'state',
        'country',
        'languages',
        'height_cm',
        'weight_kg',
        'chest_waist_hip',
        'shoe_size',
        'clothing_size',
        'hair_color',
        'eye_color',
        'beard',
        'tattoos_piercings',
        'years_experience',
        'hosting_style',
        'voice_style',
        'has_stage_exp',
        'has_tv_radio_exp',
        'primary_categories',
        'modeling_categories',
        'event_types',
        'bio',
        'availability_status',
        'price_negotiable',
        'verification_level',
        'completion_rate',
        'response_rate',
        'rating_avg',
        'reviews_count',
    ];

    protected $casts = [
        'dob' => 'date',
        'languages' => 'array',
        'primary_categories' => 'array',
        'modeling_categories' => 'array',
        'event_types' => 'array',
        'price_negotiable' => 'boolean',
        'has_stage_exp' => 'boolean',
        'has_tv_radio_exp' => 'boolean',
        'completion_rate' => 'decimal:2',
        'response_rate' => 'decimal:2',
        'rating_avg' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function portfolios(): HasMany
    {
        return $this->hasMany(TalentPortfolio::class);
    }

    public function socialAccounts(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function rates(): HasMany
    {
        return $this->hasMany(TalentRate::class);
    }

    public function availabilities(): HasMany
    {
        return $this->hasMany(TalentAvailability::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(CampaignApplication::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
