<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasalahMahasiswa extends Model
{
    use HasFactory;

    // Nama tabel yang dipakai
    protected $table = 'masalah_mahasiswa';

    // Kolom yang boleh diisi (fillable)
    protected $fillable = [
        'nama',
        'nim',
        'prodi',
        'angkatan',
        'jenis_permasalahan',
        'deskripsi',
        'kategori',
        'status',
        'tanggal_laporan',
        'pelapor',
    ];
}
