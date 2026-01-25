<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporans';

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

    protected $casts = [
        'tanggal_submit' => 'datetime',
        'verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function getFileUrlAttribute(): ?string
    {
        if (!$this->file_path) {
            return null;
        }
        if (auth()->check() && auth()->user()->role === 'admin' && app('router')->has('admin.laporan.download')) {
            return route('admin.laporan.download', $this);
        }
        if (app('router')->has('kaprodi.laporan.download')) {
            return route('kaprodi.laporan.download', $this);
        }

        return null;
    }
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function getTanggalSubmitFormattedAttribute(): string
    {
        return $this->tanggal_submit
            ? $this->tanggal_submit->format('d M Y, H:i')
            : '-';
    }

    public function getFileSizeFormattedAttribute(): string
    {
        return $this->file_size
            ? number_format($this->file_size / 1024, 2) . ' KB'
            : '-';
    }
}
