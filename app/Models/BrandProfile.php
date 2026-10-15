<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BrandProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'logo',
        'website',
        'industry_id',
        'description',
        'year_established',
        'company_size',
        'headquarters',
        'cities_served',
        'contact_person',
        'contact_designation',
        'contact_phone',
        'gstin_pan',
        'verification_status',
        'verification_docs',
    ];

    protected $casts = [
        'verification_docs' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function talentLists(): HasMany
    {
        return $this->hasMany(BrandTalentList::class);
    }
}
