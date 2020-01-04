<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserjobinfosTable extends Migration
{

    public function up()
    {
        Schema::create('userjobinfos', function (Blueprint $table) {
            $table->bigIncrements('id');
//            $table->integer('branch_id')->index();
            $table->integer('user_id');
            $table->integer('job_id');
            $table->integer('contract_id');
            $table->text('job_description');
            $table->string('offer_letter')->nullable();
            $table->string('resume')->nullable();
            $table->string('contract_length');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('userjobinfos');
    }
}
