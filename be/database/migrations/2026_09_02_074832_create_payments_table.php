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
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('uuid')->primary();

            $table->uuid('order_uuid');

            $table->string('payment_gateway')
                ->default('midtrans');

            $table->string('transaction_id')
                ->nullable();

            $table->string('payment_type')
                ->nullable();

            $table->decimal('gross_amount', 15, 2);

            $table->string('status')
                ->default('pending');

            $table->timestamp('paid_at')
                ->nullable();

            // Response dari Midtrans
            $table->json('raw_response')
                ->nullable();

            $table->timestamps();

            $table->foreign('order_uuid')
                ->references('uuid')
                ->on('orders')
                ->cascadeOnDelete();

            $table->index('transaction_id');

            $table->index([
                'order_uuid',
                'status',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
