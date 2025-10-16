<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasalahMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'masalah_mahasiswa';

    protected $fillable = [
        'mahasiswa_id',
        'semester',
        'ipk',
        'jenis_masalah',
        'status_peringatan',
        'laporan_terakhir',
        'keterangan',
    ];

    protected $casts = [
        'laporan_terakhir' => 'date',
        'ipk' => 'decimal:2',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
