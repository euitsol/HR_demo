<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncrementpoliciesTable extends Migration
{
    public function up()
    {
        Schema::create('incrementpolicies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('below');
            $table->float('increment_1');
            $table->float('above_1');
            $table->float('increment_2');
            $table->float('above_2');
            $table->float('increment_3');
            $table->float('increment_max');
            $table->boolean('is_kpi')->default(1);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('incrementpolicies');
    }
}
