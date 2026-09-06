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
        Schema::create('user_packages', function (Blueprint $table) {
            $table->uuid('uuid')->primary();

            // User yang memiliki package
            $table->uuid('user_uuid');

            // Package yang dibeli
            $table->uuid('package_uuid');

            // Order yang menghasilkan membership ini
            $table->uuid('order_uuid')->nullable();

            // Sisa quota user
            // NULL = Unlimited
            $table->unsignedInteger('quota')->nullable();

            // Masa berlaku membership
            $table->timestamp('started_at')->nullable();
            $table->timestamp('expired_at')->nullable();

            $table->enum('status', [
                'active',
                'expired',
                'cancelled',
            ])->default('active');

            $table->timestamps();

            $table->foreign('user_uuid')
                ->references('uuid')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('package_uuid')
                ->references('uuid')
                ->on('packages')
                ->restrictOnDelete();

            $table->foreign('order_uuid')
                ->references('uuid')
                ->on('orders')
                ->nullOnDelete();

            $table->index([
                'user_uuid',
                'status',
            ]);

            $table->index('package_uuid');
            $table->index('order_uuid');
            $table->index('expired_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_packages');
    }
};
