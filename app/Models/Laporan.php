<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Laporan extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'laporans';

    /**
     * Kolom yang boleh diisi secara mass-assignment
     */
    protected $fillable = [
        'mahasiswa_id',
        'mata_kuliah_id',
        'judul',
        'kategori',
        'deskripsi',
        'periode',
        'tanggal_submit',
        'status',
        'catatan_revisi',
        'verified_by',
        'verified_at',
        'file_path',
        'file_mime',
        'file_size',
    ];

    /**
     * Accessor untuk mendapatkan URL file laporan dari storage
     */
    public function getFileUrlAttribute(): ?string
    {
        if (!$this->file_path) {
            return null;
        }

        return Storage::disk('public')->url($this->file_path);
    }

    /**
     * Relasi ke tabel Mahasiswa
     * Setiap laporan dimiliki oleh satu mahasiswa
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    /**
     * Relasi ke tabel Mata Kuliah
     * Setiap laporan terkait dengan satu mata kuliah
     */
    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }

    /**
     * Relasi ke user (kaprodi) yang memverifikasi laporan
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Accessor format tanggal submit
     */
    public function getTanggalSubmitFormattedAttribute(): string
    {
        return $this->tanggal_submit
            ? $this->tanggal_submit->format('d M Y, H:i')
            : '-';
    }

    /**
     * Accessor format ukuran file (dalam KB)
     */
    public function getFileSizeFormattedAttribute(): string
    {
        return $this->file_size
            ? number_format($this->file_size / 1024, 2) . ' KB'
            : '-';
    }
}
