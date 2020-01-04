<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{

    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id')->index();
            $table->integer('branch_id')->index();
            $table->string('title');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
