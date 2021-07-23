<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->string('currency_code', 3)->nullable()->after("iso_code");
            $table->string('iso_numeric', 4)->nullable()->after("currency_code");
            $table->double('north', 20, 14)->nullable()->after("iso_numeric");
            $table->double('south', 20, 14)->nullable()->after("north");
            $table->double('east', 20, 14)->nullable()->after("south");
            $table->double('west', 20, 14)->nullable()->after("east");
            $table->string('capital_name', 150)->nullable()->after("west");
            $table->string('continent_name', 150)->nullable()->after("capital_name");
            $table->string('continent_code', 2)->nullable()->after("continent_name");
            $table->string('iso_alpha', 3)->nullable()->after("continent_code");
            $table->integer('geo_name_id')->nullable()->after("iso_alpha");
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
