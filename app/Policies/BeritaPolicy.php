<?php

namespace App\Policies;

use App\Models\Berita;
use App\Models\User;

class BeritaPolicy
{
    public function viewAny(?User $user): bool
    {
        return ($user?->role === 'admin');
    }

    public function view(?User $user, Berita $berita): bool
    {
        return ($user?->role === 'admin');
    }

    public function create(?User $user): bool
    {
        return ($user?->role === 'admin');
    }

    public function update(?User $user, Berita $berita): bool
    {
        return ($user?->role === 'admin');
    }

    public function delete(?User $user, Berita $berita): bool
    {
        return ($user?->role === 'admin');
    }
}
