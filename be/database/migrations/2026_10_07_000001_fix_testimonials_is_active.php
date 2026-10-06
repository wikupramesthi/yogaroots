<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom dipakai sebagai string 'active'/'inactive' di validasi &
     * query, tapi dibuat boolean default 'active' (gagal di MySQL strict
     * dan menyimpan 0 di database lama). Samakan jadi VARCHAR.
     */
    public function up(): void
    {
        if (Schema::hasColumn('testimonials', 'is_active')) {
            DB::statement("ALTER TABLE testimonials MODIFY is_active VARCHAR(20) NOT NULL DEFAULT 'active'");
            DB::table('testimonials')->where('is_active', '0')->update(['is_active' => 'inactive']);
            DB::table('testimonials')->whereNotIn('is_active', ['active', 'inactive'])->update(['is_active' => 'active']);
        }
    }

    public function down(): void
    {
        // Sengaja tidak dikembalikan ke boolean yang rusak.
    }
};
