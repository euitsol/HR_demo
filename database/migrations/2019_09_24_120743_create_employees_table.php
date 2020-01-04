<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{

    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->index();
            $table->integer('employeeType_id')->index();
            $table->integer('religion_id')->index();
            $table->integer('leave_id')->nullable();
            $table->integer('termination_id')->nullable();
            $table->string('dob');
            $table->string('FathersName');
            $table->string('MothersName');
            $table->string('mobile');
            $table->string('nationality');
            $table->text('about_me');
            $table->text('address');
            $table->text('education');
            $table->text('employment');
//            $table->string('image')->nullable();
            $table->string('skills');
            $table->string('languages');
            $table->text('reference');
            $table->boolean('is_bonus')->default(0);
            $table->string('cv')->nullable();
            $table->string('branch_id')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
