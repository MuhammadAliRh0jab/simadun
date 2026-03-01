<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Dosen\LaporanProgressDataTable;
use App\Services\Dosen\LaporanBulananService;

class LaporanProgressController extends Controller
{
    protected $laporanProgressService;

    public function __construct(LaporanBulananService $laporanProgress)
    {
        $this->laporanProgressService = $laporanProgress;
    }

    public function index(LaporanProgressDataTable $dataTable)
    {
        return $dataTable->render('pages.dosen.laporan-bulanan.index');
    }

    public function show($id)
    {
        return $this->laporanProgressService->show($id);
    }

    public function komentar(Request $request, $id)
    {
        return $this->laporanProgressService->komentar($request, $id);
    }
}
