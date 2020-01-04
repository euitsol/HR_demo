<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreatePrivateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('private_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sender_id');
            $table->integer('receiver_id');
            $table->text('message_body');
            $table->string('file')->nullable();
            $table->string('status')->default('pending');
            $table->boolean('sent_item_delete')->default(0);
            $table->boolean('inbox_item_delete')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('private_messages');
    }
}