<?php

namespace App\Http\Controllers\Dosen\PublikasiMahasiswa;

use App\DataTables\Dosen\PublikasiMahasiswa\LaporanPublikasiJurnalDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanPublikasiJurnalController extends Controller
{
    public function index(LaporanPublikasiJurnalDataTable $dataTable)
    {
        return $dataTable->render('pages.dosen.publikasi.jurnal.index');
    }
}
