<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran'; // nama tabel
    protected $primaryKey = 'id_pendaftaran'; // primary key

    protected $fillable = [
        'nama_lengkap',
        'nim',
        'jurusan',
        'angkatan',
        'email',
        'no_telp',
        'divisi_pilihan',
        'motivasi',
    ];
}
