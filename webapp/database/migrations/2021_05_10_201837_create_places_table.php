<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('image_path', 50)->nullable();
            $table->string('address', 255);
            $table->double('location_lat', 8, 6)->nullable();
            $table->double('location_lng', 8, 6)->nullable();
            $table->integer('display_order');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->integer('city_id');
            $table->boolean('open')->default(true);
            $table->boolean('accept_reservations')->default(true);
            $table->timestamp('close_until')->nullable();
            $table->boolean('show')->default(true);
            $table->boolean('published')->default(true);
            $table->boolean('deleted')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('places');
    }
}
