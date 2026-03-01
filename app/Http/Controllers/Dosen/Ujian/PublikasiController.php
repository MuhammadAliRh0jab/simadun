<?php

namespace App\Http\Controllers\Dosen\Ujian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Dosen\Ujian\PublikasiService;
use App\DataTables\Dosen\PublikasiDataTable;
use App\Http\Requests\Ujian\Dosen\ProposalRequest;

class PublikasiController extends Controller
{
    protected $publikasiService;

    public function __construct(PublikasiService $publikasiService)
    {
        $this->publikasiService = $publikasiService;
    }

    public function index(PublikasiDataTable $dataTable)
    {
        return $dataTable->render('pages.dosen.ujian.publikasi.index');
    }

    public function show($id)
    {
        return $this->publikasiService->show($id);
    }

    public function store(ProposalRequest $request, $publikasiId)
    {
        return $this->publikasiService->store($request, $publikasiId);
    }

    public function finalisasi(Request $request)
    {
        return $this->publikasiService->finalisasi($request);
    }
}
