<?php

namespace App\Http\Controllers\Dosen\Ujian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Dosen\ProposalDataTable;
use App\Services\Dosen\Ujian\ProposalService;
use App\Http\Requests\Ujian\Dosen\ProposalRequest;

class ProposalController extends Controller
{
    protected $proposalService;

    public function __construct(ProposalService $proposalService)
    {
        $this->proposalService = $proposalService;
    }

    public function index(ProposalDataTable $dataTable)
    {
        return $dataTable->render('pages.dosen.ujian.proposal.index');
    }

    public function show($id)
    {
        return $this->proposalService->show($id);
    }

    public function store(ProposalRequest $request, $proposalId)
    {
        return $this->proposalService->store($request, $proposalId);
    }

    public function finalisasi(Request $request)
    {
        return $this->proposalService->finalisasi($request);
    }
}
