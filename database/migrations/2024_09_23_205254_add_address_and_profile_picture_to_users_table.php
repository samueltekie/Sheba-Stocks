<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressAndProfilePictureToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('address')->after('email'); // Add the address column
            $table->string('profile_picture')->after('address')->nullable(); // Add the profile picture column
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('address'); // Remove the address column
            $table->dropColumn('profile_picture'); // Remove the profile picture column
        });
    }
}