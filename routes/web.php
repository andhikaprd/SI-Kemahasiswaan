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
use App\Http\Controllers\Kaprodi\MasalahMahasiswaController as KaprodiMasalahMahasiswaController;\nuse App\\Http\\Controllers\\Kaprodi\\VerifikasiLaporanController;\nuse App\\Http\\Controllers\\Kaprodi\\DownloadController as KaprodiDownloadController;

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
// sementara buka akses admin tanpa login agar tidak error route login
Route::prefix('admin')->name('admin.')->group(function () {
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
});

/*
|--------------------------------------------------------------------------
| KAPRODI PANEL
|--------------------------------------------------------------------------
*/
// sementara buka akses kaprodi tanpa login agar mudah uji CRUD
Route::prefix('kaprodi')->name('kaprodi.')->group(function () {

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
    return redirect()->route('beranda');
})->name('logout');

