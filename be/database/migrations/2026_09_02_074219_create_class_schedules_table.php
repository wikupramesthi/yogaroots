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
        Schema::create('class_schedules', function (Blueprint $table) {
            $table->uuid('uuid')->primary();

            $table->uuid('class_uuid');

            $table->date('date');

            $table->time('start_time');
            $table->time('end_time')->nullable();

            // Kapasitas peserta
            $table->unsignedInteger('capacity')->default(10);

            $table->enum('status', [
                'scheduled',
                'ongoing',
                'completed',
                'cancelled',
            ])->default('scheduled');

            $table->timestamps();

            $table->foreign('class_uuid')
                ->references('uuid')
                ->on('classes')
                ->cascadeOnDelete();

            $table->index([
                'class_uuid',
                'date',
            ]);

            $table->index([
                'date',
                'status',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_schedules');
    }
};
