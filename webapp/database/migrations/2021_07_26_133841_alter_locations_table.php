<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->string('detail', 250)->after("id");
            $table->double('latitude', 12, 8)->nullable()->after("detail");
            $table->double('longitude', 12, 8)->nullable()->after("latitude");
            $table->integer('country_id')->nullable()->after("longitude");
            $table->integer('state_id')->nullable()->after("country_id");
            $table->integer('city_id')->nullable()->after("state_id");
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
