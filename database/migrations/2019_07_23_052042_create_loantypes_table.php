<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoantypesTable extends Migration
{

    public function up()
    {
        Schema::create('loantypes', function (Blueprint $table) {
            $table->bigIncrements('id')->index();
            $table->string('type')->unique();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('loantypes');
    }
}
