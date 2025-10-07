<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Langkah 1: Kita coba panggil BerandaController
|--------------------------------------------------------------------------
|
| Kita akan mengembalikan route untuk halaman utama agar memanggil
| controller yang benar.
|
*/

// Import controller untuk halaman user/publik
use App\Http\Controllers\User\BerandaController;
use App\Http\Controllers\User\BeritaController;
use App\Http\Controllers\User\DivisiController;
use App\Http\Controllers\User\MahasiswaBerprestasiController;
use App\Http\Controllers\User\PendaftaranController;
use App\Http\Controllers\User\ProfilController;

// Import controller untuk halaman admin
use App\Http\Controllers\Admin\AccountController as AdminAccountController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DivisiController as AdminDivisiController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\MahasiswaBerprestasiController as AdminMahasiswaBerprestasiController;

// Import controller untuk halaman kaprodi
use App\Http\Controllers\Kaprodi\LaporanController as KaprodiLaporanController;
use App\Http\Controllers\Kaprodi\MasalahMahasiswaController as KaprodiMasalahMahasiswaController;

// Definisikan route untuk halaman utama
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
Route::get('/prestasi', [MahasiswaBerprestasiController::class, 'index'])->name('prestasi.index');

// Grup route untuk panel admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::redirect('/', '/admin/dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('berita', AdminBeritaController::class)->except(['show']);
    Route::resource('account', AdminAccountController::class)->except(['show'])->names('account');
    Route::resource('divisi', AdminDivisiController::class)->only(['index', 'create', 'store'])->names('divisi');
    Route::resource('laporan', AdminLaporanController::class)->except(['show'])->names('laporan');
    Route::resource('mahasiswa-berprestasi', AdminMahasiswaBerprestasiController::class)
        ->parameters(['mahasiswa-berprestasi' => 'mahasiswaBerprestasi'])
        ->names('mahasiswa_berprestasi')
        ->except(['show']);
});

// Grup route untuk kaprodi
Route::prefix('kaprodi')->name('kaprodi.')->group(function () {
    Route::resource('laporan', KaprodiLaporanController::class)->except(['show'])->names('laporan');
    Route::resource('masalah-mahasiswa', KaprodiMasalahMahasiswaController::class)
        ->parameters(['masalah-mahasiswa' => 'masalahMahasiswa'])
        ->names('masalah_mahasiswa');
});
