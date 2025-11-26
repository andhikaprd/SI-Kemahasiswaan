<?php

namespace App\Policies;

use App\Models\Laporan;
use App\Models\User;

class LaporanPolicy
{
    protected function canManage(?User $user): bool
    {
        return in_array($user?->role, ['admin', 'kaprodi'], true);
    }

    public function viewAny(?User $user): bool
    {
        return $this->canManage($user);
    }

    public function view(?User $user, Laporan $laporan): bool
    {
        return $this->canManage($user);
    }

    public function create(?User $user): bool
    {
        return $this->canManage($user);
    }

    public function update(?User $user, Laporan $laporan): bool
    {
        return $this->canManage($user);
    }

    public function delete(?User $user, Laporan $laporan): bool
    {
        return $this->canManage($user);
    }
}
