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
        // 1) Admin
        User::updateOrCreate(
            ['email' => 'admin@himati.ac.id'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'), // password: "password"
                'role' => 'admin',
                'status' => 'aktif',
            ]
        );

        // 2) Kaprodi
        User::updateOrCreate(
            ['email' => 'kaprodi@politala.ac.id'],
            [
                'name' => 'Nama Kaprodi',
                'password' => Hash::make('password'),
                'role' => 'kaprodi',
                'status' => 'aktif',
            ]
        );

        // 3) Mahasiswa contoh
        User::updateOrCreate(
            ['email' => 'mahasiswa@mhs.politala.ac.id'],
            [
                'name' => 'Mahasiswa Contoh',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
                'status' => 'aktif',
                'nim' => '20210001',
                'jurusan' => 'Teknologi Informasi',
                'angkatan' => '2021',
            ]
        );
    }
}
