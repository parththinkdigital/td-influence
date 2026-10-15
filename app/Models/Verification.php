<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Verification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'verification_level',
        'document_type',
        'id_type',
        'document_name',
        'document_number',
        'document_path',
        'back_document_path',
        'status',
        'admin_notes',
        'rejection_reason',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
