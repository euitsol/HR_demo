<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicantsTable extends Migration
{

    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('is_shortlisted')->default(0)->index();
//            $table->integer('notice_id');
//            $table->integer('job_id');
            $table->string('email')->unique()->index();
            $table->string('password')->index();
            $table->string('name');
            $table->string('dob');
            $table->string('FathersName')->nullable();
            $table->string('MothersName')->nullable();
            $table->string('mobile')->nullable();
            $table->string('nationality')->nullable();
            $table->text('about_me')->nullable();
            $table->text('address')->nullable();
            $table->text('education')->nullable();
            $table->text('employment')->nullable();
            $table->string('image')->nullable();
            $table->string('skills')->nullable();
            $table->string('languages')->nullable();
            $table->text('reference')->nullable();
            $table->string('cv')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('applicants');
    }
}
