<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Tambahkan opsi status_peringatan agar mencakup sanksi berat (DO).
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE masalah_mahasiswa
            MODIFY status_peringatan ENUM(
                'Peringatan 1',
                'Peringatan 2',
                'Peringatan 3',
                'Skorsing',
                'Pemberhentian (DO)'
            ) DEFAULT 'Peringatan 1'
        ");
    }

    /**
     * Kembalikan ke enum awal (tanpa DO).
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE masalah_mahasiswa
            MODIFY status_peringatan ENUM(
                'Peringatan 1',
                'Peringatan 2',
                'Peringatan 3',
                'Skorsing'
            ) DEFAULT 'Peringatan 1'
        ");
    }
};
