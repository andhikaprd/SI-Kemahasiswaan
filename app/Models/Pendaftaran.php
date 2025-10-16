<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    // Sesuaikan dengan migrasi: 2025_09_29_115200_create_pendaftarans_table.php
    protected $table = 'pendaftarans';

    protected $fillable = [
        'nama_lengkap',
        'nim',
        'jurusan',
        'angkatan',
        'email',
        'no_telp',
        'divisi_pilihan',
        'motivasi',
        'status',
    ];
}
