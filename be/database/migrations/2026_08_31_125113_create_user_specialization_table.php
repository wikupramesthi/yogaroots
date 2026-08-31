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
        Schema::create('user_specialization', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('user_uuid');
            $table->uuid('specialization_uuid');
            $table->foreign('user_uuid')->references('uuid')->on('users')->cascadeOnDelete();
            $table->foreign('specialization_uuid')->references('uuid')->on('specializations')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_uuid', 'specialization_uuid',]);
        });
    }
    /** * Reverse the migrations. */ public function down(): void
    {
        Schema::dropIfExists('user_specialization');
    }
};
