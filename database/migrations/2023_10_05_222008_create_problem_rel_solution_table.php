<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProblemRelSolutionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ProblemRelSolution', function (Blueprint $table) {
            $table->id(); // Auto-incremental primary key
            $table->unsignedBigInteger('problem_id'); // Unsigned big integer column for problem_id
            $table->unsignedBigInteger('solution_id'); // Unsigned big integer column for solution_id

            // Define foreign key constraints
            $table->foreign('problem_id')->references('id')->on('problem')->onDelete('cascade');
            $table->foreign('solution_id')->references('id')->on('solution')->onDelete('cascade');

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
        Schema::dropIfExists('ProblemRelSolution');
    }
}

