<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidentsTable extends Migration
{

    public function up()
    {
        Schema::create('providents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('from_user');
            $table->float('from_employer');
            $table->boolean('is_gross')->default(0);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('providents');
    }
}
