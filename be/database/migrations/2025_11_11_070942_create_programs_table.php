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
        Schema::create('programs', function (Blueprint $table) {
           $table->uuid('uuid')->primary();

            // I. Biodata Calon Murid
            $table->string('nama_anak');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']); // Laki-laki / Perempuan
            $table->string('agama');
            $table->integer('anak_ke');
            $table->integer('jumlah_saudara')->nullable();

            // II. Biodata Orang Tua / Wali
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('agama_orang_tua'); 
            $table->text('alamat');
            $table->string('no_hp');

            // Relasi (opsional) ke kategori disabilitas
            $table->uuid('disability_uuid')->nullable();
            $table->foreign('disability_uuid')->references('uuid')->on('disabilities')->onDelete('set null');

            // Status pendaftaran
            $table->enum('status', ['pending', 'hadir', 'reschedule', 'diterima', 'ditolak'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
