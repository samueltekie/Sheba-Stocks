<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Existing column
            $table->string('email')->unique(); // Existing column
            $table->timestamp('email_verified_at')->nullable(); // Existing column
            $table->string('password'); // Existing column
            $table->rememberToken(); // Existing column
            $table->timestamps(); // Existing column

            // New columns
            $table->string('username')->unique()->after('id'); // Unique username
            $table->string('phone')->unique()->after('email'); // Unique phone number
            $table->string('profile_picture')->nullable()->after('phone'); // Profile picture
            $table->date('date_of_birth')->nullable()->after('profile_picture'); // Date of birth
            $table->enum('account_type', ['basic', 'verified', 'premium'])->default('basic')->after('date_of_birth'); // Account type
            $table->enum('account_status', ['active', 'suspended', 'under review'])->default('active')->after('account_type'); // Account status
        });

        // Add OTP and OTP expiration columns
        Schema::table('users', function (Blueprint $table) {
            $table->string('otp')->nullable()->after('account_status'); // OTP for verification
            $table->timestamp('otp_expires_at')->nullable()->after('otp'); // OTP expiration timestamp
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['otp', 'otp_expires_at']); // Drop OTP columns if rolling back
        });

        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};