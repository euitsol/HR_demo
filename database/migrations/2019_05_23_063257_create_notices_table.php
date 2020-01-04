<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticesTable extends Migration
{

    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('branch_id')->index();
            $table->integer('employeeType_id')->index();
            // should be secular
            $table->integer('job_id');
//            $table->string('job_title');
            $table->boolean('publish');
            $table->text('notice');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('notices');
    }
}
