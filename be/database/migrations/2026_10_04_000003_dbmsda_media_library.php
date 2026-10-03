<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Media Library ala DBMSDA: tabel albums + pivot album_foto + video_url.
     * Menggantikan kolom album_uuid tunggal (tidak ada data produksi).
     */
    public function up(): void
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('nama', 255);
            $table->text('deskripsi')->nullable();
            $table->uuid('cover')->nullable()->index();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('album_foto', function (Blueprint $table) {
            $table->uuid('album_uuid');
            $table->uuid('banner_uuid');
            $table->timestamps();

            $table->primary(['album_uuid', 'banner_uuid']);
            $table->index('banner_uuid');
        });

        Schema::table('banner', function (Blueprint $table) {
            $table->string('video_url', 500)->nullable()->after('tipe');
            $table->dropColumn('album_uuid');
        });
    }

    public function down(): void
    {
        Schema::table('banner', function (Blueprint $table) {
            $table->dropColumn('video_url');
            $table->string('album_uuid', 36)->nullable()->after('tipe');
        });

        Schema::dropIfExists('album_foto');
        Schema::dropIfExists('albums');
    }
};
