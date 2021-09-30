<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBookingChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_chats', function (Blueprint $table) {
            $table->integer('table_id')->nullable()->after('place_id');
        });

        Schema::table('booking_notifications', function (Blueprint $table) {
            $table->integer('table_id')->nullable()->after('place_id');
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
