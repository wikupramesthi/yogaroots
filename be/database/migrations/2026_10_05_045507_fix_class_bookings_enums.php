<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE class_bookings MODIFY booking_type ENUM('package','membership','direct') NOT NULL");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE class_bookings MODIFY status ENUM('booked','confirmed','waiting_list','attended','cancelled','no_show') NOT NULL DEFAULT 'booked'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE class_bookings MODIFY booking_type ENUM('membership','direct') NOT NULL");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE class_bookings MODIFY status ENUM('booked','attended','cancelled','no_show') NOT NULL DEFAULT 'booked'");
    }
};
