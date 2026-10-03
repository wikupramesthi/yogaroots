<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Samakan struktur dengan halaman Identitas Website DBMSDA:
     * informasi umum, kontak & sosmed, SEO & meta, branding (logo, favicon, og).
     * Tabel sebelumnya baru dibuat dan belum ada data produksi, jadi aman di-rebuild.
     */
    public function up(): void
    {
        Schema::dropIfExists('website_identities');

        Schema::create('website_identities', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            // Informasi Umum
            $table->string('site_name', 255)->default('YogaRoots');
            $table->string('site_title', 255)->nullable();
            $table->string('tagline', 255)->nullable();
            $table->text('short_description')->nullable();
            // Kontak & Sosial Media
            $table->string('email', 255)->nullable();
            $table->string('phone', 50)->nullable();
            $table->text('address')->nullable();
            $table->string('facebook_url', 255)->nullable();
            $table->string('instagram_url', 255)->nullable();
            $table->string('youtube_url', 255)->nullable();
            $table->string('tiktok_url', 255)->nullable();
            // SEO & Meta
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('google_analytics_id', 50)->nullable();
            $table->string('google_site_verification', 255)->nullable();
            // Branding
            $table->string('logo', 255)->nullable();
            $table->string('favicon', 255)->nullable();
            $table->string('og_image', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_identities');
    }
};
