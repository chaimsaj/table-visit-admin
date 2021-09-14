<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->integer('table_number')->nullable()->after("name");
            $table->string('table_code', 50)->nullable()->after("table_number");
        });

        Schema::table('booking_tables', function (Blueprint $table) {
            $table->dropColumn('code');
            $table->integer('table_number')->nullable()->after("id");
            $table->string('table_code', 50)->nullable()->after("table_number");
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
