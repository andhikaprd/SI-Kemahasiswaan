<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MahasiswaBerprestasi extends Model
{
    use HasFactory;

    // Nama tabel menyesuaikan migration kamu: 2025_10_01_134226_create_prestasi_mahasiswa_table.php
    protected $table = 'prestasi_mahasiswa';

    protected $fillable = [
        'nama',
        'nim',
        'jurusan',        // (di UI: Jurusan)
        'angkatan',
        'kompetisi',      // Nama Kompetisi
        'jenis',          // Jenis (cth: Kompetisi Programming)
        'tingkat',        // Internasional/Nasional/Provinsi/…
        'peringkat',      // cth: Juara 1, Juara 2
        'poin',
        'penyelenggara',
        'tanggal',        // date
        'tahun',          // int (fallback dari tanggal)
        'sertifikat_path',
        'foto_path',
        'status',         // 'published' | 'draft'
        'slug',           // opsional untuk halaman detail
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /* --------- Scopes --------- */
    public function scopePublished($q)
    {
        return $q->where('status', 'published');
    }

    /* --------- Mutators / Accessors --------- */
    public function setTahunAttribute($value)
    {
        // jika tahun kosong tapi ada tanggal → auto diisi
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
            // pastikan tahun terisi
            if (!$m->tahun && $m->tanggal) {
                $m->tahun = (int) $m->tanggal->format('Y');
            }
            // slug opsional
            if (empty($m->slug)) {
                $m->slug = Str::slug($m->nama . ' ' . ($m->kompetisi ?? '') . '-' . (now()->timestamp));
            }
        });
    }
}
