<?php

namespace App\Services\Mahasiswa\Ujian;

use App\Models\PendaftaranUjian;
use App\Models\Dosen;
use App\Models\JadwalUjian;
use App\Models\KomentarUjian;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SemhasService
{
    public function index()
    {
        $nim = auth()->user()->nim;
        $user = auth()->user();
        if (!$nim) {
            throw new \Exception('NIM tidak ditemukan', 404);
        }
        $semhas = PendaftaranUjian::where('nim', $nim)->where('jenis_ujian', 'semhas')->first();
        $semhas ? $semhas->usulan_penguji1 = Dosen::where('id', $semhas->penguji1_id)->first()->nama : '';
        $semhas ? $semhas->usulan_penguji2 = Dosen::where('id', $semhas->penguji2_id)->first()->nama : '';
        $semhas ? $semhas->usulan_penguji3 = $semhas->penguji3_id ? Dosen::where('id', $semhas->penguji3_id)->first()->nama : null : '';

        // Jadwal ujian
        $jadwal_ujian = JadwalUjian::where('pendaftaran_ujian_id', $semhas->id ?? null)->first();
        $jadwal_ujian ? $jadwal_ujian->penguji1 = Dosen::where('id', $jadwal_ujian->penguji1_id)->first()->nama : '';
        $jadwal_ujian ? $jadwal_ujian->penguji2 = Dosen::where('id', $jadwal_ujian->penguji2_id)->first()->nama : '';
        $jadwal_ujian ? $jadwal_ujian->penguji3 = $jadwal_ujian->penguji3_id ? Dosen::where('id', $jadwal_ujian->penguji3_id)->first()->nama : null : '';

        if ($semhas && $jadwal_ujian) {
            $semhas->komentar_kaprodi = KomentarUjian::select('komentar')->where('role', 'kaprodi')->where('pendaftaran_ujian_id', $semhas->id)->value('komentar');
            $semhas->komentar6 = $user->co_promotor2_id ? KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $semhas->id)->where('dosen_id', $user->co_promotor2_id)->value('komentar') : null;
            $semhas->komentar5 = KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $semhas->id)->where('dosen_id', $user->co_promotor1_id)->value('komentar');
            $semhas->komentar4 = KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $semhas->id)->where('dosen_id', $user->promotor_id)->value('komentar');
            $semhas->komentar3 = $jadwal_ujian->penguji3_id ? KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $semhas->id)->where('dosen_id', $jadwal_ujian->penguji3_id)->value('komentar') : null;
            $semhas->komentar2 = KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $semhas->id)->where('dosen_id', $jadwal_ujian->penguji2_id)->value('komentar');
            $semhas->komentar1 = KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $semhas->id)->where('dosen_id', $jadwal_ujian->penguji1_id)->value('komentar');
            
            $semhas->komentar6 = KomentarUjian::where('role', 'kaprodi')
                ->where('pendaftaran_ujian_id', $semhas->id)
                ->value('komentar');

            $semhas->komentar5 = KomentarUjian::where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $semhas->id)
                ->where('dosen_id', $user->co_promotor2_id)
                ->value('komentar');

            $semhas->komentar4 = KomentarUjian::where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $semhas->id)
                ->where('dosen_id', $user->co_promotor1_id)
                ->value('komentar');

            $semhas->komentar3 = KomentarUjian::where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $semhas->id)
                ->where('dosen_id', $user->promotor_id)
                ->value('komentar');

            $semhas->komentar2 = KomentarUjian::where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $semhas->id)
                ->where('dosen_id', $jadwal_ujian->penguji2_id)
                ->value('komentar');
            $semhas->komentar3_penguji = KomentarUjian::where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $semhas->id)
                ->where('dosen_id', $jadwal_ujian->penguji3_id)
                ->value('komentar');

            $semhas->komentar1 = KomentarUjian::where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $semhas->id)
                ->where('dosen_id', $jadwal_ujian->penguji1_id)
                ->value('komentar');

            // Is penilaian all done
            $semhas->is_penilaian_done = $semhas->nilai_penguji1 != null && 
                                         $semhas->nilai_penguji2 != null && 
                                         ($jadwal_ujian->penguji3_id == null || $semhas->nilai_penguji3 != null) && 
                                         $semhas->nilai_promotor != null && 
                                         $semhas->nilai_co_promotor1 != null && 
                                         ($semhas->co_promotor2_id == null || $semhas->nilai_co_promotor2 != null) && 
                                         $semhas->nilai_kaprodi != null;
        }

        return view('pages.mahasiswa.ujian.semhas', compact('semhas', 'jadwal_ujian', ));
    }

    public function store($request)
    {
        $nim = auth()->user()->nim;
        $nama = auth()->user()->nama;
        if (!$nim) {
            throw new \Exception('NIM tidak ditemukan', 404);
        }

        // Validate that at least 2 examiners are provided, but allow up to 3
        if (!isset($request->usulan_penguji[0]) || !isset($request->usulan_penguji[1])) {
            throw new \Exception('Minimal 2 penguji harus dipilih', 400);
        }

        $penguji1_id = $request->usulan_penguji[0];
        $penguji2_id = $request->usulan_penguji[1];
        $penguji3_id = isset($request->usulan_penguji[2]) ? $request->usulan_penguji[2] : null;

        PendaftaranUjian::create([
            'nim' => $nim,
            'jenis_ujian' => 'semhas', // fixed value
            'penguji1_id' => $penguji1_id,
            'penguji2_id' => $penguji2_id,
            'penguji3_id' => $penguji3_id, // Optional third examiner
            'kaprodi_id' => 1, // Test value
            'file' => $request->naskah,
            'status' => '2'
        ]);

        $maha = Mahasiswa::where('nim', $nim)->first();
        $maha->progress = '1';
        Alert::success('Berhasil', 'Pendaftaran seminar hasil berhasil');
        return redirect()->route('ujian.semhas');
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

        // Update file
        $pendaftaran = PendaftaranUjian::findOrFail($request->id_pendaftaran);
        $pendaftaran->file = $request->naskah_revisi;
        $pendaftaran->status = '5';
        $pendaftaran->save();

        Alert::success('Berhasil', 'Revisi seminar hasil berhasil diajukan');
        return redirect()->route('ujian.semhas');
    }

    public function destroy($id)
    {
    }
}