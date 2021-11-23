<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBookingGratuityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('spent_tax', 8, 2)->nullable()->after("spent_amount");
            $table->decimal('spent_gratuity', 8, 2)->nullable()->after("spent_tax");
            $table->decimal('spent_total_amount', 8, 2)->nullable()->after("spent_gratuity");
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
