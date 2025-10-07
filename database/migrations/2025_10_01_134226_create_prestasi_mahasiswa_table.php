<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestasi_mahasiswa', function (Blueprint $table) {
            $table->id();

            // Kolom utama
            $table->string('nama');             // nama mahasiswa
            $table->string('nim')->nullable();
            $table->string('jurusan');
            $table->string('angkatan')->nullable();

            // Detail kompetisi
            $table->string('kompetisi');
            $table->string('jenis')->nullable();
            $table->string('tingkat')->nullable();
            $table->string('peringkat')->nullable();

            // Informasi nilai / hasil
            $table->integer('poin')->nullable();
            $table->string('penyelenggara')->nullable();

            // Waktu kegiatan
            $table->date('tanggal')->nullable();
            $table->integer('tahun')->nullable();

            // Status publikasi & file
            $table->string('status')->default('draft');
            $table->string('sertifikat_path')->nullable();
            $table->string('foto_path')->nullable();

            // Tambahan
            $table->string('slug')->nullable();
            $table->text('deskripsi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasi_mahasiswa');
    }
};
