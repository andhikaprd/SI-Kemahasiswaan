<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswas'; // nama tabel di database

    protected $fillable = [
        'nama',
        'nim',
        'prodi_id',
        'angkatan',
        'email',
        // Tambahan untuk perankingan
        'ipk',
        'english_type',
        'english_score',
    ];

    protected $casts = [
        'ipk' => 'float',
        'english_score' => 'float',
    ];

    public function masalahMahasiswa()
    {
        return $this->hasMany(MasalahMahasiswa::class, 'mahasiswa_id');
    }
}
