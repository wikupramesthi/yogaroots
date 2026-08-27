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
        Schema::create('services', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('judul')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('icon')->nullable();
            $table->string('link')->nullable();
            $table->enum('color', [
                'blue',
                'orange',
                'green',
                'red',
                'yellow',
                'purple',
                'cyan',
                'pink',
                'teal',
                'brown'
            ])->nullable();
            $table->enum('kategori_layanan', ['ekstrakurikuler', 'kegiatan', 'bimbingan'])->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
