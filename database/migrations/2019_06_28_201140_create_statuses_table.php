<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->bigInteger('doctor_id')->unsigned();
            $table->date('app_date');
            $table->bigInteger('app_0800')->nullable()->unsigned();
            $table->bigInteger('app_0815')->nullable()->unsigned();
            $table->bigInteger('app_0830')->nullable()->unsigned();
            $table->bigInteger('app_0845')->nullable()->unsigned();
            $table->bigInteger('app_0900')->nullable()->unsigned();
            $table->bigInteger('app_0915')->nullable()->unsigned();
            $table->bigInteger('app_0930')->nullable()->unsigned();
            $table->bigInteger('app_0945')->nullable()->unsigned();
            $table->bigInteger('app_1300')->nullable()->unsigned();
            $table->bigInteger('app_1315')->nullable()->unsigned();
            $table->bigInteger('app_1330')->nullable()->unsigned();
            $table->bigInteger('app_1345')->nullable()->unsigned();
            $table->bigInteger('app_1400')->nullable()->unsigned();
            $table->bigInteger('app_1415')->nullable()->unsigned();
            $table->bigInteger('app_1430')->nullable()->unsigned();
            $table->bigInteger('app_1445')->nullable()->unsigned();
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
        Schema::dropIfExists('statuses');
    }
}
