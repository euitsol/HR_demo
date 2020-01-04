<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKpisetupsTable extends Migration
{

    public function up()
    {
        Schema::create('kpisetups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('attendance');
            $table->float('attendanceTarget');
            $table->float('attitude');
            $table->float('attitudeTarget');
            $table->float('performance');
            $table->float('performanceTarget');
            $table->float('judgement')->default('20');
            $table->float('judgementTarget')->default('15');
            $table->float('promotion')->default('25');
            $table->float('chain')->default('0');
            $table->float('product')->default(20);
            $table->float('productTarget')->default(15);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('kpisetups');
    }
}
