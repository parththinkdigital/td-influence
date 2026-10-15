<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BrandTalentListItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_talent_list_id',
        'talent_profile_id',
        'notes',
    ];

    public function talentList(): BelongsTo
    {
        return $this->belongsTo(BrandTalentList::class, 'brand_talent_list_id');
    }

    public function talentProfile(): BelongsTo
    {
        return $this->belongsTo(TalentProfile::class);
    }
}
