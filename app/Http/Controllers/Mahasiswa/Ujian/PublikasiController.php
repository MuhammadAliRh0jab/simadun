<?php

namespace App\Http\Controllers\Mahasiswa\Ujian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Mahasiswa\Ujian\PublikasiService;
use App\Http\Requests\Ujian\PublikasiRequest;
use Illuminate\Support\Facades\Auth;

class PublikasiController extends Controller
{
    //
    protected $publikasiService;

    public function __construct(PublikasiService $publikasiService)
    {
        $this->publikasiService = $publikasiService;
        $this->middleware(function ($request, $next) {
            if (Auth::user() && Auth::user()->progress < 3) {
                alert()->error('Error', 'Harap lengkapi proses sebelumnya terlebih dahulu :)');
                return redirect()->back();
            }
            return $next($request);
        });
    }

    public function index()
    {
        return $this->publikasiService->index();
    }

    public function store(PublikasiRequest $request)
    {
        return $this->publikasiService->store($request);
    }
}
