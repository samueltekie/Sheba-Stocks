<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kyc_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to users table
            $table->string('document_type'); // Type of document (e.g., ID, passport)
            $table->string('document_path'); // Path to uploaded document
            $table->boolean('verified')->default(false); // Verification status
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kyc_documents');
    }
};