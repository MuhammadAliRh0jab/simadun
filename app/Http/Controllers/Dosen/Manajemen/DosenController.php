<?php

namespace App\Http\Controllers\Dosen\Manajemen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Dosen\ManajemenDosenDataTable;
use App\Services\Dosen\Manajemen\DosenService;
use App\Models\Dosen;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DosenController extends Controller
{
    protected $dosenService;

    public function __construct(DosenService $dosenService)
    {
        $this->dosenService = $dosenService;
    }

    public function index(ManajemenDosenDataTable $dataTable)
    {
        return $dataTable->render('pages.dosen.manajemen.dosen.index');
    }

    public function create(){
        return $this->dosenService->create();
    }

    public function store(Request $request){
        return $this->dosenService->store($request);
    }

    public function show($id){
        return $this->dosenService->show($id);
    }

    public function edit($id){
        return $this->dosenService->edit($id);
    }

    public function update(Request $request, $id){
        return $this->dosenService->update($request, $id);
    }

    public function destroy($id){
        return $this->dosenService->destroy($id);
    }

    public function resetPassword($id)
    {
        DB::enableQueryLog();
        $dosen = Dosen::findOrFail($id);
        $dosen->update([
            'password' => bcrypt($dosen->no_induk),
        ]);
        $dosen = Dosen::findOrFail($id);
        $user = User::where('username', $dosen->no_induk)->first();
        if ($user) {
            $user->update([
            'password' => bcrypt($dosen->no_induk),
            Alert::success('Berhasil', 'Password Dosen Berhasil Direset')
            ]);
        } else {
            Alert::success('Gagal blok', 'Password Dosen Berhasil Direset');
        };
        $queryLog = DB::getQueryLog();
        Log::info('Query terakhir:', ['query' => end($queryLog)]);
        Log::info('Dosen ditemukan:', ['dosen' => $dosen]);
        return redirect()->route('dosen.manajemen.dosen');
    }

}
