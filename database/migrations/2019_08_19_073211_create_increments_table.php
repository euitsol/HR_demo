<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateIncrementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('increments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('branch_id')->index();
            $table->unsignedInteger('user_id');
            $table->string('remark');
            $table->boolean('approveHR')->default(0);
            $table->boolean('approveCEO')->default(0);
            $table->decimal('increment_percent')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('increments');
    }
}