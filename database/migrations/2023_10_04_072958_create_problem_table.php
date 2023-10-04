<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('problem', function (Blueprint $table) {
            $table->id();
            $table->float('solar_irradiance');
            $table->float('temperature');
            $table->float('humidity');
            $table->float('soilPH');
            // Add any other columns if needed
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('problem');
    }
};
