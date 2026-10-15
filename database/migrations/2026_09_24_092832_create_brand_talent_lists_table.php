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
        if (! Schema::hasTable('brand_talent_lists')) {
            Schema::create('brand_talent_lists', function (Blueprint $table) {
                $table->id();
                $table->foreignId('brand_profile_id')->constrained()->cascadeOnDelete();
                $table->string('name');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('brand_talent_list_items')) {
            Schema::create('brand_talent_list_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('brand_talent_list_id')->constrained('brand_talent_lists')->cascadeOnDelete();
                $table->foreignId('talent_profile_id')->constrained('talent_profiles')->cascadeOnDelete();
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->unique(['brand_talent_list_id', 'talent_profile_id'], 'btl_items_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_talent_list_items');
        Schema::dropIfExists('brand_talent_lists');
    }
};
