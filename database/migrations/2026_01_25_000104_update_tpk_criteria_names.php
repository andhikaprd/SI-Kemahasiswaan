<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('tpk_criteria')) {
            return;
        }

        // Update based on code if present
        DB::table('tpk_criteria')->where('code', 'C3')->update(['name' => 'Juara', 'type' => 'benefit']);
        DB::table('tpk_criteria')->where('code', 'C4')->update(['name' => 'Bahasa Inggris', 'type' => 'benefit']);

        // Fallback: update legacy names if codes differ
        DB::table('tpk_criteria')->where('name', 'Pengalaman Organisasi')->update(['name' => 'Juara', 'type' => 'benefit']);
        DB::table('tpk_criteria')->where('name', 'Prestasi & Lomba')->update(['name' => 'Bahasa Inggris', 'type' => 'benefit']);
    }

    public function down(): void
    {
        // no-op
    }
};
