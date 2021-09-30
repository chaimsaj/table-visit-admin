<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_chats', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->string('chat_text', 750)->nullable();
            $table->integer('chat_type');
            $table->string('external_name', 500)->nullable();
            $table->string('external_code', 250)->nullable();
            $table->integer('chat_status');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->integer('booking_id');
            $table->integer('place_id');
            $table->integer('from_user_id')->nullable();
            $table->integer('to_user_id')->nullable();
            $table->boolean('published')->default(true);
            $table->boolean('deleted')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_chats');
    }
}
