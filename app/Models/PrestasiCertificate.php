<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PrestasiCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'prestasi_id',
        'user_id',
        'path',
        'original_name',
        'mime',
        'size',
        'status',
        'note',
    ];

    protected $appends = ['url'];

    public function prestasi()
    {
        return $this->belongsTo(MahasiswaBerprestasi::class, 'prestasi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute(): ?string
    {
        if (!$this->path) {
            return null;
        }

        // Prioritaskan route terproteksi sesuai peran
        $user = auth()->user();
        if ($user && $user->role === 'admin' && app('router')->has('admin.prestasi_certificates.download')) {
            return route('admin.prestasi_certificates.download', $this);
        }
        if ($user && $this->prestasi_id && app('router')->has('prestasi.certificate.download')) {
            return route('prestasi.certificate.download', [$this->prestasi, $this]);
        }

        return null;
    }

    public function deleteFile(): void
    {
        if ($this->path && !preg_match('/^https?:\/\//i', $this->path)) {
            // Hapus di storage privat (fallback ke public untuk file lama)
            Storage::disk('local')->delete($this->path);
            Storage::disk('public')->delete($this->path);
        }
    }

    protected static function booted()
    {
        static::deleting(function(self $m){
            $m->deleteFile();
        });
    }
}
