<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['nama' => 'Muhammad Rafly Kesuma', 'nim' => '2201301117', 'email' => 'muhammad.rafly@mhs.politala.ac.id', 'angkatan' => '2022'],
            ['nama' => 'Gazali Akbar', 'nim' => '2101301038', 'email' => 'gazali.akbar@mhs.politala.ac.id', 'angkatan' => '2021'],
            ['nama' => 'Hadi Putra', 'nim' => '2201301195', 'email' => 'hadi.putra@mhs.politala.ac.id', 'angkatan' => '2022'],
            ['nama' => 'Adji Tama', 'nim' => '2201301173', 'email' => 'adji.tama@mhs.politala.ac.id', 'angkatan' => '2022'],
            ['nama' => 'Andika Bagus', 'nim' => '2201301175', 'email' => 'andika.bagus@mhs.politala.ac.id', 'angkatan' => '2022'],
            ['nama' => 'Latief Naupal Sidik', 'nim' => '2201301126', 'email' => 'latief.naupal@mhs.politala.ac.id', 'angkatan' => '2022'],
            ['nama' => 'Syahril Fahmi', 'nim' => '2001301072', 'email' => 'syahril.fahmi@mhs.politala.ac.id', 'angkatan' => '2020'],
            ['nama' => 'Nimas Diva Prameswari', 'nim' => '2001301152', 'email' => 'nimas.diva@mhs.politala.ac.id', 'angkatan' => '2020'],
            ['nama' => "Rahmah Sa'adah", 'nim' => '1901301099', 'email' => "rahmah.sa'adah@mhs.politala.ac.id", 'angkatan' => '2019'],
            ['nama' => 'Siti Nurhaliza', 'nim' => '2001301057', 'email' => 'siti.nurhaliza@mhs.politala.ac.id', 'angkatan' => '2020'],
            ['nama' => 'Muhammad Rawildhan', 'nim' => '1801301088', 'email' => 'muhammad.rawildhan@mhs.politala.ac.id', 'angkatan' => '2018'],
            ['nama' => 'Luthfi Adzhari', 'nim' => '2101301091', 'email' => 'luthfi.adzhari@mhs.politala.ac.id', 'angkatan' => '2021'],
            ['nama' => 'Noor Ridwansyah', 'nim' => '2101301014', 'email' => 'noor.ridwansyah@mhs.politala.ac.id', 'angkatan' => '2021'],
            ['nama' => 'Miranda Arditha', 'nim' => '2101301034', 'email' => 'miranda.arditha@mhs.politala.ac.id', 'angkatan' => '2021'],
            ['nama' => 'Ahmad Nasrullah Yusuf', 'nim' => '1901301007', 'email' => 'ahmad.nasrullah.yusuf@mhs.politala.ac.id', 'angkatan' => '2019'],
        ];

        foreach ($items as $it) {
            Mahasiswa::firstOrCreate(['nim' => $it['nim']], $it);
        }
    }
}
