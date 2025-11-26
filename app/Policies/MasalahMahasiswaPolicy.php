<?php

namespace App\Policies;

use App\Models\MasalahMahasiswa;
use App\Models\User;

class MasalahMahasiswaPolicy
{
    protected function isKaprodi(?User $user): bool
    {
        return $user?->role === 'kaprodi';
    }

    public function viewAny(?User $user): bool
    {
        return $this->isKaprodi($user);
    }

    public function view(?User $user, MasalahMahasiswa $kasus): bool
    {
        return $this->isKaprodi($user);
    }

    public function create(?User $user): bool
    {
        return $this->isKaprodi($user);
    }

    public function update(?User $user, MasalahMahasiswa $kasus): bool
    {
        return $this->isKaprodi($user);
    }

    public function delete(?User $user, MasalahMahasiswa $kasus): bool
    {
        return $this->isKaprodi($user);
    }
}
