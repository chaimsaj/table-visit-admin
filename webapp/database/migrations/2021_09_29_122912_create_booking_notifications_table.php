<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_notifications', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->string('notification_text', 750)->nullable();
            $table->integer('notification_type');
            $table->string('external_name', 500)->nullable();
            $table->string('external_code', 250)->nullable();
            $table->integer('notification_status');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->integer('booking_id')->nullable();
            $table->integer('place_id')->nullable();
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
        Schema::dropIfExists('booking_notifications');
    }
}
