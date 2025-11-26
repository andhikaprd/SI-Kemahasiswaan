<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\SocialiteController;

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
use App\Http\Controllers\Kaprodi\DownloadController as KaprodiDownloadController;

/*
|--------------------------------------------------------------------------
| USER / PUBLIK
|--------------------------------------------------------------------------
*/
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/divisi', [DivisiController::class, 'index'])->name('divisi');

// Pendaftaran wajib login (redirect ke login jika belum auth)
Route::middleware('auth')->prefix('pendaftaran')->name('pendaftaran.')->group(function () {
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
// Admin: wajib login + role admin
Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::redirect('/', '/admin/dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // CRUD Data Admin
    // Tetapkan nama parameter menjadi {berita} (bukan "beritum") agar binding & route() konsisten
    Route::resource('berita', AdminBeritaController::class)
        ->parameters(['berita' => 'berita'])
        ->except(['show'])
        ->names('berita');
    Route::resource('account', AdminAccountController::class)->except(['show'])->names('account');
    Route::resource('divisi', AdminDivisiController::class)
        ->only(['index', 'create', 'store'])
        ->names('divisi');
    Route::resource('laporan', AdminLaporanController::class)->except(['show'])->names('laporan');
    Route::resource('mahasiswa-berprestasi', AdminMahasiswaBerprestasiController::class)
        ->parameters(['mahasiswa-berprestasi' => 'prestasi'])
        ->names('mahasiswa_berprestasi')
        ->except(['show']);

    // (Dinonaktifkan) SAW & Bobot AHP untuk Prestasi — routes dihapus sesuai permintaan

    // Modul TPK generik (Criteria, Alternatives, Compute)
    Route::prefix('tpk')->name('tpk.')->group(function () {
        Route::redirect('/', '/admin/tpk/criteria');
        Route::resource('criteria', \App\Http\Controllers\Admin\TPK\CriteriaController::class)->except(['show']);
        Route::resource('alternatives', \App\Http\Controllers\Admin\TPK\AlternativeController::class)->except(['show']);
        Route::get('compute', [\App\Http\Controllers\Admin\TPK\ComputeController::class, 'index'])->name('compute');
        Route::get('compute/export', [\App\Http\Controllers\Admin\TPK\ComputeController::class, 'exportCsv'])->name('compute.export');
    });
});

/*
|--------------------------------------------------------------------------
| KAPRODI PANEL
|--------------------------------------------------------------------------
*/
// Kaprodi: wajib login + role kaprodi
Route::middleware(['auth','role:kaprodi'])->prefix('kaprodi')->name('kaprodi.')->group(function () {

    // 🔹 Daftar Laporan (CRUD Kaprodi)
    Route::resource('laporan', KaprodiLaporanController::class)
        ->except(['show'])
        ->names('laporan');

    // 🔹 Mahasiswa Bermasalah
    // Pelanggaran Mahasiswa (alias dari MasalahMahasiswaController)
    Route::resource('pelanggaran-mahasiswa', KaprodiMasalahMahasiswaController::class)
        ->except(['show'])
        ->parameters(['pelanggaran-mahasiswa' => 'masalahMahasiswa'])
        ->names('pelanggaran_mahasiswa');

    // Alias lama (kompatibilitas), tetap mengarah ke controller yang sama
    Route::resource('masalah-mahasiswa', KaprodiMasalahMahasiswaController::class)
        ->except(['show'])
        ->parameters(['masalah-mahasiswa' => 'masalahMahasiswa'])
        ->names('masalah_mahasiswa');

    // 🔹 Verifikasi Laporan
    Route::get('/verifikasi', [VerifikasiLaporanController::class, 'index'])->name('verifikasi.index');
    Route::post('/verifikasi/{id}/setujui', [VerifikasiLaporanController::class, 'setujui'])->name('verifikasi.setujui');
    Route::post('/verifikasi/{id}/tolak', [VerifikasiLaporanController::class, 'tolak'])->name('verifikasi.tolak');
    Route::get('/verifikasi/{laporan}/download', [KaprodiDownloadController::class, 'laporan'])->name('verifikasi.download');
    Route::get('/laporan/{laporan}/download', [KaprodiLaporanController::class, 'download'])->name('laporan.download');
});

/*
|--------------------------------------------------------------------------
| LOGOUT (Manual)
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('beranda')->with('status', 'Anda telah keluar.');
})->name('logout');

/*
|--------------------------------------------------------------------------
| AUTH / LOGIN (Google SSO)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [SocialiteController::class, 'login'])->name('login');
    Route::post('/login', [SocialiteController::class, 'handlePasswordLogin'])->name('login.attempt');
    Route::get('/auth/google/redirect', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google.redirect');
    Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});
