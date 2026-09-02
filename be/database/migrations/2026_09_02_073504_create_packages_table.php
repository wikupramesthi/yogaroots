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
        Schema::create('packages', function (Blueprint $table) {
            $table->uuid('uuid')->primary();

            $table->string('name');
            $table->string('slug')->unique();

            $table->text('description')->nullable();

            // Harga paket
            $table->decimal('price', 15, 2);

            // NULL = unlimited
            $table->unsignedInteger('quota')->nullable();

            // Contoh: 1 month
            $table->unsignedInteger('duration')->default(1);

            $table->enum('duration_unit', [
                'day',
                'week',
                'month',
                'year',
            ])->default('month');

            // Badge "PALING POPULER"
            $table->boolean('is_popular')->default(false);

            $table->enum('is_active', [
                'active',
                'inactive',
            ])->default('active');

            $table->timestamps();

            $table->index('is_active');
            $table->index('is_popular');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
