<?php

namespace App\Http\Controllers\Mahasiswa\Ujian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Ujian\ProposalRequest;
use App\Services\Mahasiswa\Ujian\ProposalService;
use RealRashid\SweetAlert\Facades\Alert;

class ProposalController extends Controller
{
    protected $ProposalService;

    public function __construct(ProposalService $ProposalService)
    {
        $this->ProposalService = $ProposalService;
    }

    public function index()
    {
        return $this->ProposalService->index();
    }

    public function store(ProposalRequest $request)
    {
        return $this->ProposalService->store($request);
    }

    public function update(Request $request)
    {
        return $this->ProposalService->update($request);
    }

}
