<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerminationsTable extends Migration
{

    public function up()
    {
        Schema::create('terminations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reason');
            $table->string('document')->nullable();
            $table->string('name');
            $table->string('email');
            $table->date('dob')->nullable();
            $table->text('address')->nullable();
            $table->string('mobile')->nullable();
            $table->string('job_title')->nullable();
            $table->float('loan_due')->default(0);
            // total Provident Fund from salary table
            $table->float('pf')->default(0);
            $table->float('due_pf')->default(0);
            // total Pension from salary table
            $table->float('pension')->default(0);
            $table->float('pension_per_month')->default(0);
            $table->float('due_pension')->default(0);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('terminations');
    }
}
