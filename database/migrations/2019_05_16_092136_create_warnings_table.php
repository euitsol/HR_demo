<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarningsTable extends Migration
{

    public function up()
    {
        Schema::create('warnings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('branch_id')->index();
            $table->integer('user_id');
            $table->integer('department_id')->nullable();
            $table->text('description');
            $table->boolean('approveDH')->default(0);
            $table->text('appeal')->nullable();
            $table->string('hearing_type')->default(0);
            $table->text('hearing_message')->nullable();
            $table->text('disputer');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('warnings');
    }
}
