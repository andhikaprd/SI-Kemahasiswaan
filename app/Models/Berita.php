<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'beritas';

    protected $fillable = [
        'judul',
        'slug',
        'ringkasan',
        'isi',
        'kategori',
        'status',
        'penulis',
        'tanggal_publikasi',
        'gambar',
        'tags',
    ];

    protected $casts = [
        'tanggal_publikasi' => 'date',
    ];

    /**
     * Scope untuk berita yang sudah dipublikasikan.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Dapatkan URL gambar (otomatis ambil dari storage/public).
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->gambar) {
            return asset('images/default-news.jpg'); // fallback default
        }

        return Storage::disk('public')->url($this->gambar);
    }

    /**
     * Set slug otomatis dari judul jika belum ada.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul . '-' . now()->format('YmdHis'));
            }
        });
    }
}