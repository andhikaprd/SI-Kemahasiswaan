<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tpk_pairwise', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criterion_id_a')->constrained('tpk_criteria')->cascadeOnDelete();
            $table->foreignId('criterion_id_b')->constrained('tpk_criteria')->cascadeOnDelete();
            $table->decimal('value', 10, 6)->default(1);
            $table->timestamps();
            $table->unique(['criterion_id_a', 'criterion_id_b']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tpk_pairwise');
    }
};
