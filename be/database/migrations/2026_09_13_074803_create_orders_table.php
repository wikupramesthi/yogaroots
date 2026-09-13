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

            // Package purchase
            $table->uuid('package_uuid')->nullable();

            // Selected package option
            $table->uuid('package_option_uuid')->nullable();

            // Class purchase
            $table->uuid('class_schedule_uuid')->nullable();

            // Final amount charged
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

            /*
             * Foreign Keys
             */

            $table->foreign('user_uuid')
                ->references('uuid')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('package_uuid')
                ->references('uuid')
                ->on('packages')
                ->nullOnDelete();

            $table->foreign('package_option_uuid')
                ->references('uuid')
                ->on('package_options')
                ->nullOnDelete();

            $table->foreign('class_schedule_uuid')
                ->references('uuid')
                ->on('class_schedules')
                ->nullOnDelete();

            /*
             * Indexes
             */

            $table->index([
                'user_uuid',
                'status',
            ]);

            $table->index('package_uuid');
            $table->index('package_option_uuid');
            $table->index('class_schedule_uuid');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
