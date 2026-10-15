<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliverableSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'deliverable_id',
        'submission_url',
        'file_paths',
        'caption',
        'notes',
        'status',
        'revision_feedback',
        'submitted_at',
        'approved_at',
    ];

    protected $casts = [
        'file_paths' => 'array',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function deliverable(): BelongsTo
    {
        return $this->belongsTo(CampaignDeliverable::class, 'deliverable_id');
    }
}
