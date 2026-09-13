<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_options', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('package_uuid');
            $table->string('name');
            $table->unsignedInteger('quota');
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('discount_price')->nullable();
            $table->unsignedInteger('duration');
            $table->enum('duration_unit', [
                'day',
                'week',
                'month',
                'year',
            ]);

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreign('package_uuid')
                ->references('uuid')
                ->on('packages')
                ->cascadeOnDelete();

            $table->index('package_uuid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_options');
    }
};
