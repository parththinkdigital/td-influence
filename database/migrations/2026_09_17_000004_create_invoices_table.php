<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->foreignId('brand_profile_id')->constrained('brand_profiles')->onDelete('cascade');
            $table->foreignId('talent_profile_id')->constrained('talent_profiles')->onDelete('cascade');
            $table->string('invoice_type')->default('brand_tax_invoice'); // brand_tax_invoice, creator_payout_receipt
            $table->string('currency')->default('INR');

            // Financial amounts
            $table->decimal('subtotal_amount', 12, 2)->default(0.00);
            $table->decimal('platform_fee_amount', 12, 2)->default(0.00);
            $table->decimal('taxable_amount', 12, 2)->default(0.00);
            $table->decimal('gst_rate_percent', 5, 2)->default(18.00);
            $table->string('tax_type')->default('cgst_sgst'); // cgst_sgst, igst, exempt
            $table->decimal('cgst_amount', 12, 2)->default(0.00);
            $table->decimal('sgst_amount', 12, 2)->default(0.00);
            $table->decimal('igst_amount', 12, 2)->default(0.00);
            $table->decimal('total_tax_amount', 12, 2)->default(0.00);
            $table->decimal('grand_total_amount', 12, 2)->default(0.00);
            $table->string('hsn_sac_code')->default('998365'); // Advertising and marketing services

            // Party details
            $table->json('billing_details')->nullable();
            $table->json('talent_details')->nullable();

            $table->string('status')->default('paid'); // issued, paid, refunded
            $table->timestamp('issued_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
