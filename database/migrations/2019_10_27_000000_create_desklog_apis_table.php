<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesklogApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desklog_apis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('desklog_id');
            $table->unsignedBigInteger('employee_id');
            $table->string('name')->nullable();;
            $table->string('email')->nullable();;
            $table->timestamp('arrival_at')->nullable();
            $table->float('at_work')->nullable();
            $table->float('productive_time')->nullable();
            $table->float('idle_time')->nullable();
            $table->float('private_time')->nullable();
            $table->float('total_time_allocated')->nullable();
            $table->float('total_time_spended')->nullable();
            $table->string('time_zone')->nullable();
            $table->string('app_and_os')->nullable();
            $table->date('publication_date')->nullable();;
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
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
        Schema::dropIfExists('desklog_apis');
    }
}
