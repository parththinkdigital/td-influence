<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'booking_id',
        'brand_profile_id',
        'talent_profile_id',
        'invoice_type',
        'currency',
        'subtotal_amount',
        'platform_fee_amount',
        'taxable_amount',
        'gst_rate_percent',
        'tax_type',
        'cgst_amount',
        'sgst_amount',
        'igst_amount',
        'total_tax_amount',
        'grand_total_amount',
        'hsn_sac_code',
        'billing_details',
        'talent_details',
        'status',
        'issued_at',
        'paid_at',
    ];

    protected $casts = [
        'subtotal_amount' => 'decimal:2',
        'platform_fee_amount' => 'decimal:2',
        'taxable_amount' => 'decimal:2',
        'gst_rate_percent' => 'decimal:2',
        'cgst_amount' => 'decimal:2',
        'sgst_amount' => 'decimal:2',
        'igst_amount' => 'decimal:2',
        'total_tax_amount' => 'decimal:2',
        'grand_total_amount' => 'decimal:2',
        'billing_details' => 'array',
        'talent_details' => 'array',
        'issued_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function brandProfile(): BelongsTo
    {
        return $this->belongsTo(BrandProfile::class);
    }

    public function talentProfile(): BelongsTo
    {
        return $this->belongsTo(TalentProfile::class);
    }
}
