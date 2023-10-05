<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolutionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solution', function (Blueprint $table) {
            $table->id(); // Auto-incremental primary key
            $table->decimal('spray_volume', 8, 2); // Decimal column for spray volume
            $table->decimal('operation_pressure', 8, 2); // Decimal column for operation pressure
            $table->decimal('spray_concentration', 8, 2); // Decimal column for spray concentration
            // Add more columns as needed
            $table->timestamps(); // Created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solution');
    }
}
