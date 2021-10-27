<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBookingsCloseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dateTime('assigned_at')->nullable()->after("approved_at");
            $table->dateTime('closed_at')->nullable()->after("assigned_at");
            $table->integer('assigned_to_user_id')->nullable()->after("tenant_id");
            $table->integer('closed_by_user_id')->nullable()->after("assigned_to_user_id");
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
