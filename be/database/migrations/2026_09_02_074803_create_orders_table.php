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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('uuid')->primary();

            $table->uuid('user_uuid');

            $table->string('order_number')->unique();

            $table->enum('type', [
                'package',
                'class',
            ]);

            // Jika membeli package
            $table->uuid('package_uuid')->nullable();

            // Jika membeli class
            $table->uuid('class_schedule_uuid')->nullable();

            $table->decimal('amount', 15, 2);

            $table->enum('status', [
                'pending',
                'paid',
                'failed',
                'expired',
                'cancelled',
            ])->default('pending');

            $table->timestamp('expired_at')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->foreign('user_uuid')
                ->references('uuid')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('package_uuid')
                ->references('uuid')
                ->on('packages')
                ->nullOnDelete();

            $table->foreign('class_schedule_uuid')
                ->references('uuid')
                ->on('class_schedules')
                ->nullOnDelete();

            $table->index([
                'user_uuid',
                'status',
            ]);

            $table->index('package_uuid');
            $table->index('class_schedule_uuid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
