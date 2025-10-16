<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();

            // Relasi
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            $table->foreignId('mata_kuliah_id')->constrained('mata_kuliahs')->cascadeOnDelete();

            // Informasi laporan
            $table->string('judul');
            $table->string('kategori')->nullable(); // misal: Seminar, Proyek, Praktikum
            $table->text('deskripsi')->nullable();
            $table->timestamp('tanggal_submit')->useCurrent();

            // Status dan verifikasi
            $table->enum('status', ['pending', 'approved', 'revisi'])->default('pending');
            $table->text('catatan_revisi')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();

            // File upload
            $table->string('file_path')->nullable();
            $table->string('file_mime')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
