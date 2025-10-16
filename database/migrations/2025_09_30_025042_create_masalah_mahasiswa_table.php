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
        Schema::create('masalah_mahasiswa', function (Blueprint $table) {
            $table->id();
            // relasi ke tabel mahasiswa
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();

            // detail masalah
            $table->unsignedTinyInteger('semester')->nullable();
            $table->decimal('ipk', 3, 2)->nullable();
            $table->string('jenis_masalah'); // contoh: "IPK Rendah", "Absensi Rendah", "Pelanggaran Akademik"
            $table->enum('status_peringatan', [
                'Peringatan 1',
                'Peringatan 2',
                'Peringatan 3',
                'Skorsing'
            ])->default('Peringatan 1');
            $table->date('laporan_terakhir')->nullable();
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masalah_mahasiswa');
    }
};
