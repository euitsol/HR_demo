<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKpisTable extends Migration
{

    public function up()
    {
        Schema::create('kpis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->float('attendance');
            $table->float('attitude');
            $table->float('performance');
            $table->float('judgement');
            $table->float('product')->default(18);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('kpis');
    }
}
