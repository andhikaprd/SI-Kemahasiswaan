<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi: membuat tabel 'mahasiswas'
     */
    public function up(): void
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nim')->unique();
            $table->string('email')->nullable();
            $table->string('angkatan')->nullable();
            $table->unsignedBigInteger('prodi_id')->nullable(); // gunakan tipe foreign key-friendly
            $table->timestamps();
        });
    }

    /**
     * Membatalkan migrasi: hapus tabel 'mahasiswas'
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};

