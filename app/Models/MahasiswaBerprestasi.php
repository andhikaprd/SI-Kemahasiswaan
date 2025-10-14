<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaBerprestasi extends Model
{
    use HasFactory;

    protected $table = 'prestasi_mahasiswa'; // nama tabel di database
    protected $fillable = [
        'nama',
        'nim',
        'program_studi',
        'tingkat_prestasi',
        'jenis_prestasi',
        'tahun',
        'deskripsi',
    ];
}
