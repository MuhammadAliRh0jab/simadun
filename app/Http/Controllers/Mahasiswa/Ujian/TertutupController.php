<?php

namespace App\Http\Controllers\Mahasiswa\Ujian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Mahasiswa\Ujian\TertutupService;
use App\Http\Requests\Ujian\DisertasiTertutupRequest;
use Illuminate\Support\Facades\Auth;

class TertutupController extends Controller
{
    protected $tertutupService;

    public function __construct(TertutupService $tertutupService)
    {
        $this->tertutupService = $tertutupService;
        $this->middleware(function ($request, $next) {
            if (Auth::user() && Auth::user()->progress < 5) {
                alert()->error('Error', 'Harap lengkapi proses sebelumnya terlebih dahulu :)');
                return redirect()->back();
            }
            return $next($request);
        });
    }

    public function index()
    {
        return $this->tertutupService->index();
    }

    public function store(DisertasiTertutupRequest $request)
    {
        return $this->tertutupService->store($request);
    }

    public function update(Request $request)
    {
        return $this->tertutupService->update($request);
    }
}
