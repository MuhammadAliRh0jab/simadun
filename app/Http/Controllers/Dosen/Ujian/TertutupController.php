<?php

namespace App\Http\Controllers\Dosen\Ujian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Dosen\Ujian\TertutupService;
use App\DataTables\Dosen\TertutupDataTable;
// use App\Http\Requests\Ujian\Dosen\ProposalRequest;

class TertutupController extends Controller
{
    protected $tertutupService;

    public function __construct(TertutupService $tertutupService)
    {
        $this->tertutupService = $tertutupService;
    }

    public function index(TertutupDataTable $dataTable)
    {
        return $dataTable->render('pages.dosen.ujian.tertutup.index');
    }

    public function show($id)
    {
        return $this->tertutupService->show($id);
    }

    public function store(Request $request, $tertutupId)
    {
        return $this->tertutupService->store($request, $tertutupId);
    }

    public function finalisasi(Request $request)
    {
        return $this->tertutupService->finalisasi($request);
    }

    public function addPenguji(Request $request)
    {
        return $this->tertutupService->addPenguji($request);
    }
}
