<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prestasi_mahasiswa', function (Blueprint $table) {
            // Izinkan banyak prestasi per mahasiswa dengan menghapus constraint unik NIM bila ada
            $hasUnique = collect(DB::select("SHOW INDEX FROM prestasi_mahasiswa WHERE Key_name = 'prestasi_mahasiswa_nim_unique'"))->isNotEmpty();
            if ($hasUnique) {
                $table->dropUnique('prestasi_mahasiswa_nim_unique');
            }

            $hasIndex = collect(DB::select("SHOW INDEX FROM prestasi_mahasiswa WHERE Column_name = 'nim' AND Non_unique = 1"))->isNotEmpty();
            if (! $hasIndex) {
                $table->index('nim');
            }
        });
    }

    public function down(): void
    {
        Schema::table('prestasi_mahasiswa', function (Blueprint $table) {
            $hasIndex = collect(DB::select("SHOW INDEX FROM prestasi_mahasiswa WHERE Column_name = 'nim' AND Non_unique = 1"))->isNotEmpty();
            if ($hasIndex) {
                $table->dropIndex(['nim']);
            }
            $hasUnique = collect(DB::select("SHOW INDEX FROM prestasi_mahasiswa WHERE Key_name = 'prestasi_mahasiswa_nim_unique'"))->isNotEmpty();
            if (! $hasUnique) {
                $table->unique('nim', 'prestasi_mahasiswa_nim_unique');
            }
        });
    }
};
