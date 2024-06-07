<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->integer('working_days');
            $table->integer('worked_days');
            $table->integer('leave_taken');
            $table->integer('earned_leaves');
            $table->integer('loss_of_pay');
            $table->decimal('salary', 10, 2);
            $table->integer('leave_deduction');
            $table->decimal('earnings', 10, 2);
            $table->decimal('basic_salary', 10, 2);
            $table->integer('month');
            $table->timestamps();

            //$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salaries');
    }
}
