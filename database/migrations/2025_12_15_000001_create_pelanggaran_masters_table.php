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
        Schema::create('pelanggaran_masters', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            // kategori: ringan, sedang, berat
            $table->string('kategori')->index();
            $table->text('deskripsi')->nullable();
            // sanksi default yang disarankan (opsional)
            $table->string('sanksi_default')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggaran_masters');
    }
};
