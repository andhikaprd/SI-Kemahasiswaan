<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('decision_weights', function (Blueprint $table) {
            $table->id();
            $table->string('context'); // contoh: 'prestasi_mahasiswa'
            $table->string('method')->default('AHP');
            $table->unsignedInteger('tahun')->nullable();
            $table->json('matrix');   // matriks AHP 4x4 (flatten atau nested)
            $table->json('weights');  // bobot hasil, array [ipk, tingkat, juara, english]
            $table->float('lambda_max')->nullable();
            $table->float('ci')->nullable();
            $table->float('cr')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('decision_weights');
    }
};

