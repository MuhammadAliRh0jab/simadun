<?php

namespace App\Http\Controllers\Dosen\PublikasiMahasiswa;

use App\DataTables\Dosen\PublikasiMahasiswa\LaporanPublikasiConferenceDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanPublikasiConferenceController extends Controller
{
    public function index(LaporanPublikasiConferenceDataTable $dataTable)
    {
        return $dataTable->render('pages.dosen.publikasi.conference.index');
    }
}
