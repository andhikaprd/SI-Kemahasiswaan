<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. IMPORT SEMUA CONTROLLER BARU
|--------------------------------------------------------------------------
| Kita import semua controller dari subfolder User, Admin, dan Kaprodi.
| Kita gunakan alias 'as' untuk controller yang namanya sama (cth: BeritaController).
*/
// User (Frontend) Controllers
use App\Http\Controllers\User\BerandaController;
use App\Http\Controllers\User\BeritaController as UserBeritaController;
use App\Http\Controllers\User\PendaftaranController as UserPendaftaranController;
use App\Http\Controllers\User\DivisiController as UserDivisiController; // Asumsi ada controller untuk halaman divisi publik

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController; // Menggunakan DashboardController
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\PendaftaranController as AdminPendaftaranController;
use App\Http\Controllers\Admin\DivisiController as AdminDivisiController;

// Kaprodi Controllers
use App\Http\Controllers\Kaprodi\MasalahMahasiswaController;


/*
|--------------------------------------------------------------------------
| 2. RUTE UNTUK USER / PENGUNJUNG (FRONTEND)
|--------------------------------------------------------------------------
| Rute ini dapat diakses oleh siapa saja.
*/
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/divisi', [UserDivisiController::class, 'index'])->name('divisi.index');

// Rute untuk menampilkan daftar berita dan detail berita
Route::get('/berita', [UserBeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{berita}', [UserBeritaController::class, 'show'])->name('berita.show'); // {berita} akan otomatis mengambil data berita

// Rute untuk user mendaftar HIMA
Route::get('/pendaftaran', [UserPendaftaranController::class, 'create'])->name('pendaftaran.create');
Route::post('/pendaftaran', [UserPendaftaranController::class, 'store'])->name('pendaftaran.store');


/*
|--------------------------------------------------------------------------
| 3. RUTE UNTUK ADMIN
|--------------------------------------------------------------------------
| Semua rute di dalam grup ini akan memiliki URL diawali '/admin'
| dan nama route diawali 'admin.'.
| Middleware akan melindungi rute ini hanya untuk admin yang sudah login.
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Lengkap untuk Admin
    Route::resource('account', AccountController::class);
    Route::resource('berita', AdminBeritaController::class);
    Route::resource('divisi', AdminDivisiController::class);
    
    // Admin hanya mengelola pendaftar, tidak mendaftar sendiri
    Route::resource('pendaftaran', AdminPendaftaranController::class)->except(['create', 'store']);
});


/*
|--------------------------------------------------------------------------
| 4. RUTE UNTUK KAPRODI
|--------------------------------------------------------------------------
| Rute yang dilindungi khusus untuk Kaprodi.
*/
Route::prefix('kaprodi')->name('kaprodi.')->middleware(['auth', 'role:kaprodi'])->group(function () {
    // Route::get('/dashboard', [KaprodiDashboardController::class, 'index'])->name('dashboard'); // Anda bisa buat dashboard khusus Kaprodi
    
    // CRUD untuk data mahasiswa bermasalah
    Route::resource('mahasiswa-bermasalah', MasalahMahasiswaController::class);
});


// Jika Anda menggunakan sistem otentikasi bawaan Laravel (Breeze/Jetstream)
// require __DIR__.'/auth.php';
