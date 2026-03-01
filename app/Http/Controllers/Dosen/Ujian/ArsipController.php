<?php

namespace App\Http\Controllers\Dosen\Ujian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Dosen\ArsipDataTable;
use App\Services\Dosen\Ujian\ArsipService;
class ArsipController extends Controller
{
    protected $arsipService;

    public function __construct(ArsipService $arsipService)
    {
        $this->arsipService = $arsipService;
    }

    //
    public function index(ArsipDataTable $dataTable)
    {
        return $dataTable->render('pages.dosen.ujian.arsip.index');
    }

    public function show($id)
    {
        return $this->arsipService->show($id);
    }
}
