<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\PelanggaranMasterController as BaseController;

class PelanggaranMasterController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth','role:kaprodi']);
        $this->viewBase = 'Kaprodi.pelanggaran_master';
        $this->routeBase = 'kaprodi.pelanggaran_master';
    }
}
