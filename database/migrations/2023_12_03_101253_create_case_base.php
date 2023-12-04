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
        Schema::create('case_base', function (Blueprint $table) {
            $table->id();
//            Problem
            $table->float('solar_irradiance');
            $table->float('temperature');
            $table->float('humidity');
            $table->float('soilPH');
            $table->float('crop_area'); // square meters
//            Solutions
            $table->decimal('irrigation_duration', 8, 2); // in minutes or hours
            $table->decimal('flow_rate', 8, 2); // in liters per minute or gallons per hour
            $table->string('nozzle_type'); // e.g., specific nozzle type or size
            $table->decimal('water_application_rate', 8, 2); // in mm/hour or inches/hour
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_base');
    }
};
