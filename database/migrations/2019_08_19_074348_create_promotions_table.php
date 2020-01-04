<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreatePromotionsTable extends Migration
{

    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->integer('job_id');
            $table->float('pay')->nullable();
            $table->float('tax')->nullable();
            $table->float('compensation')->nullable();
            $table->float('benefit')->nullable();
            $table->string('benefit_detail')->nullable();
            $table->float('family_support')->nullable();
            $table->string('family_support_detail')->nullable();
            $table->longText('comment')->nullable();
            $table->unsignedInteger('changed_by');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('promotions');
    }
}