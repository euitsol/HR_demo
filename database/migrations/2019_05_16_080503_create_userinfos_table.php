<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserinfosTable extends Migration
{

    public function up()
    {
        Schema::create('userinfos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
//            $table->string('name');
            $table->date('dob');
            $table->text('address');
            $table->string('mobile');
            $table->string('emergency_contract');
            $table->string('blood_group');
            $table->string('reference')->nullable();
//            $table->string('image')->nullable();
            $table->text('academic_skills');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('userinfos');
    }
}
