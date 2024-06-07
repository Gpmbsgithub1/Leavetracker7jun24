<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('user_id');
            $table->json('dates')->nullable();
            $table->float('days')->nullable();
            $table->string('leave_type')->nullable();
            $table->text('leave_reason')->nullable();
            $table->unsignedBigInteger('hr_id');
			$table->unsignedBigInteger('approve');
            $table->boolean('manager')->default(0);
            $table->boolean('no_group')->default(0);
            $table->timestamps();

            // Define foreign key constraints
            // $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //$table->foreign('hr_id')->references('id')->on('users')->onDelete('cascade');
            // Add other foreign key constraints if necessary
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_requests');
    }
}
