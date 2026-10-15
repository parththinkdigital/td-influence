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
        Schema::table('social_accounts', function (Blueprint $table) {
            if (! Schema::hasColumn('social_accounts', 'access_token')) {
                $table->text('access_token')->nullable()->after('recent_media');
            }
            if (! Schema::hasColumn('social_accounts', 'token_expires_at')) {
                $table->timestamp('token_expires_at')->nullable()->after('access_token');
            }
            if (! Schema::hasColumn('social_accounts', 'instagram_user_id')) {
                $table->string('instagram_user_id')->nullable()->after('token_expires_at');
            }
            if (! Schema::hasColumn('social_accounts', 'refresh_token')) {
                $table->text('refresh_token')->nullable()->after('instagram_user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('social_accounts', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('social_accounts', 'access_token')) {
                $columns[] = 'access_token';
            }
            if (Schema::hasColumn('social_accounts', 'token_expires_at')) {
                $columns[] = 'token_expires_at';
            }
            if (Schema::hasColumn('social_accounts', 'instagram_user_id')) {
                $columns[] = 'instagram_user_id';
            }
            if (Schema::hasColumn('social_accounts', 'refresh_token')) {
                $columns[] = 'refresh_token';
            }
            if (! empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
