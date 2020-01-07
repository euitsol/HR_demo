<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficesTable extends Migration
{

    public function up()
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('branch_id');
            $table->string('logo')->nullable();
            $table->string('logo_bg')->nullable();
            $table->string('footer')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('offices');
    }
}
