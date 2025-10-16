<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MahasiswaBerprestasi extends Model
{
    use HasFactory;

    // Tabel sesuai migrasi 2025_10_01_134226_create_prestasi_mahasiswa_table
    protected $table = 'prestasi_mahasiswa';

    protected $fillable = [
        'nama',
        'nim',
        'jurusan',
        'angkatan',
        'kompetisi',
        'jenis',
        'tingkat',
        'peringkat',
        'poin',
        'penyelenggara',
        'tanggal',
        'tahun',
        'sertifikat_path',
        'foto_path',
        'status',
        'slug',
        'deskripsi',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Scope: hanya data yang sudah dipublish
    public function scopePublished($q)
    {
        return $q->where('status', 'published');
    }

    // Setter tahun otomatis dari tanggal jika kosong
    public function setTahunAttribute($value)
    {
        if (empty($value) && $this->tanggal) {
            $this->attributes['tahun'] = (int) $this->tanggal->format('Y');
        } else {
            $this->attributes['tahun'] = $value;
        }
    }

    public function getSertifikatUrlAttribute(): ?string
    {
        return $this->sertifikat_path ? Storage::url($this->sertifikat_path) : null;
    }

    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto_path ? Storage::url($this->foto_path) : null;
    }

    protected static function booted()
    {
        static::saving(function (self $m) {
            if (!$m->tahun && $m->tanggal) {
                $m->tahun = (int) $m->tanggal->format('Y');
            }
            if (empty($m->slug)) {
                $m->slug = Str::slug(($m->nama ?? 'prestasi') . ' ' . ($m->kompetisi ?? '') . '-' . now()->timestamp);
            }
        });
    }
}
