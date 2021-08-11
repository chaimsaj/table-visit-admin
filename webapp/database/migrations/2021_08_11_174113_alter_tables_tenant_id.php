<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablesTenantId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after("place_id");
        });

        Schema::table('featured_places', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after("place_id");
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after("updated_at");
        });

        Schema::table('place_features', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after("updated_at");
        });

        Schema::table('place_music', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after("updated_at");
        });

        Schema::table('places', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after("close_until");
        });

        Schema::table('place_types', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after("updated_at");
        });

        Schema::table('place_work_days', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after("place_id");
        });

        Schema::table('place_work_hours', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after("place_id");
        });

        Schema::table('policies', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after("place_id");
        });

        Schema::table('service_rates', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after("table_id");
        });

        Schema::table('services', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after("place_id");
        });

        Schema::table('service_types', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after("updated_at");
        });

        Schema::table('system_configurations', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after("updated_at");
        });

        Schema::table('table_rates', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after("place_id");
        });

        Schema::table('tables', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after("place_id");
        });

        Schema::table('table_types', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after("updated_at");
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after("user_id");
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after("place_id");
        });

        Schema::dropIfExists('user_to_places');
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
