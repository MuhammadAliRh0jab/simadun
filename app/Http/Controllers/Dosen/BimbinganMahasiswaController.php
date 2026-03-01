<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Dosen\BimbinganMahasiswaDataTable;
use App\Services\Dosen\BimbinganService;
class BimbinganMahasiswaController extends Controller
{
    protected $bimbinganService;

    public function __construct(BimbinganService $bimbinganService)
    {
        $this->bimbinganService = $bimbinganService;
    }

    //
    public function index(BimbinganMahasiswaDataTable $dataTable)
    {
        return $dataTable->render('pages.dosen.bimbingan.index');
    }

    public function show($id)
    {
        return $this->bimbinganService->show($id);
    }
}
