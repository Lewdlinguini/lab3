<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Set a default value (e.g., 2) for role_id (2 corresponds to the 'Customer' role)
            $table->unsignedBigInteger('role_id')->default(2)->change(); // Default to 'Customer' role (ID 2)
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable()->change(); // Make it nullable if rolling back
        });
    }
};
