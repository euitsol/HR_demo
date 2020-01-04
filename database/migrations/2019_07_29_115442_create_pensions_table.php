<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePensionsTable extends Migration
{
    public function up()
    {
        Schema::create('pensions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('is_active')->default(1)->index();
            $table->integer('total_pay_months');
            $table->float('salary_percentage')->default(1);
            $table->boolean('is_gross_salary')->default(0)->index();
            $table->float('max_withdraw_percentage')->default(33.33);
            $table->float('per_month_withdraw_percentage');
            $table->boolean('is_both')->default(0)->index();
            // applicable only if is_both is 1
            $table->float('company_pay_percentage')->default(0);
            $table->integer('max_leave_per_type')->default(12);
            $table->float('pdwh')->default(9);
            $table->integer('wh')->default(2);
            $table->boolean('st_is_over')->default(1);
            $table->boolean('tax_is_gross')->default(1);
            $table->boolean('max_tax')->default(30);
            $table->boolean('default_tax')->default(10);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pensions');
    }
}
