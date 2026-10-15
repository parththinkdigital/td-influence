<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('messages')) {
            Schema::table('messages', function (Blueprint $table) {
                if (! Schema::hasColumn('messages', 'usage_rights')) {
                    $table->string('usage_rights')->nullable()->after('proposal_price');
                }
                if (! Schema::hasColumn('messages', 'revisions_included')) {
                    $table->integer('revisions_included')->default(1)->after('usage_rights');
                }
                if (! Schema::hasColumn('messages', 'exclusivity_days')) {
                    $table->integer('exclusivity_days')->default(0)->after('revisions_included');
                }
                if (! Schema::hasColumn('messages', 'counter_note')) {
                    $table->text('counter_note')->nullable()->after('exclusivity_days');
                }
            });
        }

        if (Schema::hasTable('bookings')) {
            Schema::table('bookings', function (Blueprint $table) {
                if (! Schema::hasColumn('bookings', 'usage_rights')) {
                    $table->string('usage_rights')->default('organic_only')->after('location');
                }
                if (! Schema::hasColumn('bookings', 'revisions_included')) {
                    $table->integer('revisions_included')->default(1)->after('usage_rights');
                }
                if (! Schema::hasColumn('bookings', 'exclusivity_days')) {
                    $table->integer('exclusivity_days')->default(0)->after('revisions_included');
                }
                if (! Schema::hasColumn('bookings', 'contract_terms')) {
                    $table->json('contract_terms')->nullable()->after('exclusivity_days');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('messages')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->dropColumn(['usage_rights', 'revisions_included', 'exclusivity_days', 'counter_note']);
            });
        }

        if (Schema::hasTable('bookings')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropColumn(['usage_rights', 'revisions_included', 'exclusivity_days', 'contract_terms']);
            });
        }
    }
};
