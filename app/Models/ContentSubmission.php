<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentSubmission extends Model
{
    protected $fillable = [
        'collaboration_id',
        'deliverable_id',
        'content_type',
        'content_url',
        'caption',
        'notes',
        'status',
        'admin_notes',
        'submitted_at',
        'approved_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function collaboration(): BelongsTo
    {
        return $this->belongsTo(Collaboration::class);
    }

    public function deliverable(): BelongsTo
    {
        return $this->belongsTo(CampaignDeliverable::class, 'deliverable_id');
    }
}
