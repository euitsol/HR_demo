<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentgsTable extends Migration
{

    public function up()
    {
        Schema::create('commentgs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->index();
            $table->integer('branch_id')->index();
            $table->text('commentg');
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('commentgs');
    }
}
