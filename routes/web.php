<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;

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

// CRUD Account
Route::resource('account', AccountController::class);
