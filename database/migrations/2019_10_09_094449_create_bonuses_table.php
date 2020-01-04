<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBonusesTable extends Migration
{
    public function up()
    {
        Schema::create('bonuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('percentage');
            $table->boolean('is_gross')->default(0);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('bonuses');
    }
}
