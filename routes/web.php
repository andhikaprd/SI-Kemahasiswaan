<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// === User / Publik ===
use App\Http\Controllers\User\BerandaController;
use App\Http\Controllers\User\BeritaController;
use App\Http\Controllers\User\DivisiController;
use App\Http\Controllers\User\MahasiswaBerprestasiController;
use App\Http\Controllers\User\PendaftaranController;
use App\Http\Controllers\User\ProfilController;

// === Admin ===
use App\Http\Controllers\Admin\AccountController as AdminAccountController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DivisiController as AdminDivisiController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\MahasiswaBerprestasiController as AdminMahasiswaBerprestasiController;

// === Kaprodi ===
use App\Http\Controllers\Kaprodi\LaporanController as KaprodiLaporanController;
use App\Http\Controllers\Kaprodi\MasalahMahasiswaController as KaprodiMasalahMahasiswaController;
use App\Http\Controllers\Kaprodi\VerifikasiLaporanController;

/*
|--------------------------------------------------------------------------
| USER / PUBLIK
|--------------------------------------------------------------------------
*/
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/divisi', [DivisiController::class, 'index'])->name('divisi');

Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
    Route::get('/', [PendaftaranController::class, 'create'])->name('create');
    Route::post('/', [PendaftaranController::class, 'store'])->name('store');
});

Route::prefix('berita')->name('berita.')->group(function () {
    Route::get('/', [BeritaController::class, 'index'])->name('index');
    Route::get('/{berita:slug}', [BeritaController::class, 'show'])->name('show');
});

Route::get('/profil', [ProfilController::class, 'index'])->name('profil');

Route::prefix('prestasi')->name('prestasi.')->group(function () {
    Route::get('/', [MahasiswaBerprestasiController::class, 'index'])->name('index');
    Route::get('/{prestasi:slug}', [MahasiswaBerprestasiController::class, 'show'])->name('show');
});

/*
|--------------------------------------------------------------------------
| ADMIN PANEL
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::redirect('/', '/admin/dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // CRUD Data Admin
    Route::resource('berita', AdminBeritaController::class)->except(['show'])->names('berita');
    Route::resource('account', AdminAccountController::class)->except(['show'])->names('account');
    Route::resource('divisi', AdminDivisiController::class)
        ->only(['index', 'create', 'store'])
        ->names('divisi');
    Route::resource('laporan', AdminLaporanController::class)->except(['show'])->names('laporan');
    Route::resource('mahasiswa-berprestasi', AdminMahasiswaBerprestasiController::class)
        ->parameters(['mahasiswa-berprestasi' => 'prestasi'])
        ->names('mahasiswa_berprestasi')
        ->except(['show']);
});

/*
|--------------------------------------------------------------------------
| KAPRODI PANEL
|--------------------------------------------------------------------------
*/
Route::prefix('kaprodi')->name('kaprodi.')->group(function () {

    // 🔹 Daftar Laporan (CRUD Kaprodi)
    Route::resource('laporan', KaprodiLaporanController::class)
        ->except(['show'])
        ->names('laporan');

    // 🔹 Mahasiswa Bermasalah
    Route::resource('masalah-mahasiswa', KaprodiMasalahMahasiswaController::class)
        ->parameters(['masalah-mahasiswa' => 'masalahMahasiswa'])
        ->names('masalah_mahasiswa');

    // 🔹 Verifikasi Laporan
    Route::get('/verifikasi', [VerifikasiLaporanController::class, 'index'])->name('verifikasi.index');
    Route::post('/verifikasi/{id}/setujui', [VerifikasiLaporanController::class, 'setujui'])->name('verifikasi.setujui');
    Route::post('/verifikasi/{id}/tolak', [VerifikasiLaporanController::class, 'tolak'])->name('verifikasi.tolak');
});

/*
|--------------------------------------------------------------------------
| LOGOUT (Manual)
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('beranda');
})->name('logout');
