<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagcgsTable extends Migration
{

    public function up()
    {
        Schema::create('tagcgs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('branch_id')->index();
            $table->integer('comment_id')->index();
            $table->integer('user_id');
            $table->boolean('seen')->default(0)->index();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('tagcgs');
    }
}
