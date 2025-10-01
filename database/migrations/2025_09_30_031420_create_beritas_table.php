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
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('ringkasan', 500);
            $table->text('isi');
            $table->string('kategori');
            $table->enum('status', ['published', 'draft'])->default('draft');
            $table->string('penulis');
            $table->date('tanggal_publikasi');
            $table->string('gambar')->nullable();
            $table->string('tags')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
