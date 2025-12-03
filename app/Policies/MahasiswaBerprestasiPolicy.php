<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MahasiswaBerprestasi;

class MahasiswaBerprestasiPolicy
{
    /**
     * Admin boleh melihat daftar prestasi.
     */
    public function viewAny(?User $user): bool
    {
        return $user?->role === 'admin';
    }

    /**
     * Admin boleh melihat detail prestasi.
     */
    public function view(?User $user, MahasiswaBerprestasi $model): bool
    {
        return $user?->role === 'admin';
    }

    /**
     * Admin boleh membuat data prestasi.
     */
    public function create(?User $user): bool
    {
        return $user?->role === 'admin';
    }

    /**
     * Admin boleh mengupdate data prestasi.
     */
    public function update(?User $user, MahasiswaBerprestasi $model): bool
    {
        return $user?->role === 'admin';
    }

    /**
     * Admin boleh menghapus data prestasi.
     */
    public function delete(?User $user, MahasiswaBerprestasi $model): bool
    {
        return $user?->role === 'admin';
    }
}
