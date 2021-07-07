<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_services', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50);
            $table->string('detail', 250);
            $table->decimal('amount', 8, 2);
            $table->decimal('tax_amount', 8, 2);
            $table->integer('count');
            $table->decimal('taxes_amount', 8, 2);
            $table->decimal('total_amount', 8, 2);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->timestamp('canceled_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->integer('service_rate_id');
            $table->integer('service_id');
            $table->integer('booking_table_id')->nullable();
            $table->integer('user_id');
            $table->integer('booking_id');
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
        Schema::dropIfExists('booking_services');
    }
}
