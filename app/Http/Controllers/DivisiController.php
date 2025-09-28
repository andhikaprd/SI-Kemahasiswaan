<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DivisiController extends Controller
{
    public function index()
    {
        // nanti bisa ambil data dari database, sementara static dulu
        return view('divisi');
    }
}
