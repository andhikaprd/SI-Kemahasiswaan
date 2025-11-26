<?php

namespace App\Providers;

use App\Models\Berita;
use App\Models\Laporan;
use App\Models\MasalahMahasiswa;
use App\Policies\BeritaPolicy;
use App\Policies\LaporanPolicy;
use App\Policies\MasalahMahasiswaPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Berita::class => BeritaPolicy::class,
        Laporan::class => LaporanPolicy::class,
        MasalahMahasiswa::class => MasalahMahasiswaPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
