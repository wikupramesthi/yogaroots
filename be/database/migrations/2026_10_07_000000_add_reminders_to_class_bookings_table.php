<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Penanda pengingat booking agar tidak terkirim dua kali.
     */
    public function up(): void
    {
        Schema::table('class_bookings', function (Blueprint $table) {
            $table->timestamp('reminded_24h_at')->nullable()->after('attended_at');
            $table->timestamp('reminded_2h_at')->nullable()->after('reminded_24h_at');
        });
    }

    public function down(): void
    {
        Schema::table('class_bookings', function (Blueprint $table) {
            $table->dropColumn(['reminded_24h_at', 'reminded_2h_at']);
        });
    }
};
