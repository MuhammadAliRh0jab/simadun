<?php

namespace App\Services\Dosen;

use App\Models\PendaftaranUjian;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\JadwalUjian;
use App\Models\KomentarUjian;
use App\Models\PublikasiConference;
use App\Models\PublikasiJurnal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UjianTerjadwalService
{
    public function penilaian($request)
    {
        $request->validate(
            [
                'nim' => 'required|integer',
                'ujian_id' => 'required|integer',
                'jenis_ujian' => 'required|string',
                'nilai' => 'integer|min:1|max:100',
                'catatan' => 'string|required',
                'dosen' => 'required|string|in:' . $this->checkDosen(Auth::guard('dosen')->user()->id, $request->nim, $request->ujian_id, $request->dosen),
                'role' => 'required|string|in:dosen,kaprodi'
            ],
            [
                'catatan.required' => 'Catatan harus diisi',
                'nilai.min' => 'Nilai minimal 1',
                'nilai.max' => 'Nilai maksimal 100',
                'dosen.required' => 'Dosen tidak valid',
                'dosen.in' => 'Dosen tidak terdaftar'
            ]
        );

        $ujian = PendaftaranUjian::findOrFail($request->ujian_id);
        if ($request->dosen == 'Promotor') {
            $ujian->nilai_promotor = $request->nilai;
        } elseif ($request->dosen == 'CO-Promotor 1') {
            $ujian->nilai_co_promotor1 = $request->nilai;
        } elseif ($request->dosen == 'CO-Promotor 2') {
            $ujian->nilai_co_promotor2 = $request->nilai;
        } elseif ($request->dosen == 'Penguji 1') {
            $ujian->nilai_penguji1 = $request->nilai;
        } elseif ($request->dosen == 'Penguji 2') {
            $ujian->nilai_penguji2 = $request->nilai;
        } elseif ($request->dosen == 'Penguji 3') {
            $ujian->nilai_penguji3 = $request->nilai;
        } elseif ($request->dosen == 'kaprodi') {
            $ujian->nilai_kaprodi = $request->nilai;
        } elseif ($request->dosen == 'eksternal') {
            $ujian->nilai_penguji_eks = $request->nilai;
        }

        KomentarUjian::create([
            'pendaftaran_ujian_id' => $request->ujian_id,
            'role' => $request->role,
            'dosen_id' => Auth::guard('dosen')->user()->id,
            'komentar' => $request->catatan
        ]);

        $ujian->save();

        return response()->json(['message' => 'Nilai berhasil ditambahkan'], 200);
    }

    public function show($id)
    {
        $proposal = PendaftaranUjian::findOrFail($id);
        $mahasiswa = Mahasiswa::where('nim', $proposal->nim)->first();
        $jadwal_ujian = JadwalUjian::where('pendaftaran_ujian_id', $id)->first();

        // Promotor
        $mahasiswa->promotor1 = Dosen::select('nama')->where('id', $mahasiswa->promotor_id)->first()->nama;
        $mahasiswa->promotor2 = Dosen::select('nama')->where('id', $mahasiswa->co_promotor1_id)->first()->nama;
        $mahasiswa->promotor3 = $mahasiswa->co_promotor2_id ? Dosen::select('nama')->where('id', $mahasiswa->co_promotor2_id)->first()->nama : '-';

        // Usulan penguji
        $proposal->usulan_penguji1 = Dosen::where('id', $proposal->penguji1_id)->first()->nama;
        $proposal->usulan_penguji2 = Dosen::where('id', $proposal->penguji2_id)->first()->nama;
        $proposal->usulan_penguji3 = $proposal->penguji3_id ? Dosen::where('id', $proposal->penguji3_id)->first()->nama : '-';

        // Penguji
        if ($jadwal_ujian) {
            $jadwal_ujian->penguji1 = Dosen::where('id', $jadwal_ujian->penguji1_id)->first()->nama;
            $jadwal_ujian->penguji2 = Dosen::where('id', $jadwal_ujian->penguji2_id)->first()->nama;
            $jadwal_ujian->penguji3 = $jadwal_ujian->penguji3_id ? Dosen::where('id', $jadwal_ujian->penguji3_id)->first()->nama : null;
        }

        // Current dosen komentar (if exists)
        $proposal->komentar = KomentarUjian::select('komentar')->where('pendaftaran_ujian_id', $id)->where('dosen_id', Auth::guard('dosen')->user()->id)->first();

        // If jenis is publikasi
        if ($proposal->jenis_ujian == 'publikasi') {
            $proposal->publikasi_jurnal = PublikasiJurnal::where('nim', $mahasiswa->nim)->get();
            $proposal->publikasi_conference = PublikasiConference::where('nim', $mahasiswa->nim)->get();
        }

        // Current user nilai based on dosen
        $role = $this->checkDosen(Auth::guard('dosen')->user()->id, $proposal->nim, $proposal->id, null);
        if ($role == 'Promotor') {
            $proposal->nilai = $proposal->nilai_promotor;
        } elseif ($role == 'CO-Promotor 1') {
            $proposal->nilai = $proposal->nilai_co_promotor1;
        } elseif ($role == 'CO-Promotor 2') {
            $proposal->nilai = $proposal->nilai_co_promotor2;
        } elseif ($role == 'Penguji 1') {
            $proposal->nilai = $proposal->nilai_penguji1;
        } elseif ($role == 'Penguji 2') {
            $proposal->nilai = $proposal->nilai_penguji2;
        } elseif ($role == 'Penguji 3') {
            $proposal->nilai = $proposal->nilai_penguji3;
        } elseif ($role == 'eksternal') {
            $proposal->nilai = $proposal->nilai_penguji_eks;
        }

        $dosen = $this->checkDosen(Auth::guard('dosen')->user()->id, $proposal->nim, $proposal->id, null);
        // var penilaian true/false to check if current day hour is more than hour in jadwal_ujian
        $jadwal_ujian ? $jadwal_ujian->penilaian = date('Y-m-d H:i:s') >= Carbon::parse($jadwal_ujian->tanggal)->format('Y-m-d') . ' ' . $jadwal_ujian->jam : '';

        return view('pages.dosen.ujian_terjadwal.show', compact('proposal', 'mahasiswa', 'jadwal_ujian', 'dosen'));
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }

    private function checkDosen($idDosen, $nim, $idPendaftaranUjian, $isKaprodi = null)
    {
        if ($isKaprodi == 'kaprodi') {
            return 'kaprodi';
        }
        
        // First check if dosen is penguji regardless of whether they're eksternal or not
        $penguji = JadwalUjian::where('pendaftaran_ujian_id', $idPendaftaranUjian)
            ->where(function ($query) use ($idDosen) {
                $query->where('penguji1_id', $idDosen)
                    ->orWhere('penguji2_id', $idDosen)
                    ->orWhere('penguji3_id', $idDosen);
            })->first();
        
        if ($penguji) {
            if ($penguji->penguji1_id == $idDosen) {
                return 'Penguji 1';
            } elseif ($penguji->penguji2_id == $idDosen) {
                return 'Penguji 2';
            } elseif ($penguji->penguji3_id == $idDosen) {
                return 'Penguji 3';
            }
        }
        
        // Check if dosen is promotor/co-promotor
        $mahasiswa = Mahasiswa::where('nim', $nim)
            ->where(function ($query) use ($idDosen) {
                $query->where('promotor_id', $idDosen)
                    ->orWhere('co_promotor1_id', $idDosen)
                    ->orWhere('co_promotor2_id', $idDosen);
            })->first();
        
        if ($mahasiswa) {
            if ($mahasiswa->promotor_id == $idDosen) {
                return 'Promotor';
            } elseif ($mahasiswa->co_promotor1_id == $idDosen) {
                return 'CO-Promotor 1';
            } elseif ($mahasiswa->co_promotor2_id == $idDosen) {
                return 'CO-Promotor 2';
            }
        }
        
        // If they haven't been assigned a specific role but they are eksternal
        if (Auth::guard('dosen')->user()->role == 'eksternal') {
            return 'eksternal';
        }
        
        // If none of the above conditions are met
        return \abort(403, 'Anda tidak berhak mengakses halaman ini');
    }
}