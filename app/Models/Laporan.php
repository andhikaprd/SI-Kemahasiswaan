<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Laporan extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'laporans';

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'judul',
        'periode',
        'kategori',
        'status',
        'deskripsi',
        'file_path',
    ];

    /**
     * Accessor untuk mendapatkan URL file laporan
     */
    public function getFileUrlAttribute(): ?string
    {
        if (!$this->file_path) {
            return null;
        }

        return Storage::disk('public')->url($this->file_path);
    }
}
