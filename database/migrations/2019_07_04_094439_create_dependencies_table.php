<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDependenciesTable extends Migration
{

    public function up()
    {
        Schema::create('dependencies', function (Blueprint $table) {
            $table->bigIncrements('id')->index();
            $table->integer('task_id')->index();
            $table->integer('dependency')->index();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('dependencies');
    }
}
