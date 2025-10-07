<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;

    // Gunakan tabel 'users' karena tabel 'akun' tidak ada
    protected $table = 'users';

    // Primary key default-nya 'id', jadi tidak perlu override
    // protected $primaryKey = 'id';

    protected $fillable = [
        'name',        // sebelumnya 'username'
        'email',
        'password',
        'role',
        'status',
        'nim',
        'jurusan',
        'angkatan',
    ];
}
