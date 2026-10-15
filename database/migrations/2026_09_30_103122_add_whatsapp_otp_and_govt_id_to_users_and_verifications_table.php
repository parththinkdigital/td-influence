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
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'phone_verified_at')) {
                $table->timestamp('phone_verified_at')->nullable()->after('phone');
            }
            if (! Schema::hasColumn('users', 'whatsapp_opt_in')) {
                $table->boolean('whatsapp_opt_in')->default(true)->after('phone_verified_at');
            }
        });

        Schema::table('verifications', function (Blueprint $table) {
            if (! Schema::hasColumn('verifications', 'document_name')) {
                $table->string('document_name')->nullable()->after('document_type');
            }
            if (! Schema::hasColumn('verifications', 'document_number')) {
                $table->string('document_number')->nullable()->after('document_name');
            }
            if (! Schema::hasColumn('verifications', 'back_document_path')) {
                $table->string('back_document_path')->nullable()->after('document_path');
            }
            if (! Schema::hasColumn('verifications', 'id_type')) {
                $table->string('id_type')->nullable()->after('document_type');
            }
            if (! Schema::hasColumn('verifications', 'rejection_reason')) {
                $table->string('rejection_reason')->nullable()->after('admin_notes');
            }
        });

        if (! Schema::hasTable('phone_otps')) {
            Schema::create('phone_otps', function (Blueprint $table) {
                $table->id();
                $table->string('phone')->index();
                $table->string('otp_hash');
                $table->string('purpose')->default('login'); // login, register, phone_verify
                $table->timestamp('verified_at')->nullable();
                $table->timestamp('expires_at')->nullable();
                $table->string('ip_address')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phone_otps');

        Schema::table('verifications', function (Blueprint $table) {
            $table->dropColumn(['document_name', 'document_number', 'back_document_path', 'id_type', 'rejection_reason']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone_verified_at', 'whatsapp_opt_in']);
        });
    }
};
