<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kode ini membuat tabel MAHASISWA BERPRESTASI
        Schema::create('mahasiswa_berprestasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mahasiswa');
            $table->string('nim');
            $table->string('jurusan');
            $table->year('angkatan');
            $table->string('jenis_prestasi');
            $table->string('tingkat');
            $table->string('nama_kompetisi');
            $table->string('peringkat');
            $table->year('tahun');
            $table->string('penyelenggara');
            $table->date('tanggal_perolehan');
            $table->integer('poin_prestasi');
            $table->string('status_sertifikat');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswa_berprestasis');
    }
};