<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder pengguna agar ada admin, kaprodi, dan mahasiswa default
        // Jalankan seeder yang idempotent terlebih dahulu
        $this->call([
            MahasiswaSeeder::class,
        ]);
    }
}
