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
        Schema::table('users', function (Blueprint $table) {

            // Paket yang sedang dimiliki user
            $table->uuid('package_uuid')
                ->nullable();

            // Periode membership
            $table->date('membership_start_date')
                ->nullable();

            $table->date('membership_end_date')
                ->nullable();

            // NULL = unlimited
            $table->unsignedInteger('total_quota')
                ->nullable();

            // NULL = unlimited
            $table->unsignedInteger('remaining_quota')
                ->nullable();

            $table->enum('membership_status', [
                'active',
                'expired',
                'cancelled',
            ])->nullable();

            $table->foreign('package_uuid')
                ->references('uuid')
                ->on('packages')
                ->nullOnDelete();

            $table->index('package_uuid');
            $table->index('membership_status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign([
                'package_uuid'
            ]);

            $table->dropColumn([
                'package_uuid',
                'membership_start_date',
                'membership_end_date',
                'total_quota',
                'remaining_quota',
                'membership_status',
            ]);
        });
    }
};
