<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'application_id',
        'brand_user_id',
        'talent_user_id',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(CampaignApplication::class);
    }

    public function brandUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'brand_user_id');
    }

    public function talentUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'talent_user_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
