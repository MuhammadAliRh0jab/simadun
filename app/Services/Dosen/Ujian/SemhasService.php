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

class SemhasService
{
    public function store($request, $semhasId)
    {
        $semhas = PendaftaranUjian::findOrFail($semhasId);

        // Validate that at least 2 examiners are provided, but allow up to 3
        if (!isset($request->penguji[0]) || !isset($request->penguji[1])) {
            throw new \Exception('Minimal 2 penguji harus dipilih', 400);
        }

        $penguji1_id = $request->penguji[0];
        $penguji2_id = $request->penguji[1];
        $penguji3_id = isset($request->penguji[2]) ? $request->penguji[2] : null;

        JadwalUjian::create([
            'pendaftaran_ujian_id' => $semhasId,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'ruangan' => $request->ruangan,
            'penguji1_id' => $penguji1_id,
            'penguji2_id' => $penguji2_id,
            'penguji3_id' => $penguji3_id, // Optional third examiner
            'penguji_eks_id' => null,
        ]);

        $semhas->status = '3';
        $semhas->save();

        Alert::success('Berhasil', 'Ujian seminar hasil berhasil dijadwalkan');
        return redirect()->route('dosen.ujian.semhas');
    }

    public function show($id)
    {
        $semhas = PendaftaranUjian::findOrFail($id);
        $mahasiswa = Mahasiswa::where('nim', $semhas->nim)->first();
        $jadwal_ujian = JadwalUjian::where('pendaftaran_ujian_id', $id)->first();

        // Promotor
        $mahasiswa->promotor1 = Dosen::select('nama')->where('id', $mahasiswa->promotor_id)->first()->nama;
        $mahasiswa->promotor2 = Dosen::select('nama')->where('id', $mahasiswa->co_promotor1_id)->first()->nama;
        $mahasiswa->promotor3 = $mahasiswa->co_promotor2_id ? Dosen::select('nama')->where('id', $mahasiswa->co_promotor2_id)->first()->nama : null;

        // Usulan penguji
        $semhas->usulan_penguji1 = Dosen::where('id', $semhas->penguji1_id)->first()->nama;
        $semhas->usulan_penguji2 = Dosen::where('id', $semhas->penguji2_id)->first()->nama;
        $semhas->usulan_penguji3 = $semhas->penguji3_id ? Dosen::where('id', $semhas->penguji3_id)->first()->nama : null;

        if ($jadwal_ujian) {
            // Penguji
            $jadwal_ujian->penguji1 = Dosen::where('id', $jadwal_ujian->penguji1_id)->first()->nama;
            $jadwal_ujian->penguji2 = Dosen::where('id', $jadwal_ujian->penguji2_id)->first()->nama;
            $jadwal_ujian->penguji3 = $jadwal_ujian->penguji3_id ? Dosen::where('id', $jadwal_ujian->penguji3_id)->first()->nama : null;

            // Dosen komentar
            $semhas->komentar6 = KomentarUjian::select('komentar')
                ->where('role', 'kaprodi')
                ->where('pendaftaran_ujian_id', $id)
                ->value('komentar');
            $semhas->komentar5 = KomentarUjian::select('komentar')
                ->where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $id)
                ->where('dosen_id', $mahasiswa->co_promotor1_id)
                ->value('komentar');
            $semhas->komentar7 = KomentarUjian::select('komentar')
                ->where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $id)
                ->where('dosen_id', $mahasiswa->co_promotor2_id)
                ->value('komentar');
            $semhas->komentar4 = KomentarUjian::select('komentar')
                ->where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $id)
                ->where('dosen_id', $mahasiswa->promotor_id)
                ->value('komentar');
            $semhas->komentar3 = KomentarUjian::select('komentar')
                ->where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $id)
                ->where('dosen_id', $jadwal_ujian->penguji3_id) // Map komentar3 to penguji3_id
                ->value('komentar');
            $semhas->komentar2 = KomentarUjian::select('komentar')
                ->where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $id)
                ->where('dosen_id', $jadwal_ujian->penguji2_id)
                ->value('komentar');
            $semhas->komentar1 = KomentarUjian::select('komentar')
                ->where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $id)
                ->where('dosen_id', $jadwal_ujian->penguji1_id)
                ->value('komentar');

            // Is penilaian all done
            $semhas->is_penilaian_done = $semhas->nilai_penguji1 != null && 
                                         $semhas->nilai_penguji2 != null && 
                                         ($jadwal_ujian->penguji3_id == null || $semhas->nilai_penguji3 != null) && 
                                         $semhas->nilai_promotor != null && 
                                         $semhas->nilai_co_promotor1 != null && 
                                         ($mahasiswa->co_promotor2_id == null || $semhas->nilai_co_promotor2 != null) && 
                                         $semhas->nilai_kaprodi != null;

            $jadwal_ujian->penilaian = date('Y-m-d H:i:s') >= Carbon::parse($jadwal_ujian->tanggal)->format('Y-m-d') . ' ' . $jadwal_ujian->jam;
        }

        return view('pages.dosen.ujian.semhas.show', compact('semhas', 'mahasiswa', 'jadwal_ujian'));
    }

    public function finalisasi($request)
    {
        $request->validate(
            [
                'mahasiswa_id' => 'required|numeric',
                'semhas_id' => 'required|numeric',
                'role' => 'required|string|in:kaprodi',
                'status' => 'required|string|in:layak,revisi',
                'jenis_ujian' => 'required|string|in:semhas'
            ],
            [
                'mahasiswa_id.required' => 'Tidak valid',
                'mahasiswa_id.numeric' => 'Tidak valid',
                'semhas_id.required' => 'Ujian tidak valid',
                'semhas_id.numeric' => 'Ujian tidak valid',
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

        $semhas = PendaftaranUjian::findOrFail($request->semhas_id);
        $mahasiswa = Mahasiswa::findOrFail($request->mahasiswa_id);
        $semhas->status = $request->status == 'layak' ? '6' : '4';
        $semhas->save();
        $mahasiswa->progress = $request->status == 'layak' ? '3' : '2';
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