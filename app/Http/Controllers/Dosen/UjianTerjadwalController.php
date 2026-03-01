<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Dosen\UjianTerjadwalDataTable;
use App\Services\Dosen\UjianTerjadwalService;

class UjianTerjadwalController extends Controller
{
    protected $UjianTerjadwalService;

    public function __construct(UjianTerjadwalService $UjianTerjadwalService)
    {
        $this->UjianTerjadwalService = $UjianTerjadwalService;
    }

    public function index(UjianTerjadwalDataTable $dataTable)
    {
        return $dataTable->render('pages.dosen.ujian_terjadwal.index');
    }

    public function show($id)
    {
        return $this->UjianTerjadwalService->show($id);
    }

    public function penilaian(Request $request)
    {
        return $this->UjianTerjadwalService->penilaian($request);
    }

}
