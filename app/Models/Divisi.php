<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'slug',
        'ketua',
        'deskripsi',
        'program_kerja',
        'anggota',
        'gambar',
        'urutan',
    ];

    protected $casts = [
        'program_kerja' => 'array',
        'anggota' => 'array',
    ];
}
