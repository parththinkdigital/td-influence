<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CampaignDeliverable extends Model
{
    protected $fillable = [
        'campaign_id',
        'name',
        'type',
        'quantity',
        'description',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function contentSubmissions(): HasMany
    {
        return $this->hasMany(ContentSubmission::class, 'deliverable_id');
    }

    public function getDeliverableTypeAttribute(): string
    {
        return $this->name ?: ucwords(str_replace('_', ' ', $this->type ?? 'Deliverable'));
    }
}
