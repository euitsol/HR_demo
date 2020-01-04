<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{

    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->unique();
            $table->integer('supervisor_id')->index();
            $table->integer('payscale_id')->index();
            $table->integer('maxLoanInPercentage')->index();
            $table->integer('provident')->index();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
