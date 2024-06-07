<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdentityFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('identity_files', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('file_type');
            $table->unsignedBigInteger('employee');
            $table->string('employee_id');
            $table->unsignedBigInteger('company_id');
            $table->timestamps();

           // $table->foreign('employee')->references('id')->on('employees')->onDelete('cascade');
           // $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('identity_files');
    }
}
