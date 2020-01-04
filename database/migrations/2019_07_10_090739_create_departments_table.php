<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{

    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_id');
            $table->string('title');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
