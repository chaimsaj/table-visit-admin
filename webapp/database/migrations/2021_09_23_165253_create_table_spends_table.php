<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSpendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_spends', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 8, 2);
            $table->decimal('tax_amount', 8, 2);
            $table->integer('quantity');
            $table->decimal('total_tax_amount', 8, 2);
            $table->decimal('total_amount', 8, 2);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->integer('user_id');
            $table->integer('service_id')->nullable();
            $table->integer('table_id');
            $table->integer('place_id');
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
        Schema::dropIfExists('table_spends');
    }
}
