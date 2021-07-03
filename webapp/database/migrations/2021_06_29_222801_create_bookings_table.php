<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50);
            $table->decimal('total_amount', 8, 2);
            $table->integer('guests_count');
            $table->timestamp('date');
            $table->string('comment', 750);
            $table->integer('booking_status');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->timestamp('canceled_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->integer('user_id');
            $table->integer('place_id');
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
        Schema::dropIfExists('bookings');
    }
}
