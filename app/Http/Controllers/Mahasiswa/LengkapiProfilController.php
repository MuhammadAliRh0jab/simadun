<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Helpers\AuthHelper;
use App\Helpers\HttpResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mahasiswa\LengkapiProfile\StoreLengkapiProfileRequest;
use Illuminate\Http\Request;

class LengkapiProfilController extends Controller
{
    public function index()
    {
        // if user data is existed, redirect to dashboard
        if (AuthHelper::user()->detail) {
            return redirect()->route('mahasiswa.home');
        }

        return view('pages.mahasiswa.lengkapi-profil.index');
    }

    public function store(StoreLengkapiProfileRequest $request)
    {
        $user = AuthHelper::user();
        $user->detail()->create($request->validated());

        // update judul dan promotor
        $user->judul = $request->judul;

        $usulanPromotor = $request->usulan_promotor;

        // split promotor by comma
        $promotor = explode(',', $usulanPromotor);
        $counter = count($promotor);

        for($i = 0; $i < $counter; $i++) {
            if ($i == 0) {
                $user->promotor_id = $promotor[$i];
            } else if ($i == 1) {
                $user->co_promotor1_id = $promotor[$i];
            } else if ($i == 2) {
                $user->co_promotor2_id = $promotor[$i];
            }
        }

        $user->save();

        return HttpResponse::success(200, 'Profil berhasil dilengkapi');
    }
}
