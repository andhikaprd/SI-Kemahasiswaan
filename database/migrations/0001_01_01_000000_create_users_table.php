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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // --- KOLOM TAMBAHAN ---
            $table->enum('role', ['admin', 'kaprodi', 'mahasiswa'])->default('mahasiswa');
            $table->enum('status', ['aktif', 'tidak aktif'])->default('aktif');
            $table->string('nim')->nullable()->unique(); // NIM unik jika diisi
            $table->string('jurusan')->nullable();
            $table->string('angkatan')->nullable();
            // ---------------------

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
