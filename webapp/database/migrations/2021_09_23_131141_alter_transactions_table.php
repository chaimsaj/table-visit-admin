<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('transaction_amount', 8, 2)->nullable()->after("transaction_status");
            $table->decimal('commission_amount', 8, 2)->nullable()->after("transaction_amount");
            $table->decimal('commission_percentage', 8, 2)->nullable()->after("commission_amount");
            $table->integer('commission_id')->nullable()->after("commission_percentage");
            $table->decimal('fee_amount', 8, 2)->nullable()->after("commission_id");
            $table->decimal('fee_percentage', 8, 2)->nullable()->after("fee_amount");
            $table->integer('fee_id')->nullable()->after("fee_percentage");
            $table->softDeletes()->after("approved_at");
            $table->integer('place_id')->nullable()->after("user_id");
            $table->integer('table_id')->nullable()->after("place_id");
            $table->integer('booking_id')->nullable()->after("table_id");
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
