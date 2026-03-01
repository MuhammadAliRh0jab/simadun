<?php

namespace App\Http\Controllers\Dosen\Ujian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Dosen\Ujian\DisertasiService;
use App\DataTables\Dosen\DisertasiDataTable;
use App\Http\Requests\Ujian\Dosen\ProposalRequest;

class DisertasiController extends Controller
{
    protected $disertasiService;

    public function __construct(DisertasiService $disertasiService)
    {
        $this->disertasiService = $disertasiService;
    }

    public function index(DisertasiDataTable $dataTable)
    {
        return $dataTable->render('pages.dosen.ujian.disertasi.index');
    }

    public function show($id)
    {
        return $this->disertasiService->show($id);
    }

    public function store(ProposalRequest $request, $disertasiId)
    {
        return $this->disertasiService->store($request, $disertasiId);
    }

    public function finalisasi(Request $request)
    {
        return $this->disertasiService->finalisasi($request);
    }
}
