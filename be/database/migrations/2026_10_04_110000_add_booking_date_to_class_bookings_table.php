<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Recurring schedules need a concrete date per booking,
     * otherwise capacity would fill up permanently after the
     * first week.
     */
    public function up(): void
    {
        Schema::table('class_bookings', function (Blueprint $table) {
            $table->date('booking_date')->after('class_schedule_uuid');
            $table->index(['class_schedule_uuid', 'booking_date'], 'bookings_schedule_date_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('class_bookings', function (Blueprint $table) {
            $table->dropIndex('bookings_schedule_date_idx');
            $table->dropColumn('booking_date');
        });
    }
};
