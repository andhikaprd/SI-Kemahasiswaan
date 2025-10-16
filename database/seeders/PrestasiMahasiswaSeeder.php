<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MahasiswaBerprestasi;
use Illuminate\Support\Carbon;

class PrestasiMahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'nama' => 'Aulia Rahman',
                'nim' => '2201301123',
                'jurusan' => 'Teknologi Informasi',
                'angkatan' => '2022',
                'kompetisi' => 'Lomba Web Design',
                'jenis' => 'Desain Web',
                'tingkat' => 'Nasional',
                'peringkat' => 'Juara 1',
                'poin' => 100,
                'penyelenggara' => 'Kemenpora',
                'tanggal' => Carbon::parse('2025-03-15'),
                'tahun' => 2025,
                'status' => 'published',
                'deskripsi' => 'Memenangkan lomba desain web tingkat nasional.',
            ],
            [
                'nama' => 'Siti Lestari',
                'nim' => '2101301056',
                'jurusan' => 'Teknologi Informasi',
                'angkatan' => '2021',
                'kompetisi' => 'Competitive Programming Contest',
                'jenis' => 'Pemrograman',
                'tingkat' => 'Provinsi',
                'peringkat' => 'Juara 2',
                'poin' => 85,
                'penyelenggara' => 'Pemprov Kalsel',
                'tanggal' => Carbon::parse('2024-11-20'),
                'tahun' => 2024,
                'status' => 'published',
                'deskripsi' => 'Kontes algoritma dan struktur data.',
            ],
            [
                'nama' => 'Rizky Saputra',
                'nim' => '2201301199',
                'jurusan' => 'Teknologi Informasi',
                'angkatan' => '2022',
                'kompetisi' => 'UI/UX Challenge',
                'jenis' => 'UI/UX',
                'tingkat' => 'Kampus',
                'peringkat' => 'Harapan 1',
                'poin' => 40,
                'penyelenggara' => 'BEM TI',
                'tanggal' => Carbon::parse('2025-01-10'),
                'tahun' => 2025,
                'status' => 'published',
                'deskripsi' => 'Perancangan antarmuka aplikasi mobile.',
            ],
            [
                'nama' => 'Nadia Putri',
                'nim' => '2301301007',
                'jurusan' => 'Teknologi Informasi',
                'angkatan' => '2023',
                'kompetisi' => 'Hackathon Smart City',
                'jenis' => 'Hackathon',
                'tingkat' => 'Nasional',
                'peringkat' => null,
                'poin' => 60,
                'penyelenggara' => 'Kominfo',
                'tanggal' => Carbon::parse('2025-05-05'),
                'tahun' => 2025,
                'status' => 'draft',
                'deskripsi' => 'Membangun prototipe solusi kota cerdas.',
            ],
        ];

        foreach ($items as $data) {
            MahasiswaBerprestasi::create($data);
        }
    }
}

