<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBookingsTableGratuity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('gratuity_amount', 8, 2)->nullable()->after("total_amount");
            $table->decimal('spent_amount', 8, 2)->nullable()->after("gratuity_amount");
            $table->integer('payment_method')->nullable()->after("booking_status");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
