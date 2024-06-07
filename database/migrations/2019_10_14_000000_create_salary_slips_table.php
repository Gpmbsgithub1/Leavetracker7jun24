<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalarySlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_slips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('salary_id');
            $table->string('path')->nullable();;
            $table->string('date')->nullable();;
			$table->string('month')->nullable();;
            // You might want to add a column for amount if needed
            // $table->decimal('amount', 10, 2)->nullable();
            $table->timestamps();

           // $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
           // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary_slips');
    }
}
