<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTypesTable extends Migration
{

    public function up()
    {
        Schema::create('employee_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->unique();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('employee_types');
    }
}
