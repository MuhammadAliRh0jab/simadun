<?php

namespace App\Http\Controllers\Mahasiswa\Ujian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Ujian\ProposalRequest;
use App\Services\Mahasiswa\Ujian\DisertasiService;
use Illuminate\Support\Facades\Auth;

class DisertasiController extends Controller
{
    protected $disertasiService;

    public function __construct(DisertasiService $disertasiService)
    {
        $this->disertasiService = $disertasiService;
        $this->middleware(function ($request, $next) {
            if (Auth::user() && Auth::user()->progress < 4) {
                alert()->error('Error', 'Harap lengkapi proses sebelumnya terlebih dahulu :)');
                return redirect()->back();
            }
            return $next($request);
        });
    }

    public function index()
    {
        return $this->disertasiService->index();
    }

    public function store(ProposalRequest $request)
    {
        return $this->disertasiService->store($request);
    }

    public function update(Request $request)
    {
        return $this->disertasiService->update($request);
    }
}
