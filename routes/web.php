<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\PendaftaranController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Beranda
Route::get('/', function () {
    return view('beranda');
});

// Halaman Divisi
Route::get('/divisi', function () {
    return view('divisi');
});

// Halaman Pendaftaran (Form + Simpan)
Route::resource('pendaftaran', PendaftaranController::class);

// CRUD Account
Route::resource('account', AccountController::class);
