<?php

namespace App\Services\Dosen\Ujian;

use App\Models\PendaftaranUjian;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\JadwalUjian;
use App\Models\KomentarUjian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class DisertasiService
{
    public function store($request, $disertasiId)
    {
        $disertasi = PendaftaranUjian::findOrFail($disertasiId);
        JadwalUjian::create([
            'pendaftaran_ujian_id' => $disertasiId,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'ruangan' => $request->ruangan,
            'penguji1_id' => $request->penguji[0],
            'penguji2_id' => $request->penguji[1],
            'penguji3_id' => isset($request->penguji[2]) ? $request->penguji[2] : null, // Optional third examiner
            'penguji_eks_id' => null,
        ]);

        $disertasi->status = '3';
        $disertasi->save();

        Alert::success('Berhasil', 'Status disertasi berhasil diubah');
        return redirect()->route('dosen.ujian.disertasi');
    }

    public function show($id)
    {
        $disertasi = PendaftaranUjian::findOrFail($id);
        $mahasiswa = Mahasiswa::where('nim', $disertasi->nim)->first();
        $jadwal_ujian = JadwalUjian::where('pendaftaran_ujian_id', $id)->first();

        // Promotor
        $mahasiswa->promotor1 = Dosen::select('nama')->where('id', $mahasiswa->promotor_id)->first()->nama;
        $mahasiswa->promotor2 = Dosen::select('nama')->where('id', $mahasiswa->co_promotor1_id)->first()->nama;
        $mahasiswa->promotor3 = Dosen::select('nama')->where('id', $mahasiswa->co_promotor2_id)->first()->nama ?? '-';

        // Usulan penguji
        $disertasi->usulan_penguji1 = Dosen::where('id', $disertasi->penguji1_id)->first()->nama;
        $disertasi->usulan_penguji2 = Dosen::where('id', $disertasi->penguji2_id)->first()->nama;
        $disertasi->usulan_penguji3 = $disertasi->penguji3_id ? Dosen::where('id', $disertasi->penguji3_id)->first()->nama : '-';

        if ($jadwal_ujian) {
            // Penguji
            $jadwal_ujian->penguji1 = Dosen::where('id', $jadwal_ujian->penguji1_id)->first()->nama;
            $jadwal_ujian->penguji2 = Dosen::where('id', $jadwal_ujian->penguji2_id)->first()->nama;
            $jadwal_ujian->penguji3 = $jadwal_ujian->penguji3_id ? Dosen::where('id', $jadwal_ujian->penguji3_id)->first()->nama : null;

            // Dosens komentars
            $disertasi->komentar1 = KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $id)->where('dosen_id', $jadwal_ujian->penguji1_id)->value('komentar');
            $disertasi->komentar2 = KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $id)->where('dosen_id', $jadwal_ujian->penguji2_id)->value('komentar');
            $disertasi->komentar3 = $jadwal_ujian->penguji3_id ? KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $id)->where('dosen_id', $jadwal_ujian->penguji3_id)->value('komentar') : null;
            $disertasi->komentar4 = KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $id)->where('dosen_id', $mahasiswa->promotor_id)->value('komentar');
            $disertasi->komentar5 = KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $id)->where('dosen_id', $mahasiswa->co_promotor1_id)->value('komentar');
            $disertasi->komentar6 = KomentarUjian::select('komentar')->where('role', 'kaprodi')->where('pendaftaran_ujian_id', $id)->value('komentar');
            $disertasi->komentar7 = $mahasiswa->co_promotor2_id ? KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $id)->where('dosen_id', $mahasiswa->co_promotor2_id)->value('komentar') : null;

            // Is penilaian all done
            $disertasi->is_penilaian_done = $disertasi->nilai_penguji1 != null &&
                                            $disertasi->nilai_penguji2 != null &&
                                            ($jadwal_ujian->penguji3_id == null || $disertasi->nilai_penguji3 != null) &&
                                            $disertasi->nilai_promotor != null &&
                                            $disertasi->nilai_co_promotor1 != null &&
                                            ($mahasiswa->co_promotor2_id == null || $disertasi->nilai_co_promotor2 != null) &&
                                            $disertasi->nilai_kaprodi != null;

            $jadwal_ujian->penilaian = date('Y-m-d H:i:s') >= Carbon::parse($jadwal_ujian->tanggal)->format('Y-m-d') . ' ' . $jadwal_ujian->jam;
        }

        return view('pages.dosen.ujian.disertasi.show', compact('disertasi', 'mahasiswa', 'jadwal_ujian'));
    }

    public function finalisasi($request)
    {
        $request->validate(
            [
                'mahasiswa_id' => 'required|numeric',
                'disertasi_id' => 'required|numeric',
                'role' => 'required|string|in:kaprodi',
                'status' => 'required|string|in:layak,revisi',
                'jenis_ujian' => 'required|string|in:disertasi'
            ],
            [
                'mahasiswa_id.required' => 'Tidak valid',
                'mahasiswa_id.numeric' => 'Tidak valid',
                'disertasi_id.required' => 'Ujian tidak valid',
                'disertasi_id.numeric' => 'Ujian tidak valid',
                'role.required' => 'Role tidak valid',
                'role.string' => 'Role tidak valid',
                'role.in' => 'Role tidak valid',
                'status.required' => 'Status tidak valid',
                'status.string' => 'Status tidak valid',
                'status.in' => 'Status harus berupa layak atau revisi',
                'jenis_ujian.required' => 'Jenis ujian tidak valid',
                'jenis_ujian.string' => 'Jenis ujian tidak valid',
                'jenis_ujian.in' => 'Jenis ujian tidak valid'
            ]
        );

        $disertasi = PendaftaranUjian::findOrFail($request->disertasi_id);
        $mahasiswa = Mahasiswa::findOrFail($request->mahasiswa_id);
        $disertasi->status = $request->status == 'layak' ? '6' : '4';
        $disertasi->save();
        $mahasiswa->progress = $request->status == 'layak' ? '5' : '4';
        $mahasiswa->save();

        return response()->json(['message' => 'Nilai berhasil ditambahkan'], 200);
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}