<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeavesTable extends Migration
{

    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('leavetype_id');
            $table->integer('accepted_days');
//            $table->integer('unaccepted_days');
            $table->integer('year');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('leaves');
    }
}
