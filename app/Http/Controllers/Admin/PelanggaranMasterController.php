<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\PelanggaranMasterController as BaseController;

class PelanggaranMasterController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);
        $this->viewBase = 'Admin.pelanggaran_master';
        $this->routeBase = 'admin.pelanggaran_master';
    }
}
