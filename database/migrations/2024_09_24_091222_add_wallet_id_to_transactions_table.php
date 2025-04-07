<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWalletsAndTransactionsTables extends Migration
{
    public function up()
    {
        // Add the wallet_id column to the transactions table
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('wallet_id')->after('id'); // Adjust 'after' position as necessary
            
            // Set up a foreign key relationship
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
        });

        // Add the invested_amount column to the wallets table
        Schema::table('wallets', function (Blueprint $table) {
            $table->decimal('invested_amount', 10, 2)->default(0); // Adjust the precision as necessary
        });
    }

    public function down()
    {
        // Reverse the changes in the transactions table
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['wallet_id']); // Drop foreign key if it exists
            $table->dropColumn('wallet_id');
        });

        // Reverse the changes in the wallets table
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropColumn('invested_amount');
        });
    }
}