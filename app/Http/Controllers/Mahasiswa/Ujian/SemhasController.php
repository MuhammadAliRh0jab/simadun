<?php

namespace App\Http\Controllers\Mahasiswa\Ujian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Mahasiswa\Ujian\SemhasService;
use App\Http\Requests\Ujian\ProposalRequest;
use Illuminate\Support\Facades\Auth;

class SemhasController extends Controller
{
    protected $semhasService;

    public function __construct(SemhasService $semhasService)
    {
        $this->semhasService = $semhasService;
        $this->middleware(function ($request, $next) {
            if (Auth::user() && Auth::user()->progress < 2) {
                alert()->error('Error', 'Harap lengkapi proses sebelumnya terlebih dahulu :)');
                return redirect()->back();
            }
            return $next($request);
        });
    }

    public function index()
    {
        return $this->semhasService->index();
    }

    public function store(ProposalRequest $request)
    {
        return $this->semhasService->store($request);
    }

    public function update(Request $request)
    {
        return $this->semhasService->update($request);
    }
}
