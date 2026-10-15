<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BrandTalentList extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_profile_id',
        'name',
        'description',
    ];

    public function brandProfile(): BelongsTo
    {
        return $this->belongsTo(BrandProfile::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(BrandTalentListItem::class);
    }

    public function talents(): BelongsToMany
    {
        return $this->belongsToMany(TalentProfile::class, 'brand_talent_list_items', 'brand_talent_list_id', 'talent_profile_id')
            ->withPivot('notes')
            ->withTimestamps();
    }
}
