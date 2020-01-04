<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeavedatesTable extends Migration
{

    public function up()
    {
        Schema::create('leavedates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('branch_id')->index();
            $table->integer('leavetype_id');
            $table->date('date');
//            $table->boolean('approve')->default(0);
            $table->boolean('approveHR')->default(0);
            $table->boolean('approveDH')->default(0);
            $table->boolean('rejectHR')->default(0);
            $table->boolean('rejectDH')->default(0);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('leavedates');
    }
}
