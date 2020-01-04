<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKpivotesTable extends Migration
{

    public function up()
    {
        Schema::create('kpivotes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->index();
            $table->float('attitude');
            $table->integer('attitudeCount');
            $table->float('performance');
            $table->integer('performanceCount');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('kpivotes');
    }
}
