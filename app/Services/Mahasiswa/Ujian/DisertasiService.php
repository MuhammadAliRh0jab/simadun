<?php

namespace App\Services\Mahasiswa\Ujian;

use App\Models\PendaftaranUjian;
use App\Models\Dosen;
use App\Models\JadwalUjian;
use App\Models\KomentarUjian;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DisertasiService
{
    public function index()
    {
        $nim = auth()->user()->nim;
        $user = auth()->user();
        if (!$nim) {
            throw new \Exception('NIM tidak ditemukan', 404);
        }

        $disertasi = PendaftaranUjian::where('nim', $nim)->where('jenis_ujian', 'disertasi')->first();
        if ($disertasi) {
            $disertasi->usulan_penguji1 = Dosen::where('id', $disertasi->penguji1_id)->first()->nama;
            $disertasi->usulan_penguji2 = Dosen::where('id', $disertasi->penguji2_id)->first()->nama;
            $disertasi->usulan_penguji3 = $disertasi->penguji3_id ? Dosen::where('id', $disertasi->penguji3_id)->first()->nama : '-';
        }

        // Jadwal ujian
        $jadwal_ujian = JadwalUjian::where('pendaftaran_ujian_id', $disertasi->id ?? null)->first();
        if ($jadwal_ujian) {
            $jadwal_ujian->penguji1 = Dosen::where('id', $jadwal_ujian->penguji1_id)->first()->nama;
            $jadwal_ujian->penguji2 = Dosen::where('id', $jadwal_ujian->penguji2_id)->first()->nama;
            $jadwal_ujian->penguji3 = $jadwal_ujian->penguji3_id ? Dosen::where('id', $jadwal_ujian->penguji3_id)->first()->nama : null;
        }

        if ($disertasi && $jadwal_ujian) {
            $disertasi->komentar1 = KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $disertasi->id)->where('dosen_id', $jadwal_ujian->penguji1_id)->value('komentar');
            $disertasi->komentar2 = KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $disertasi->id)->where('dosen_id', $jadwal_ujian->penguji2_id)->value('komentar');
            $disertasi->komentar3 = $jadwal_ujian->penguji3_id ? KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $disertasi->id)->where('dosen_id', $jadwal_ujian->penguji3_id)->value('komentar') : null;
            $disertasi->komentar4 = KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $disertasi->id)->where('dosen_id', $user->promotor_id)->value('komentar');
            $disertasi->komentar5 = KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $disertasi->id)->where('dosen_id', $user->co_promotor1_id)->value('komentar');
            $disertasi->komentar6 = KomentarUjian::select('komentar')->where('role', 'kaprodi')->where('pendaftaran_ujian_id', $disertasi->id)->value('komentar');
            $disertasi->komentar7 = $user->co_promotor2_id ? KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $disertasi->id)->where('dosen_id', $user->co_promotor2_id)->value('komentar') : null;

            // Is penilaian all done
            $disertasi->is_penilaian_done = $disertasi->nilai_penguji1 != null &&
                                            $disertasi->nilai_penguji2 != null &&
                                            ($jadwal_ujian->penguji3_id == null || $disertasi->nilai_penguji3 != null) &&
                                            $disertasi->nilai_promotor != null &&
                                            $disertasi->nilai_co_promotor1 != null &&
                                            ($user->co_promotor2_id == null || $disertasi->nilai_co_promotor2 != null) &&
                                            $disertasi->nilai_kaprodi != null;
        }

        return view('pages.mahasiswa.ujian.disertasi', compact('disertasi', 'jadwal_ujian'));
    }

    public function store($request)
    {
        $nim = auth()->user()->nim;
        if (!$nim) {
            throw new \Exception('NIM tidak ditemukan', 404);
        }

        $penguji1_id = $request->usulan_penguji[0];
        $penguji2_id = $request->usulan_penguji[1];
        $penguji3_id = isset($request->usulan_penguji[2]) ? $request->usulan_penguji[2] : null; // Optional third examiner

        PendaftaranUjian::create([
            'nim' => $nim,
            'jenis_ujian' => 'disertasi',
            'penguji1_id' => $penguji1_id,
            'penguji2_id' => $penguji2_id,
            'penguji3_id' => $penguji3_id,
            'kaprodi_id' => 1, // Test value
            'file' => $request->naskah,
            'status' => '2'
        ]);

        $maha = Mahasiswa::where('nim', $nim)->first();
        $maha->progress = '1';
        Alert::success('Berhasil', 'Pendaftaran disertasi berhasil');
        return redirect()->route('ujian.disertasi');
    }

    public function update($request)
    {
        $request->validate([
            'id_pendaftaran' => 'required|numeric',
            'naskah_revisi' => 'required'
        ], [
            'id_pendaftaran.required' => 'Pendaftaran tidak valid',
            'id_pendaftaran.numeric' => 'Pendaftaran tidak valid',
            'naskah_revisi.required' => 'File revisi harus diisi',
        ]);

        $nim = auth()->user()->nim;
        if (!$nim) {
            throw new \Exception('NIM tidak ditemukan', 404);
        }

        $pendaftaran = PendaftaranUjian::findOrFail($request->id_pendaftaran);
        $pendaftaran->file = $request->naskah_revisi;
        $pendaftaran->status = '5';
        $pendaftaran->save();

        Alert::success('Berhasil', 'Revisi disertasi berhasil diajukan');
        return redirect()->route('ujian.disertasi');
    }

    public function destroy($id)
    {
    }
}