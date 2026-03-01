<?php

namespace App\Http\Controllers\Dosen\Manajemen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Dosen\ManajemenMahasiswaDataTable;
use App\Services\Dosen\Manajemen\MahasiswaService;

class MahasiswaController extends Controller
{
    protected $mahasiswaService;

    public function __construct(MahasiswaService $mahasiswaService)
    {
        $this->mahasiswaService = $mahasiswaService;
    }

    public function index(ManajemenMahasiswaDataTable $dataTable)
    {
        return $dataTable->render('pages.dosen.manajemen.mahasiswa.index');
    }

    public function create()
    {
        return $this->mahasiswaService->create();
    }

    public function store(Request $request)
    {
        return $this->mahasiswaService->store($request);
    }
    
    public function show($id)
    {
        return $this->mahasiswaService->show($id);
    }

    public function edit($id)
    {
        return $this->mahasiswaService->edit($id);
    }

    public function update(Request $request, $id)
    {
        return $this->mahasiswaService->update($request, $id);
    }

    public function resetAccount($id)
    {
        return $this->mahasiswaService->resetAccount($id);
    }

    public function resetPassword($id)
    {
        return $this->mahasiswaService->resetPassword($id);
    }


    public function destroy($id)
    {
        return $this->mahasiswaService->destroy($id);
    }
}
