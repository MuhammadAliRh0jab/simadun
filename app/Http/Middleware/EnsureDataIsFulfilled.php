<?php

namespace App\Http\Middleware;

use App\Helpers\AuthHelper;
use App\Models\DetailMahasiswa;
use App\Models\Mahasiswa;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDataIsFulfilled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $excludeRoute = [
            'isi-profile',
            'updateProfile',
            'password',
            'updatePassword',
            'mahasiswa.lengkapi-profil.index',
            'search.dosen'
        ];

        $user = AuthHelper::user();
        if ($user instanceof Mahasiswa) {
            $data = DetailMahasiswa::where('nim', $user->nim)->first();
            if (!$data) {
                if (!in_array($request->route()->getName(), $excludeRoute) && $request->method() != 'POST') {
                    return redirect('/lengkapi-profil')->with('warning', 'Anda belum melengkapi data. Silakan lengkapi data Anda terlebih dahulu.');
                }
            }
        }
        return $next($request);
    }
}
