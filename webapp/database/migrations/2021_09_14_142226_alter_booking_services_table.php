<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBookingServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_services', function (Blueprint $table) {
            $table->dropColumn('amount');
            $table->dropColumn('tax_amount');
            $table->dropColumn('taxes_amount');
            $table->dropColumn('total_amount');

            $table->decimal('rate', 8, 2)->after("id");
            $table->decimal('tax', 8, 2)->after("rate");
            $table->decimal('total_rate', 8, 2)->after("tax");
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
