<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Invoice;

class InvoiceService
{
    /**
     * Generate Tax Invoice for Brand and Payout Receipt for Creator upon Escrow Release
     */
    public function generateForBooking(Booking $booking): array
    {
        $booking->loadMissing(['campaign.brandProfile', 'brandProfile.user', 'talentProfile.user']);

        $brandProfile = $booking->brandProfile;
        $talentProfile = $booking->talentProfile;

        // 1. Calculate Tax Geometry
        // Intra-State: If Brand state is Maharashtra or empty, apply CGST (9%) + SGST (9%)
        // Inter-State: If Brand state is outside Maharashtra, apply IGST (18%)
        $brandLocation = strtolower(trim($brandProfile->headquarters ?? $brandProfile->state ?? $brandProfile->city ?? ''));
        if (empty($brandLocation)) {
            $isMaharashtra = true;
            $displayState = 'Maharashtra';
            $displayCity = 'Nashik';
        } else {
            $isMaharashtra = str_contains($brandLocation, 'maharashtra') || str_contains($brandLocation, 'nashik') || str_contains($brandLocation, 'mumbai') || str_contains($brandLocation, 'pune') || str_contains($brandLocation, 'nagpur') || str_contains($brandLocation, 'thane');
            $displayState = $isMaharashtra ? 'Maharashtra' : ucwords($brandLocation);
            $displayCity = $brandProfile->headquarters ?? ($brandProfile->city ?? 'Corporate HQ');
        }

        $agreedFee = (float) $booking->agreed_fee;
        $platformFee = (float) $booking->platform_fee ?: round($agreedFee * 0.10, 2);

        // Taxable Base = Total amount charged to Brand
        $taxableAmount = $agreedFee + $platformFee;
        $gstRate = 18.00;

        if ($isMaharashtra) {
            $taxType = 'cgst_sgst';
            $cgst = round($taxableAmount * 0.09, 2);
            $sgst = round($taxableAmount * 0.09, 2);
            $igst = 0.00;
        } else {
            $taxType = 'igst';
            $cgst = 0.00;
            $sgst = 0.00;
            $igst = round($taxableAmount * 0.18, 2);
        }

        $totalTax = $cgst + $sgst + $igst;
        $grandTotal = $taxableAmount + $totalTax;

        // Formatted Invoice Sequence
        $year = date('Y');
        $nextId = Invoice::whereYear('created_at', $year)->count() + 1;
        $brandInvoiceNumber = sprintf('INV-%s-%04d', $year, $nextId);
        $creatorReceiptNumber = sprintf('REC-%s-%04d', $year, $nextId);

        // Billing Details
        $billingDetails = [
            'company_name' => $brandProfile->company_name ?? ($brandProfile->user->name ?? 'Brand Client'),
            'contact_person' => $brandProfile->contact_person ?? ($brandProfile->user->name ?? ''),
            'email' => $brandProfile->user->email ?? '',
            'gstin' => $brandProfile->gstin_pan ?? ($isMaharashtra ? '27AAAAA0000A1Z5' : '29AAAAA0000A1Z5'),
            'city' => $displayCity,
            'state' => $displayState,
            'country' => 'India',
            'state_code' => $isMaharashtra ? '27' : '29',
        ];

        $talentDetails = [
            'creator_name' => $talentProfile->display_name ?? ($talentProfile->user->name ?? 'Talent Creator'),
            'username' => $talentProfile->username ?? '',
            'email' => $talentProfile->user->email ?? '',
            'city' => $talentProfile->city ?: 'Nashik',
            'state' => $talentProfile->state ?: 'Maharashtra',
            'country' => 'India',
        ];

        // 1. Create or Update Brand Tax Invoice
        $brandInvoice = Invoice::updateOrCreate(
            [
                'booking_id' => $booking->id,
                'invoice_type' => 'brand_tax_invoice',
            ],
            [
                'invoice_number' => $brandInvoiceNumber,
                'brand_profile_id' => $brandProfile->id,
                'talent_profile_id' => $talentProfile->id,
                'currency' => 'INR',
                'subtotal_amount' => $agreedFee,
                'platform_fee_amount' => $platformFee,
                'taxable_amount' => $taxableAmount,
                'gst_rate_percent' => $gstRate,
                'tax_type' => $taxType,
                'cgst_amount' => $cgst,
                'sgst_amount' => $sgst,
                'igst_amount' => $igst,
                'total_tax_amount' => $totalTax,
                'grand_total_amount' => $grandTotal,
                'hsn_sac_code' => '998365', // Advertising and marketing services
                'billing_details' => $billingDetails,
                'talent_details' => $talentDetails,
                'status' => 'paid',
                'issued_at' => now(),
                'paid_at' => now(),
            ]
        );

        // 2. Create or Update Creator Payout Receipt
        $creatorReceipt = Invoice::updateOrCreate(
            [
                'booking_id' => $booking->id,
                'invoice_type' => 'creator_payout_receipt',
            ],
            [
                'invoice_number' => $creatorReceiptNumber,
                'brand_profile_id' => $brandProfile->id,
                'talent_profile_id' => $talentProfile->id,
                'currency' => 'INR',
                'subtotal_amount' => $agreedFee,
                'platform_fee_amount' => 0.00,
                'taxable_amount' => $agreedFee,
                'gst_rate_percent' => 0.00,
                'tax_type' => 'exempt',
                'cgst_amount' => 0.00,
                'sgst_amount' => 0.00,
                'igst_amount' => 0.00,
                'total_tax_amount' => 0.00,
                'grand_total_amount' => $agreedFee,
                'hsn_sac_code' => '998365',
                'billing_details' => $billingDetails,
                'talent_details' => $talentDetails,
                'status' => 'paid',
                'issued_at' => now(),
                'paid_at' => now(),
            ]
        );

        return [
            'brand_invoice' => $brandInvoice,
            'creator_receipt' => $creatorReceipt,
        ];
    }
}
