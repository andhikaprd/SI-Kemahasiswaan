<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelanggaranMaster extends Model
{
    use HasFactory;

    protected $table = 'pelanggaran_masters';

    protected $fillable = [
        'nama',
        'kategori', // ringan, sedang, berat
        'deskripsi',
        'sanksi_default',
    ];
}
