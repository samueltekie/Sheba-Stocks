<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();  // User relationship
            $table->decimal('total_balance', 15, 2)->default(10000);  // Initial balance
            $table->decimal('available_balance', 15, 2)->default(10000);  // Available for trading
            $table->decimal('invested_amount', 15, 2)->default(0);  // Stocks purchased
            $table->decimal('pending_funds', 15, 2)->default(0);  // Pending transactions
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
