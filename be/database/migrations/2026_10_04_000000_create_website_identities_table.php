<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Modul Website Identitas ala DBMSDA: satu baris identitas website
     * (nama, slogan, deskripsi, logo, favicon, kontak, sosmed, maps, footer).
     */
    public function up(): void
    {
        Schema::create('website_identities', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('nama_website', 255)->default('YogaRoots');
            $table->string('slogan', 255)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('logo', 255)->nullable();
            $table->string('favicon', 255)->nullable();
            $table->text('alamat')->nullable();
            $table->string('telepon', 50)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('jam_layanan', 255)->nullable();
            $table->string('facebook', 255)->nullable();
            $table->string('instagram', 255)->nullable();
            $table->string('twitter', 255)->nullable();
            $table->string('youtube', 255)->nullable();
            $table->string('tiktok', 255)->nullable();
            $table->text('maps_embed')->nullable();
            $table->string('footer_text', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_identities');
    }
};
