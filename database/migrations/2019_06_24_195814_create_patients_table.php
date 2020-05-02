<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('last_name');
            $table->bigInteger('doctor_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->integer('mobile_phone')->nullable();
            $table->integer('home_phone')->nullable();
            $table->integer('work_phone')->nullable();
            $table->string('next_name')->nullable();
            $table->string('nest_email')->nullable();
            $table->string('next_relation')->nullable();
            $table->integer('next_mobile_phone')->nullable();
            $table->integer('next_home_phone')->nullable();
            $table->integer('next_work_phone')->nullable();
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
        Schema::dropIfExists('patients');
    }
}
