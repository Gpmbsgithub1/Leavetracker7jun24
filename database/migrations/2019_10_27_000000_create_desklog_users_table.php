<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesklogUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desklog_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('desklog_id');
            $table->unsignedBigInteger('employee_id');
            $table->string('name')->nullable();;
            $table->string('email')->nullable();;
            $table->unsignedBigInteger('team_id')->nullable();
            $table->string('team_name')->nullable();
            $table->string('role')->nullable();
            $table->boolean('is_online')->default(false);
            $table->string('app_and_os')->nullable();
            $table->timestamps();

            // Define foreign key constraints
           //$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
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
        Schema::dropIfExists('desklog_users');
    }
}
