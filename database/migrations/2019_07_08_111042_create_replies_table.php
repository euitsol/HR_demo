<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration
{

    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->index();
            $table->integer('project_id')->index();
            $table->integer('department_id')->index();
            $table->integer('comment_id')->index();
            $table->text('reply');
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('replies');
    }
}
