<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Add the wallet_id column if it doesn't exist
            if (!Schema::hasColumn('transactions', 'wallet_id')) {
                $table->unsignedBigInteger('wallet_id')->after('id');
                $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['wallet_id']);
            $table->dropColumn('wallet_id');
        });
    }
};