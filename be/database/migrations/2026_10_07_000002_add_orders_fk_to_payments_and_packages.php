<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * FK ke tabel orders untuk payments & user_packages. Dipisah ke sini
     * karena tabel orders baru dibuat di migrasi 2026_09_13 (sesudah
     * kedua tabel ini), sehingga create dengan FK langsung gagal di
     * database fresh. Idempotent untuk database lama.
     */
    public function up(): void
    {
        if ($this->missingFk('payments', 'payments_order_uuid_foreign')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->foreign('order_uuid', 'payments_order_uuid_foreign')
                    ->references('uuid')
                    ->on('orders')
                    ->cascadeOnDelete();
            });
        }

        if ($this->missingFk('user_packages', 'user_packages_order_uuid_foreign')) {
            Schema::table('user_packages', function (Blueprint $table) {
                $table->foreign('order_uuid', 'user_packages_order_uuid_foreign')
                    ->references('uuid')
                    ->on('orders')
                    ->nullOnDelete();
            });
        }

        if ($this->missingFk('class_bookings', 'class_bookings_order_uuid_foreign')) {
            Schema::table('class_bookings', function (Blueprint $table) {
                $table->foreign('order_uuid', 'class_bookings_order_uuid_foreign')
                    ->references('uuid')
                    ->on('orders')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign('payments_order_uuid_foreign');
        });
        Schema::table('user_packages', function (Blueprint $table) {
            $table->dropForeign('user_packages_order_uuid_foreign');
        });
        Schema::table('class_bookings', function (Blueprint $table) {
            $table->dropForeign('class_bookings_order_uuid_foreign');
        });
    }

    private function missingFk(string $table, string $constraint): bool
    {
        $db = DB::getDatabaseName();

        return DB::table('information_schema.table_constraints')
            ->where('constraint_schema', $db)
            ->where('table_name', $table)
            ->where('constraint_name', $constraint)
            ->doesntExist();
    }
};
