<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('cmp');
            $table->unsignedBigInteger('hr_id');
            $table->string('employee_id')->unique();
            $table->date('joining_date');
            $table->string('designation');
            $table->string('employment_type');
            $table->char('gender', 1);
            $table->unsignedInteger('paternity_leave')->nullable();
            $table->unsignedInteger('maternity_leave')->nullable();
            $table->unsignedInteger('casual_leave');
            $table->unsignedInteger('seniority_leave');
            $table->unsignedInteger('medical_leave');
            $table->unsignedInteger('bereavement_leave');
            $table->unsignedInteger('loss_of_pay');
            $table->unsignedInteger('comp_off');
            $table->string('email')->unique();
            $table->string('alternate_email')->nullable();
            $table->string('phone')->nullable();
            $table->string('alternate_phone')->nullable();
            $table->text('address')->nullable();
            $table->date('birth_day')->nullable();
            $table->date('wedding_day')->nullable();
            $table->string('bank_account')->nullable();
            $table->decimal('base_salary', 10, 2);
            $table->decimal('basic_salary', 10, 2);
            $table->decimal('hra', 10, 2)->nullable();
            $table->decimal('other_allow', 10, 2)->nullable();
            $table->decimal('salary_advance', 10, 2)->nullable();
            $table->string('password');
            $table->string('pass')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('hr')->default(false);
            $table->unsignedBigInteger('groups')->default(0);
            $table->rememberToken();
            $table->timestamps();

           // $table->foreign('cmp')->references('id')->on('companies')->onDelete('cascade');
           // $table->foreign('hr_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
