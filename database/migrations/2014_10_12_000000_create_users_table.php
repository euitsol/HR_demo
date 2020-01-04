<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('branch_id')->nullable()->index();
            $table->string('name');
            $table->string('email')->unique()->index();
            $table->integer('userinfo_id')->nullable();
//            $table->integer('employeeType_id')->nullable();
//            $table->integer('religion_id')->nullable();
            $table->integer('job_id')->nullable();
            $table->integer('userjobinfo_id')->nullable();
            $table->integer('userpay_id')->nullable();
//            $table->integer('leave_id')->nullable();
//            $table->integer('termination_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image')->nullable();
            $table->integer('fatal_warning')->default(0);
            $table->string('ip_address')->nullable();
            $table->integer('tag')->default(0)->index();
            $table->integer('kpiVoting')->default(0)->index();
            $table->rememberToken();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('users');
    }
}
