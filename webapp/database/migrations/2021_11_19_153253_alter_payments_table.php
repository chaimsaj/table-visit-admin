<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('paid_amount', 8, 2)->nullable()->after("spent_amount");
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->decimal('amount', 8, 2)->after("id");
            $table->dateTime('date')->after("amount");
            $table->integer('payment_type')->after("date");
            $table->integer('payment_status')->after("payment_type");
            $table->integer('payment_method')->after("payment_status");
            $table->integer('booking_id')->after("place_id");
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
