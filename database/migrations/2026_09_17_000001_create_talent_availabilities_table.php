<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('talent_profiles', function (Blueprint $table) {
            if (! Schema::hasColumn('talent_profiles', 'availability_status')) {
                $table->string('availability_status')->default('available')->after('bio');
            }
            if (! Schema::hasColumn('talent_profiles', 'modeling_categories')) {
                $table->json('modeling_categories')->nullable()->after('primary_categories');
            }
            if (! Schema::hasColumn('talent_profiles', 'event_types')) {
                $table->json('event_types')->nullable()->after('modeling_categories');
            }
            if (! Schema::hasColumn('talent_profiles', 'price_negotiable')) {
                $table->boolean('price_negotiable')->default(true)->after('availability_status');
            }
        });

        if (! Schema::hasTable('talent_availabilities')) {
            Schema::create('talent_availabilities', function (Blueprint $table) {
                $table->id();
                $table->foreignId('talent_profile_id')->constrained('talent_profiles')->onDelete('cascade');
                $table->date('date');
                $table->enum('status', ['available', 'tentative', 'booked', 'unavailable'])->default('available');
                $table->string('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::table('talent_profiles', function (Blueprint $table) {
            $cols = array_filter(['availability_status', 'modeling_categories', 'event_types', 'price_negotiable'], function ($c) {
                return Schema::hasColumn('talent_profiles', $c);
            });
            if (! empty($cols)) {
                $table->dropColumn($cols);
            }
        });
    }
};
