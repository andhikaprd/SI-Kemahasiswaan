<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    /**
     * Menampilkan halaman informasi divisi.
     */
    public function index()
    {
        // Controller ini hanya menampilkan view statis,
        // jadi tidak perlu mengambil data dari database.
        return view('user.divisi');
    }
}

