<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Avatar opsional (view selalu fallback ke gambar default).
     * Sebelumnya NOT NULL tanpa default sehingga register tanpa avatar
     * gagal di MySQL strict.
     */
    public function up(): void
    {
        if (Schema::hasColumn('users', 'avatar')) {
            // Tanpa doctrine/dbal: pakai MODIFY langsung (MySQL only, sama
            // seperti migrasi lain di repo ini).
            DB::statement('ALTER TABLE users MODIFY avatar VARCHAR(255) NULL');
        }
    }

    public function down(): void
    {
        // Sengaja tidak dikembalikan.
    }
};
