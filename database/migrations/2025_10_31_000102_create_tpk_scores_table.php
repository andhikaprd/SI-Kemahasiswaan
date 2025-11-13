<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tpk_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alternative_id')->constrained('tpk_alternatives')->cascadeOnDelete();
            $table->foreignId('criterion_id')->constrained('tpk_criteria')->cascadeOnDelete();
            $table->decimal('value', 14, 4)->default(0);
            $table->timestamps();
            $table->unique(['alternative_id','criterion_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tpk_scores');
    }
};

