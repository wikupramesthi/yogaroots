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
        Schema::create('class_bookings', function (Blueprint $table) {
            $table->uuid('uuid')->primary();

            $table->uuid('user_uuid');

            $table->uuid('class_schedule_uuid');

            // Jika menggunakan membership
            $table->enum('booking_type', [
                'membership',
                'direct',
            ]);

            // Berapa quota yang digunakan
            $table->unsignedInteger('quota_used')->default(0);

            $table->enum('status', [
                'booked',
                'attended',
                'cancelled',
                'no_show',
            ])->default('booked');

            $table->timestamp('booked_at')->nullable();
            $table->timestamp('attended_at')->nullable();

            // Membership user pada saat booking
            $table->uuid('package_uuid')->nullable();

            // Order jika direct purchase
            $table->uuid('order_uuid')->nullable();

            $table->timestamps();

            $table->foreign('user_uuid')
                ->references('uuid')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('class_schedule_uuid')
                ->references('uuid')
                ->on('class_schedules')
                ->cascadeOnDelete();

            $table->foreign('package_uuid')
                ->references('uuid')
                ->on('packages')
                ->nullOnDelete();

            $table->foreign('order_uuid')
                ->references('uuid')
                ->on('orders')
                ->nullOnDelete();

            $table->index([
                'user_uuid',
                'status',
            ]);

            $table->index([
                'class_schedule_uuid',
                'status',
            ]);

            $table->index('package_uuid');
            $table->index('order_uuid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_bookings');
    }
};
