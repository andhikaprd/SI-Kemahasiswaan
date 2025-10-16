<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel 'beritas'
     */
    public function up(): void
    {
        // Hindari duplikasi tabel jika migrate dijalankan dua kali
        if (!Schema::hasTable('beritas')) {
            Schema::create('beritas', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->string('slug')->unique();
                $table->string('ringkasan', 500)->nullable(); // boleh kosong
                $table->text('isi');
                $table->string('kategori')->nullable();
                $table->enum('status', ['published', 'draft'])->default('draft');
                $table->string('penulis')->nullable();
                $table->date('tanggal_publikasi')->nullable();
                $table->string('gambar')->nullable();
                $table->string('tags')->nullable();
                $table->unsignedBigInteger('views')->default(0);
                $table->timestamps(); // Kolom created_at & updated_at
            });
        }
    }

    /**
     * Hapus tabel 'beritas' jika rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
