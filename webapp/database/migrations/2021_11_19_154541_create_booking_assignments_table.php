<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_assignments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->integer('user_id');
            $table->integer('user_type_id');
            $table->integer('booking_id');
            $table->integer('table_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->softDeletes();
            $table->boolean('published')->default(true);
            $table->boolean('deleted')->default(false);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('assigned_to_user_id');
            $table->dropColumn('assigned_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_assignments');
    }
}
