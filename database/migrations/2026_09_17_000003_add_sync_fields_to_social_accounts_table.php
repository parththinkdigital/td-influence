<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('social_accounts', function (Blueprint $table) {
            $table->timestamp('last_synced_at')->nullable()->after('is_verified');
            $table->string('sync_source')->nullable()->after('last_synced_at');
        });
    }

    public function down(): void
    {
        Schema::table('social_accounts', function (Blueprint $table) {
            $table->dropColumn(['last_synced_at', 'sync_source']);
        });
    }
};
