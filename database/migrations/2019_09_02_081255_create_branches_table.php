<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchesTable extends Migration
{

    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->bigIncrements('id')->index();
            $table->string('title')->unique();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('branches');
    }
}
