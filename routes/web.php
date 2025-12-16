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
use App\Http\Controllers\Admin\PendaftaranController as AdminPendaftaranController;
use App\Http\Controllers\Admin\PelanggaranMasterController as AdminPelanggaranMasterController;

// === Kaprodi ===
use App\Http\Controllers\Kaprodi\LaporanController as KaprodiLaporanController;
use App\Http\Controllers\Kaprodi\MasalahMahasiswaController as KaprodiMasalahMahasiswaController;
use App\Http\Controllers\Kaprodi\VerifikasiLaporanController;
use App\Http\Controllers\Kaprodi\DownloadController as KaprodiDownloadController;
use App\Http\Controllers\Kaprodi\PelanggaranMasterController as KaprodiPelanggaranMasterController;
use App\Http\Controllers\User\PrestasiCertificateController as UserPrestasiCertificateController;
use App\Http\Controllers\Admin\PrestasiCertificateController as AdminPrestasiCertificateController;

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
// Upload sertifikat prestasi (user harus login, prestasi sudah ada)
Route::middleware('auth')->group(function () {
    Route::get('/prestasi/{prestasi:slug}/upload-sertifikat', [UserPrestasiCertificateController::class, 'create'])->name('prestasi.certificate.create');
    Route::post('/prestasi/{prestasi:slug}/upload-sertifikat', [UserPrestasiCertificateController::class, 'store'])->name('prestasi.certificate.store');
    Route::get('/prestasi/{prestasi:slug}/sertifikat/{certificate}/download', [UserPrestasiCertificateController::class, 'download'])->name('prestasi.certificate.download');
    Route::delete('/prestasi/{prestasi:slug}/sertifikat/{certificate}', [UserPrestasiCertificateController::class, 'destroy'])->name('prestasi.certificate.destroy');
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
        ->names('berita');
    Route::resource('account', AdminAccountController::class)->except(['show'])->names('account');
    Route::resource('divisi', AdminDivisiController::class)
        ->only(['index', 'create', 'store'])
        ->names('divisi');
    Route::resource('laporan', AdminLaporanController::class)->names('laporan');
    Route::get('laporan/{laporan}/download', [AdminLaporanController::class, 'download'])->name('laporan.download');
    Route::resource('mahasiswa-berprestasi', AdminMahasiswaBerprestasiController::class)
        ->parameters(['mahasiswa-berprestasi' => 'prestasi'])
        ->names('mahasiswa_berprestasi')
        ->except(['show']);
    Route::resource('pelanggaran-master', AdminPelanggaranMasterController::class)
        ->parameters(['pelanggaran-master' => 'pelanggaran_master'])
        ->names('pelanggaran_master');
    Route::get('sertifikat-prestasi', [AdminPrestasiCertificateController::class, 'index'])->name('prestasi_certificates.index');
    Route::get('sertifikat-prestasi/{certificate}/download', [AdminPrestasiCertificateController::class, 'download'])->name('prestasi_certificates.download');
    Route::patch('sertifikat-prestasi/{certificate}/status', [AdminPrestasiCertificateController::class, 'updateStatus'])->name('prestasi_certificates.update_status');
    Route::delete('sertifikat-prestasi/{certificate}', [AdminPrestasiCertificateController::class, 'destroy'])->name('prestasi_certificates.destroy');

    // Manajemen pendaftaran HIMA
    Route::get('pendaftaran', [AdminPendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::patch('pendaftaran/{pendaftaran}', [AdminPendaftaranController::class, 'update'])->name('pendaftaran.update');
    Route::delete('pendaftaran/{pendaftaran}', [AdminPendaftaranController::class, 'destroy'])->name('pendaftaran.destroy');
    Route::post('pendaftaran/process-bulk', [AdminPendaftaranController::class, 'processBulk'])->name('pendaftaran.process_bulk');
    Route::get('pendaftaran/process-bulk', fn() => redirect()->route('admin.pendaftaran.index'))->name('pendaftaran.process_bulk.get');
    Route::get('pendaftaran/export', [AdminPendaftaranController::class, 'exportCsv'])->name('pendaftaran.export');

    // (Dinonaktifkan) SAW & Bobot AHP untuk Prestasi - routes dihapus sesuai permintaan

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

    // Daftar Laporan (CRUD Kaprodi)
    Route::resource('laporan', KaprodiLaporanController::class)
        ->except(['show'])
        ->names('laporan');

    // Mahasiswa Bermasalah
    // Pelanggaran Mahasiswa (alias dari MasalahMahasiswaController)
    Route::resource('pelanggaran-mahasiswa', KaprodiMasalahMahasiswaController::class)
        ->parameters(['pelanggaran-mahasiswa' => 'masalahMahasiswa'])
        ->names('pelanggaran_mahasiswa');
    Route::get('pelanggaran-mahasiswa/{masalahMahasiswa}', [KaprodiMasalahMahasiswaController::class, 'show'])
        ->name('pelanggaran_mahasiswa.show');

    // Alias lama (kompatibilitas), tetap mengarah ke controller yang sama
    Route::resource('masalah-mahasiswa', KaprodiMasalahMahasiswaController::class)
        ->except(['show'])
        ->parameters(['masalah-mahasiswa' => 'masalahMahasiswa'])
        ->names('masalah_mahasiswa');

    Route::resource('pelanggaran-master', KaprodiPelanggaranMasterController::class)
        ->parameters(['pelanggaran-master' => 'pelanggaran_master'])
        ->names('pelanggaran_master');

    // Verifikasi Laporan
    Route::get('/verifikasi', [VerifikasiLaporanController::class, 'index'])->name('verifikasi.index');
    Route::post('/verifikasi/{id}/setujui', [VerifikasiLaporanController::class, 'setujui'])->name('verifikasi.setujui');
    Route::post('/verifikasi/{id}/tolak', [VerifikasiLaporanController::class, 'tolak'])->name('verifikasi.tolak');
    Route::get('/verifikasi/{laporan}/download', [KaprodiDownloadController::class, 'laporan'])->name('verifikasi.download');
    Route::get('/laporan/{laporan}/download', [KaprodiLaporanController::class, 'download'])->name('laporan.download');
    Route::get('/laporan/periode/{periode}/download', [KaprodiLaporanController::class, 'downloadPeriode'])->name('laporan.download_periode');
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
    Route::post('/login', [SocialiteController::class, 'handlePasswordLogin'])->middleware('throttle:5,1')->name('login.attempt');
    Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'show'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'store'])->name('register.store');
    Route::get('/auth/google/redirect', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google.redirect');
    Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});
