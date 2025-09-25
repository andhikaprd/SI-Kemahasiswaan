<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;

Route::get('/', function () {
    return view('beranda');
});

// CRUD Account
Route::resource('account', AccountController::class);
