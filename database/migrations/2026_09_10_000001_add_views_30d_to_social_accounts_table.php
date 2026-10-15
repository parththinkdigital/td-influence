<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('social_accounts') && ! Schema::hasColumn('social_accounts', 'views_30d')) {
            Schema::table('social_accounts', function (Blueprint $table) {
                $table->unsignedBigInteger('views_30d')->default(0)->after('avg_views');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('social_accounts') && Schema::hasColumn('social_accounts', 'views_30d')) {
            Schema::table('social_accounts', function (Blueprint $table) {
                $table->dropColumn('views_30d');
            });
        }
    }
};
