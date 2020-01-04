<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserloansTable extends Migration
{

    public function up()
    {
        Schema::create('userloans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->index();
            $table->integer('loantype_id')->index();
            $table->boolean('is_paid')->default(0)->index();
            $table->float('total_amount');
            $table->float('due');
            $table->float('pay_per_month');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('userloans');
    }
}
