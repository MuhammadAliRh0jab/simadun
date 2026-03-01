<?php

namespace App\Http\Middleware;

use Closure;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {

        $user = Auth::user() ?? Auth::guard('dosen')->user();
        if (!$user) {
            Alert::error('Unauthorized', 'Harap login terlebih dahulu');
            return redirect()->route('auth.login');
        }
        if ($user && in_array($user->role, $roles)) {
            return $next($request);
        }
        Alert::error('Unauthorized', 'Anda tidak memiliki akses ke halaman tersebut');
        return redirect()->back();
    }
}
