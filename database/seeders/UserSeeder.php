<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Pastikan Anda menggunakan model User

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Membuat Akun Admin
        User::create([
            'name' => 'Admin System',
            'email' => 'admin@himati.ac.id',
            'password' => Hash::make('password'), // passwordnya: "password"
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        // 2. Membuat Akun Kaprodi
        User::create([
            'name' => 'Nama Kaprodi',
            'email' => 'kaprodi@politala.ac.id',
            'password' => Hash::make('password'),
            'role' => 'kaprodi',
            'status' => 'aktif',
        ]);

        // 3. Membuat Akun Mahasiswa
        User::create([
            'name' => 'Mahasiswa Contoh',
            'email' => 'mahasiswa@mhs.politala.ac.id',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'status' => 'aktif',
            'nim' => '20210001',
            'jurusan' => 'Teknologi Informasi',
            'angkatan' => '2021',
        ]);
    }
}