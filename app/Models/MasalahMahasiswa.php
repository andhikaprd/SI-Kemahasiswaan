<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasalahMahasiswa extends Model
{
    use HasFactory;
<<<<<<< HEAD

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
=======
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
>>>>>>> 5ba264de75815c43bc5d8d59da852456fbad827b
}
