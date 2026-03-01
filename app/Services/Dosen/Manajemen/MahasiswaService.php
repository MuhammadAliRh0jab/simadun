<?php

namespace App\Services\Dosen\Manajemen;

use App\Models\DetailMahasiswa;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class MahasiswaService
{

    public function create()
    {
        return view('pages.dosen.manajemen.mahasiswa.create',);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required|string',
                'nim' => 'required|unique:mahasiswas,nim',
                'judul' => 'required|string',
                'promotors' => 'required|array|distinct|min:2',
            ],
            [
                'nama.required' => 'Nama harus diisi',
                'nim.required' => 'NIM harus diisi',
                'nim.unique' => 'NIM sudah terdaftar',
                'judul.required' => 'Judul harus diisi',
                'promotors.required' => 'Promotor harus diisi',
                'promotors.distinct' => 'Promotor tidak boleh sama',
                'promotors.min' => 'Promotor harus diisi minimal 2',
            ]
        );
        Mahasiswa::create(
            [
                'nama' => $request->nama,
                'nim' => $request->nim,
                'password' => bcrypt($request->nim),
                'judul' => $request->judul,
                'promotor_id' => $request->promotors[0],
                'co_promotor1_id' => $request->promotors[1],
                'co_promotor2_id' => $request->promotors[2] ?? null,
                'role' => 'mahasiswa',
            ]
        );
        Alert::success('Berhasil', 'Data Mahasiswa Berhasil Ditambahkan');
        return redirect()->route('dosen.manajemen.mahasiswa');
    }

    public function show($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $detail = DetailMahasiswa::where('nim', $mahasiswa->nim)->first();
        $mahasiswa->promotor1 = Dosen::select('nama')->where('id', $mahasiswa->promotor_id)->first()->nama ?? '-';
        $mahasiswa->promotor2 = Dosen::select('nama')->where('id', $mahasiswa->co_promotor1_id)->first()->nama ?? '-';
        $mahasiswa->promotor3 = Dosen::select('nama')->where('id', $mahasiswa->co_promotor2_id)->first()->nama ?? '-';

        return view('pages.dosen.manajemen.mahasiswa.show', compact('mahasiswa', 'detail'));
    }

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $detail = DetailMahasiswa::where('nim', $mahasiswa->nim)->first();
        $mahasiswa->promotor1 = Dosen::select('nama')->where('id', $mahasiswa->promotor_id)->first()->nama ?? null;
        $mahasiswa->promotor2 = Dosen::select('nama')->where('id', $mahasiswa->co_promotor1_id)->first()->nama ?? null;
        $mahasiswa->promotor3 = Dosen::select('nama')->where('id', $mahasiswa->co_promotor2_id)->first()->nama ?? null;
        return view('pages.dosen.manajemen.mahasiswa.edit', compact('mahasiswa', 'detail'));
    }


    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'nama' => 'required|string',
                'nim' => 'required|unique:mahasiswas,nim,' . $id,
                'judul' => 'required|string',
                'promotors' => 'required|array|distinct|min:2',
            ],
            [
                'nama.required' => 'Nama harus diisi',
                'nim.required' => 'NIM harus diisi',
                'nim.unique' => 'NIM sudah terdaftar',
                'judul.required' => 'Judul harus diisi',
                'promotors.required' => 'Promotor harus diisi',
                'promotors.distinct' => 'Promotor tidak boleh sama',
                'promotors.min' => 'Promotor harus diisi minimal 2',
            ]
        );
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update(
            [
                'nama' => $request->nama,
                'nim' => $request->nim,
                'judul' => $request->judul,
                'promotor_id' => $request->promotors[0],
                'co_promotor1_id' => $request->promotors[1],
                'co_promotor2_id' => $request->promotors[2] ?? null,
            ]
        );
        Alert::success('Berhasil', 'Data Mahasiswa Berhasil Diubah');
        return redirect()->route('dosen.manajemen.mahasiswa');
    }

    public function resetAccount($id){
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();
        $mahasiswa->create([
            'nama' => $mahasiswa->nama,
            'nim' => $mahasiswa->nim,
            'password' => bcrypt($mahasiswa->nim),
            'judul' => $mahasiswa->judul,
            'promotor_id' => $mahasiswa->promotor_id,
            'co_promotor1_id' => $mahasiswa->co_promotor1_id,
            'co_promotor2_id' => $mahasiswa->co_promotor2_id,
            'role' => 'mahasiswa',
        ]);
        Alert::success('Berhasil', 'Akun Mahasiswa Berhasil Direset');
        return redirect()->route('dosen.manajemen.mahasiswa');
    }

    public function resetPassword($id){
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update([
            'password' => bcrypt($mahasiswa->nim),
        ]);
        Alert::success('Berhasil', 'Password Mahasiswa Berhasil Direset');
        return redirect()->route('dosen.manajemen.mahasiswa');
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();
        Alert::success('Berhasil', 'Data Mahasiswa Berhasil Dihapus');
        return redirect()->route('dosen.manajemen.mahasiswa');
    }
}
