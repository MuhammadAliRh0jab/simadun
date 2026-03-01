<?php

namespace App\Http\Controllers\Dosen\Ujian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Dosen\Ujian\SemhasService;
use App\DataTables\Dosen\SemhasDataTable;
use App\Http\Requests\Ujian\Dosen\ProposalRequest;

class SemhasController extends Controller
{
    //
    protected $semhasService;

    public function __construct(SemhasService $semhasService)
    {
        $this->semhasService = $semhasService;
    }

    public function index(SemhasDataTable $dataTable)
    {
        return $dataTable->render('pages.dosen.ujian.semhas.index');
    }

    public function show($id)
    {
        return $this->semhasService->show($id);
    }

    public function store(ProposalRequest $request, $semhasId)
    {
        return $this->semhasService->store($request, $semhasId);
    }

    public function finalisasi(Request $request)
    {
        return $this->semhasService->finalisasi($request);
    }
}
