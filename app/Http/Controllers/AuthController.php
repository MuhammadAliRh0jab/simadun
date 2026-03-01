<?php

namespace App\Http\Controllers;

use App\Helpers\AuthHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailMahasiswa;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\pass_rest_token;
use App\Models\pass_rest_token2;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\authResetPass;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function ShowChangeDsn(Request $no_induk){
        try {
            $user = Auth::guard('dosen')->user();
            $getDatadsn = Dosen::where('no_induk', $user->no_induk)->first();
            // dd($getDataMhs);
            return view('pages.dosen.profile.formEditPass', compact('getDatadsn'));
        } catch (\Exception $e) {
            // Handle the exception here
            return back()->with('error', $e->getMessage());
        }
    }
    public function ShowChangeMhs(Request $nim){
        try {
            $user = Auth::user();
            $getDataMhs = Mahasiswa::where('nim', $user->nim)->first();
            // dd($getDataMhs);
            return view('pages.mahasiswa.profile.formEditPass', compact('getDataMhs'));
        } catch (\Exception $e) {
            // Handle the exception here
            return back()->with('error', $e->getMessage());
        }
    }

    public function saveChangePassDsn(Request $request){

        DB::enableQueryLog();
        $getDataMhs = Dosen::where('no_induk', $request->nim)->first();
        $getDataMhs->password = bcrypt($request->pass_1);
        $getDataMhs->save();
        // $queryLog = DB::getQueryLog();
        // Log::info('Query terakhir:', ['query' => end($queryLog)]);
        $getDataMhss = User::where('username', $request->nim)->first();
        $getDataMhss->password = bcrypt($request->pass_1);
        $getDataMhss->save();
        $queryLog = DB::getQueryLog();
        Log::info('Query terakhir:', ['query' => end($queryLog)]);
        return redirect()->route('profile.index')->with('success', 'Password berhasil diubah');
    }

    public function saveChangePassMhs(Request $request){

        $getDataMhs = Mahasiswa::where('nim', $request->nim)->first();
        $getDataMhs->password = bcrypt($request->pass_1);
        $getDataMhs->save();
        $getDataMhss = User::where('username', $request->nim)->first();
        $getDataMhss->password = bcrypt($request->pass_1);
        $getDataMhss->save();
        return redirect()->route('profile.index')->with('success', 'Password berhasil diubah');
    }

    public function forgot_password()
    {
        return view('pages.mahasiswa.profile.ChangePass');
    }


    public function val_forgot_act(Request $request){
        $token = pass_rest_token::where('token', $request->token)->first();
        if (!$token) {
            return redirect()->route('auth.login')->with('error', 'Token tidak valid, kirim ulang email');
        }
        $dosen = $request->is_dosen;
        if ($dosen == 'dosen') {
            // dd($request);
            $dosen = Dosen::where('email', $request->email)->first();
            if(!$dosen){
                return redirect()->route('auth.login')->with('error', 'Email tidak terdaftar');
                $tokenss = $request->token;
                pass_rest_token::where('token', $tokenss)->delete();
            }
            $dosen->update([
                'password' => bcrypt($request->pass_1)
            ]);
            $tokenss = $request->token;
            pass_rest_token::where('token', $tokenss)->delete();

        }elseif ($dosen == NULL) {

            $detailMhs = DetailMahasiswa::where('email_um', $request->email)->first();
            // dd($detailMhs);
            if(!$detailMhs){
                return redirect()->route('auth.login')->with('error', 'Email tidak terdaftar');
                $tokenss = $request->token;
                pass_rest_token::where('token', $tokenss)->delete();
            }

            $mahasiswa = Mahasiswa::where('nim', $detailMhs->nim)->first();
            if(!$mahasiswa){
                return redirect()->route('auth.login')->with('error', 'Email tidak terdaftar');
                $tokenss = $request->token;
                pass_rest_token::where('token', $tokenss)->delete();
            }

            // dd($request->all());
            $mahasiswa->update([
                'password' => bcrypt($request->pass_2)
            ]);

            $tokenss = $request->token;
            pass_rest_token::where('token', $tokenss)->delete();

        }else{
            return redirect()->route('auth.login')->with('error', 'Terjadi kesalahan');
            $tokenss = $request->token;
            pass_rest_token::where('token', $tokenss)->delete();
        }

        $tokenss = $request->token;
        pass_rest_token::where('token', $tokenss)->delete();
        return redirect()->route('auth.login')->with('success', 'Password berhasil diubah');
    }


    // halaman find account
    public function lupaPassword()
    {
        return view('pages.auth.forgot');
    }

    public function val_forgot(Request $request, $getToken)
    {

        $token = pass_rest_token2::where('token', $getToken)->first();

        // dd($request);
        if (!$token) {
            return redirect()->route('halaman.lupa-password')->with('status', 'Token tidak valid, kirim ulang email');
        }

        return view('pages.auth.ChangePass', compact('token'));
    }


    // find account
    public function forgot_password_act(Request $request)
{
    try {
        // Generate a random token
        $token = Str::random(60);

        // Update or create a record in pass_reset_tokens table
        pass_rest_token::updateOrCreate(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => now()
            ]
        );

        // Send password reset email
        Mail::to($request->email)->send(new authResetPass($token));

        return redirect()->route('halaman.lupa-password')->with('status', 'Silahkan cek email anda');
    } catch (\Exception $e) {
        return back()->withErrors([
            'status' => 'Terjadi kesalahan pada server.',
        ]);
    }
}

    public function login()
    {
        return view('pages.auth.login');
    }

    public function store(Request $request)
    {
        try {
            $request->session()->regenerate();
            $user = AuthHelper::getUser($request->no_induk, $request->password);

            if (!$user) {
                return back()->withErrors([
                    'creds' => 'NIP/NIK/NIM atau kata sandi salah.',
                ]);
            }

            // sign in the user
            auth()->guard($user instanceof Dosen ? 'dosen' : 'mahasiswa')->login($user);

            // check whether the user needs to change their password
            if (AuthHelper::getRole() == 'dosen') {
                if ($request->password == $request->no_induk) {
                    return redirect()->route('dosen.home');
                }

                return redirect()->route('dosen.home');
            } else {
                if ($request->password == $request->nim) {
                    return redirect()->route('mahasiswa.home');
                }

                return redirect()->route('mahasiswa.home');
            }
        } catch (\Exception) {
            return back()->withErrors([
                'creds' => 'Terjadi kesalahan pada server.',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }

    public function password()
    {
        return view('pages.auth.password');
    }

    public function updatePassword(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'password' => 'required|confirmed|min:6|regex:/^(?=.*[A-Z])(?=.*\d)/',
        ]);

        $isDosen = $request->is_dosen === 'dosen';
        $column = $isDosen ? 'no_induk' : 'nim';

        if (Auth::guard($isDosen ? 'dosen' : 'mahasiswa')->user() !== null) {
            // ganti password
            if ($isDosen) {
                $user = Dosen::where('no_induk', Auth::guard('dosen')->user()->no_induk)->first();
                $user->password = bcrypt($request->password);
                $user->save();
            } else {
                $user = Mahasiswa::where('nim', Auth::guard('mahasiswa')->user()->nim)->first();
                $user->password = bcrypt($request->password);
                $user->save();
            }
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('auth.login')->with('success', 'Password berhasil diubah.');
        } else {
            return back()->withErrors([
                'password' => 'Terjadi kesalahan pada server.',
            ]);
        }
    }
}
