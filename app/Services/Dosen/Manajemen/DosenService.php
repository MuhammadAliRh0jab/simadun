<?php

namespace App\Services\Dosen\Manajemen;

use App\Models\DetailDosen;
use App\Models\Dosen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class DosenService
{

    public function create()
    {
        return view('pages.dosen.manajemen.dosen.create',);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required|string',
                'no_induk' => 'required|unique:dosens,no_induk',
                'email' => 'required|email|unique:dosens,email',
                'pangkat_gol' => 'required|string',
                'role' => 'required|in:kaprodi,dosen,eksternal',
            ],
            [
                'nama.required' => 'Nama harus diisi',
                'no_induk.required' => 'Nomor Induk harus diisi',
                'no_induk.unique' => 'Nomor Induk sudah terdaftar',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'pangkat_gol.required' => 'Pangkat Golongan harus diisi',
                'role.required' => 'Role harus diisi',
                'role.in' => 'Role tidak valid',
            ]
        );
        $dosen = Dosen::create(
            [
                'nama' => $request->nama,
                'no_induk' => $request->no_induk,
                'email' => $request->email,
                'pangkat_gol' => $request->pangkat_gol,
                'role' => $request->role,
                'password' => bcrypt($request->no_induk),
            ]
        );
        Alert::success('Berhasil', 'Data Dosen Berhasil Ditambahkan');
        return redirect()->route('dosen.manajemen.dosen');
    }

    public function show($id)
    {
        $dosen = Dosen::findOrFail($id);
        return view('pages.dosen.manajemen.dosen.show', compact('dosen'));
    }

    public function edit($id)
    {
        $dosen = Dosen::findOrFail($id);
        return view('pages.dosen.manajemen.dosen.edit', compact('dosen'));
    }


    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'nama' => 'required|string',
                'no_induk' => 'required|unique:dosens,no_induk,' . $id,
                'email' => 'required|email|unique:dosens,email,' . $id,
                'pangkat_gol' => 'required|string',
                'role' => 'required|in:kaprodi,dosen,eksternal',
            ],
            [
                'nama.required' => 'Nama harus diisi',
                'no_induk.required' => 'Nomor Induk harus diisi',
                'no_induk.unique' => 'Nomor Induk sudah terdaftar',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'pangkat_gol.required' => 'Pangkat Golongan harus diisi',
                'role.required' => 'Role harus diisi',
                'role.in' => 'Role tidak valid',
            ]
        );
        $dosen = Dosen::findOrFail($id);
        $dosen->update($request->all());
        Alert::success('Berhasil', 'Data Dosen Berhasil Diubah');
        return redirect()->route('dosen.manajemen.dosen');
    }

    public function resetPassword($id)
    {
        $dosen = Dosen::findOrFail($id);
        $dosen->update([
            'password' => bcrypt($dosen->nim),
        ]);
        Alert::success('Berhasil', 'Password Dosen Berhasil Direset');
        return redirect()->route('dosen.manajemen.dosen');
    }

    public function destroy($id)
    {
        $dosen = Dosen::findOrFail($id);
        $dosen->delete();
        Alert::success('Berhasil', 'Data Dosen Berhasil Dihapus');
        return redirect()->route('dosen.manajemen.dosen');
    }
}
