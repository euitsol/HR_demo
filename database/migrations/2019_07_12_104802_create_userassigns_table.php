<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserassignsTable extends Migration
{

    public function up()
    {
        Schema::create('userassigns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->index();
            $table->integer('project_id')->index();
            $table->integer('department_id')->index();
            $table->integer('task_id')->index();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('userassigns');
    }
}
