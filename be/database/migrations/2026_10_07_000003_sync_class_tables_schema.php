<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menyelaraskan skema dengan kode: kolom-kolom ini dipakai aplikasi
     * tapi tidak pernah ada migrasinya (diubah langsung di database).
     * Idempotent: aman untuk database lama maupun fresh install.
     */
    public function up(): void
    {
        // ---- classes: level, duration, image ----
        if (! Schema::hasColumn('classes', 'level')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->string('level', 50)->nullable()->after('quota_cost');
            });
        }
        if (! Schema::hasColumn('classes', 'duration')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->unsignedInteger('duration')->nullable()->after('level');
            });
        }
        if (! Schema::hasColumn('classes', 'image')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->string('image')->nullable()->after('instructor_uuid');
            });
        }

        // ---- class_schedules: day, studio_uuid ----
        if (! Schema::hasColumn('class_schedules', 'day')) {
            Schema::table('class_schedules', function (Blueprint $table) {
                $table->string('day', 20)->nullable()->after('class_uuid');
            });

            // Backfill dari kolom date lama (Senin..Minggu).
            if (Schema::hasColumn('class_schedules', 'date')) {
                DB::statement("UPDATE class_schedules SET day = LOWER(DAYNAME(date)) WHERE day IS NULL AND date IS NOT NULL");
            }
        }
        if (! Schema::hasColumn('class_schedules', 'studio_uuid')) {
            Schema::table('class_schedules', function (Blueprint $table) {
                $table->uuid('studio_uuid')->nullable()->after('class_uuid');
            });
        }

        // ---- class_schedules.date: legacy tak dipakai kode (jadwal mingguan
        // pakai day), tapi NOT NULL tanpa default sehingga create gagal di
        // MySQL strict. Buat nullable; data lama dipertahankan.
        if (Schema::hasColumn('class_schedules', 'date')) {
            DB::statement('ALTER TABLE class_schedules MODIFY `date` DATE NULL');
        }

        // ---- class_schedules.status: samakan ke active/inactive ----
        $type = DB::selectOne(
            "SELECT COLUMN_TYPE AS t FROM information_schema.columns
             WHERE table_schema = ? AND table_name = 'class_schedules' AND column_name = 'status'",
            [DB::getDatabaseName()]
        )?->t ?? '';

        if (! str_contains($type, "'active'")) {
            DB::statement("UPDATE class_schedules SET status = 'active' WHERE status IN ('scheduled', 'ongoing')");
            DB::statement("UPDATE class_schedules SET status = 'inactive' WHERE status IN ('completed', 'cancelled')");
            DB::statement("ALTER TABLE class_schedules MODIFY status ENUM('active','inactive') NOT NULL DEFAULT 'active'");
        }

        if (! $this->hasIndex('class_schedules', 'class_schedules_day_status_index')) {
            Schema::table('class_schedules', function (Blueprint $table) {
                $table->index(['day', 'status']);
            });
        }

        // ---- packages.price: legacy tak dipakai kode (harga ikut options).
        // Di sebagian database kolomnya tidak ada sama sekali; di yang lain
        // NOT NULL tanpa default sehingga create gagal di MySQL strict.
        if (! Schema::hasColumn('packages', 'price')) {
            Schema::table('packages', function (Blueprint $table) {
                $table->decimal('price', 15, 2)->nullable()->default(0);
            });
        } else {
            $priceNull = DB::selectOne(
                "SELECT IS_NULLABLE AS n FROM information_schema.columns
                 WHERE table_schema = ? AND table_name = 'packages' AND column_name = 'price'",
                [DB::getDatabaseName()]
            )?->n ?? 'NO';

            if ($priceNull === 'NO') {
                DB::statement('ALTER TABLE packages MODIFY price DECIMAL(15,2) NULL DEFAULT 0');
            }
        }
    }

    public function down(): void
    {
        // Sengaja tidak di-rollback: kolom dipakai aplikasi.
    }

    private function hasIndex(string $table, string $index): bool
    {
        return DB::table('information_schema.statistics')
            ->where('table_schema', DB::getDatabaseName())
            ->where('table_name', $table)
            ->where('index_name', $index)
            ->exists();
    }
};
