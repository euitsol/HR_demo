<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalariesTable extends Migration
{
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('branch_id')->index();
            $table->integer('user_id')->index();
            $table->float('pay');
            $table->float('tax');
            $table->float('compensation');
            $table->float('benefit');
            $table->float('family_support');
            $table->float('bonus')->default(0);
            $table->float('loan')->default(0);
            $table->float('pf_user');
            $table->float('pf_company');
            $table->float('total_provident_fund');
            $table->float('pension_user')->default(0);
            $table->float('pension_company')->default(0);
            $table->float('total_pension')->default(0);
            $table->float('salary');
            $table->float('over_time_hour')->default(0);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('salaries');
    }
}
