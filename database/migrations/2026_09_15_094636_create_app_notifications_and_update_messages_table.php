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
        Schema::create('app_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('sender_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('type')->default('message'); // message, proposal, application, booking, system
            $table->string('title');
            $table->text('body');
            $table->string('action_url')->nullable();
            $table->json('data')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        if (Schema::hasTable('messages') && ! Schema::hasColumn('messages', 'read_at')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->timestamp('read_at')->nullable()->after('proposal_status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_notifications');

        if (Schema::hasTable('messages') && Schema::hasColumn('messages', 'read_at')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->dropColumn('read_at');
            });
        }
    }
};
