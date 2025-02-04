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
//            Solutions
            $table->decimal('irrigation_duration', 8, 2); // in minutes or hours                   مدت زمان آبیاری
            $table->decimal('flow_rate', 8, 2); // in liters per minute or gallons per hour        نرخ جریان آب
            $table->unsignedBigInteger('nozzle_id'); // Foreign key reference to the nozzle table              نوع نازل
            $table->decimal('water_application_rate', 8, 2); // in mm/hour or inches/hour          میزان مصرف آب اینچ بر ساعت


            $table->timestamps();

            $table->foreign('nozzle_id')->references('id')->on('nozzle')->onDelete('cascade');

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
