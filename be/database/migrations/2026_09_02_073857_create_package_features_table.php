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
        Schema::create('package_features', function (Blueprint $table) {
            $table->uuid('uuid')->primary();

            $table->uuid('package_uuid');

            $table->string('feature');

            $table->unsignedInteger('sort_order')->default(0);

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
        Schema::dropIfExists('package_features');
    }
};
