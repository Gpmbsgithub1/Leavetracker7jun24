<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJapisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('japis', function (Blueprint $table) {
            $table->id();
            $table->string('api')->nullable();
            $table->string('name')->nullable();
            $table->string('prameter')->nullable();
            $table->string('job_id')->nullable();
            $table->string('url')->nullable();
            $table->string('slug')->nullable();
            $table->string('job_title')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_slug')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('category_name')->nullable();
            $table->string('job_type')->nullable();
            $table->string('tags')->nullable();
            $table->string('required_location')->nullable();
            $table->string('salary')->nullable();
            $table->text('description')->nullable();
            $table->date('publication_date')->nullable();
            $table->string('job_resource')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('japis');
    }
}
