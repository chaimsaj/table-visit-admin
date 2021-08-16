<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('detail', 500)->nullable()->after("name");
            $table->decimal('fee_markup', 8, 2)->nullable()->after("tenant_uuid");
            $table->decimal('additional_markup', 8, 2)->nullable()->after("fee_markup");
            $table->integer('admin_user_id')->nullable()->after("additional_markup");
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
