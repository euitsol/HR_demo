<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxesTable extends Migration
{

    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('branch_id')->index();
            $table->double('from');
            $table->double('to');
            $table->float('tax');
//            $table->boolean('is_gross')->default(1);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('taxes');
    }
}
