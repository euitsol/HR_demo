<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicantNoticeTable extends Migration
{

    public function up()
    {
        Schema::create('applicant_notice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('applicant_id')->index();
            $table->integer('notice_id')->index();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('applicant_notice');
    }
}
