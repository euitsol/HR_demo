<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{

    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_id')->index();
            $table->string('department_id')->index();
            $table->string('title');
            $table->date('deadline');
            $table->text('remark')->nullable();
            $table->boolean('progress')->default(0)->index();
            $table->boolean('submit')->default(0)->index();
            $table->text('submit_report')->nullable();
            $table->string('submit_file')->nullable();
            $table->boolean('submit_accept')->default(0)->index();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
