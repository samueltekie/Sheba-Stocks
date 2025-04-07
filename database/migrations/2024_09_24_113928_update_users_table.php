<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
   
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->after('id');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->unique()->after('email');
            }
            if (!Schema::hasColumn('users', 'profile_picture')) {
                $table->string('profile_picture')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('profile_picture');
            }
            if (!Schema::hasColumn('users', 'account_type')) {
                $table->enum('account_type', ['basic', 'verified', 'premium'])->default('basic')->after('date_of_birth');
            }
            if (!Schema::hasColumn('users', 'account_status')) {
                $table->enum('account_status', ['active', 'suspended', 'under review'])->default('active')->after('account_type');
            }
        });
    }

    
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }
            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('users', 'profile_picture')) {
                $table->dropColumn('profile_picture');
            }
            if (Schema::hasColumn('users', 'date_of_birth')) {
                $table->dropColumn('date_of_birth');
            }
            if (Schema::hasColumn('users', 'account_type')) {
                $table->dropColumn('account_type');
            }
            if (Schema::hasColumn('users', 'account_status')) {
                $table->dropColumn('account_status');
            }
        });
    }
}