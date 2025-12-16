<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DivisiSeeder extends Seeder
{
    /**
     * Seed data divisi HIMA jika tabel tersedia.
     */
    public function run(): void
    {
        if (!Schema::hasTable('divisis')) {
            // Lewati bila migrasi divisi belum dibuat.
            return;
        }

        $now = now();
        $data = [
            [
                'nama' => 'Kaderisasi',
                'slug' => 'kaderisasi',
                'ketua' => 'Dicky',
                'deskripsi' => 'Mengembangkan kualitas sumber daya manusia dan karakter mahasiswa TI.',
                'program_kerja' => json_encode(['Latihan Kepemimpinan','Mentoring Akademik','Outbound Character Building','Pelatihan Soft Skill']),
                'anggota' => json_encode(['Ujang Numani','Annisa Nurhidayah','Abel Devia Agustin']),
                'urutan' => 1,
            ],
            [
                'nama' => 'Media Informasi',
                'slug' => 'media-informasi',
                'ketua' => 'M. Rayhan Wahyu Riduan',
                'deskripsi' => 'Mengelola komunikasi, publikasi, dan kanal informasi HIMA TI.',
                'program_kerja' => json_encode(['Publikasi Kegiatan','Pengelolaan Sosial Media','Desain Konten','Website & Dokumentasi']),
                'anggota' => json_encode(['Muhammad Sulaiman Hafi','Tim Desain','Tim Dokumentasi']),
                'urutan' => 2,
            ],
            [
                'nama' => 'Technopreneurship',
                'slug' => 'technopreneurship',
                'ketua' => 'Nadella Irsasyarifa',
                'deskripsi' => 'Mengembangkan jiwa kewirausahaan berbasis teknologi dan inovasi digital.',
                'program_kerja' => json_encode(['Pelatihan Produk Digital','Kompetisi Inovasi','Startup Camp','Kolaborasi Industri']),
                'anggota' => json_encode(['M. Zainal Akli','Rahmad Erwin Prayoga']),
                'urutan' => 3,
            ],
            [
                'nama' => 'Public Relations',
                'slug' => 'public-relations',
                'ketua' => 'Muhamad Sahlil Rizki',
                'deskripsi' => 'Membangun hubungan eksternal dengan alumni, mitra, dan organisasi mahasiswa.',
                'program_kerja' => json_encode(['Temu Kangen Alumni','Seminar Praktisi Industri','Jaringan Kemitraan','Publikasi & Kehumasan']),
                'anggota' => json_encode(['Muhammad Arifin','Muhammad Yoga','M. Dimas Aprianto']),
                'urutan' => 4,
            ],
        ];

        foreach ($data as $row) {
            DB::table('divisis')->updateOrInsert(
                ['slug' => $row['slug']],
                array_merge($row, [
                    'slug' => Str::slug($row['slug']),
                    'created_at' => $now,
                    'updated_at' => $now,
                ])
            );
        }
    }
}
