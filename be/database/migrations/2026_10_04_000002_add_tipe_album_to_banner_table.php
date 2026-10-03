<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Media Library ala DBMSDA: foto, video (link YouTube/Vimeo) & album.
     */
    public function up(): void
    {
        Schema::table('banner', function (Blueprint $table) {
            $table->enum('tipe', ['foto', 'video', 'album'])->default('foto')->after('uuid');
            $table->string('album_uuid', 36)->nullable()->after('tipe');
        });
    }

    public function down(): void
    {
        Schema::table('banner', function (Blueprint $table) {
            $table->dropColumn(['tipe', 'album_uuid']);
        });
    }
};
