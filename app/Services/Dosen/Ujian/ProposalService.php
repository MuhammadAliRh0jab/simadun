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

class ProposalService
{
    public function store($request, $proposalId)
    {
        // Validate the request
        $request->validate([
            'penguji' => 'required|array|min:2|max:3', // Allow 2 to 3 examiners
            'penguji.*' => 'required|exists:dosens,id', // Validate each examiner ID exists in the dosens table
            'tanggal' => 'required|date',
            'jam' => 'required|date_format:H:i',
            'ruangan' => 'required|string|max:255',
        ], [
            'penguji.min' => 'Anda harus memilih minimal 2 penguji.',
            'penguji.max' => 'Anda hanya dapat memilih maksimal 3 penguji.',
            'penguji.*.exists' => 'Penguji yang dipilih tidak valid.',
            'tanggal.required' => 'Tanggal ujian harus diisi.',
            'jam.required' => 'Jam ujian harus diisi.',
            'ruangan.required' => 'Ruangan ujian harus diisi.',
        ]);

        try {
            $proposal = PendaftaranUjian::findOrFail($proposalId);

            // Create the exam schedule with 2 or 3 examiners
            JadwalUjian::create([
                'pendaftaran_ujian_id' => $proposalId,
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'ruangan' => $request->ruangan,
                'penguji1_id' => $request->penguji[0],
                'penguji2_id' => $request->penguji[1],
                'penguji3_id' => isset($request->penguji[2]) ? $request->penguji[2] : null, // Set penguji3_id to null if not provided
            ]);

            // Update the proposal status to "Terjadwal" (status 3)
            $proposal->status = '3';
            $proposal->save();

            Alert::success('Berhasil', 'Jadwal ujian proposal berhasil disimpan.');
            return redirect()->route('dosen.ujian.proposal');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menyimpan jadwal ujian: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    public function show($id)
    {
        $proposal = PendaftaranUjian::findOrFail($id);
        $mahasiswa = Mahasiswa::where('nim', $proposal->nim)->first();
        $jadwal_ujian = JadwalUjian::where('pendaftaran_ujian_id', $id)->first();

        // Promotor and Co-Promotor names
        $mahasiswa->promotor1 = Dosen::select('nama')->where('id', $mahasiswa->promotor_id)->first()->nama ?? '-';
        $mahasiswa->promotor2 = Dosen::select('nama')->where('id', $mahasiswa->co_promotor1_id)->first()->nama ?? '-';
        $mahasiswa->promotor3 = Dosen::select('nama')->where('id', $mahasiswa->co_promotor2_id)->first()->nama ?? '-';

        // Usulan penguji
        $proposal->usulan_penguji1 = Dosen::where('id', $proposal->penguji1_id)->first()->nama ?? '-';
        $proposal->usulan_penguji2 = Dosen::where('id', $proposal->penguji2_id)->first()->nama ?? '-';
        $proposal->usulan_penguji3 = Dosen::where('id', $proposal->penguji3_id)->first()->nama ?? '-';

        if ($jadwal_ujian) {
            // Penguji names
            $jadwal_ujian->penguji1 = Dosen::where('id', $jadwal_ujian->penguji1_id)->first()->nama ?? '-';
            $jadwal_ujian->penguji2 = Dosen::where('id', $jadwal_ujian->penguji2_id)->first()->nama ?? '-';
            $jadwal_ujian->penguji3 = Dosen::where('id', $jadwal_ujian->penguji3_id)->first()->nama ?? '-';

            // Komentar for each examiner
            $proposal->komentar6 = KomentarUjian::select('komentar')
                ->where('role', 'kaprodi')
                ->where('pendaftaran_ujian_id', $id)
                ->value('komentar');
            $proposal->komentar5 = KomentarUjian::select('komentar')
                ->where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $id)
                ->where('dosen_id', $mahasiswa->co_promotor1_id)
                ->value('komentar');
            $proposal->komentar7 = KomentarUjian::select('komentar')
                ->where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $id)
                ->where('dosen_id', $mahasiswa->co_promotor2_id)
                ->value('komentar');
            $proposal->komentar4 = KomentarUjian::select('komentar')
                ->where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $id)
                ->where('dosen_id', $mahasiswa->promotor_id)
                ->value('komentar');
            $proposal->komentar3 = KomentarUjian::select('komentar')
                ->where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $id)
                ->where('dosen_id', $jadwal_ujian->penguji3_id) // Map komentar3 to penguji3_id
                ->value('komentar');
            $proposal->komentar2 = KomentarUjian::select('komentar')
                ->where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $id)
                ->where('dosen_id', $jadwal_ujian->penguji2_id)
                ->value('komentar');
            $proposal->komentar1 = KomentarUjian::select('komentar')
                ->where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $id)
                ->where('dosen_id', $jadwal_ujian->penguji1_id)
                ->value('komentar');

            // Check if all evaluations are done (consider penguji3_id as optional)
            $proposal->is_penilaian_done = $proposal->nilai_penguji1 != null &&
                                           $proposal->nilai_penguji2 != null &&
                                           ($jadwal_ujian->penguji3_id == null || $proposal->nilai_penguji3 != null) && // penguji3 evaluation is optional
                                           $proposal->nilai_promotor != null &&
                                           $proposal->nilai_co_promotor1 != null &&
                                           ($mahasiswa->co_promotor2_id == null || $proposal->nilai_co_promotor2 != null) &&
                                           $proposal->nilai_kaprodi != null;

            // Check if the evaluation period is active
            $jadwal_ujian->penilaian = date('Y-m-d H:i:s') >= Carbon::parse($jadwal_ujian->tanggal)->format('Y-m-d') . ' ' . $jadwal_ujian->jam;
        }

        return view('pages.dosen.ujian.proposal.show', compact('proposal', 'mahasiswa', 'jadwal_ujian'));
    }

    public function finalisasi($request)
    {
        $request->validate(
            [
                'mahasiswa_id' => 'required|numeric',
                'proposal_id' => 'required|numeric',
                'role' => 'required|string|in:kaprodi',
                'status' => 'required|string|in:layak,revisi',
                'jenis_ujian' => 'required|string|in:proposal'
            ],
            [
                'mahasiswa_id.required' => 'Tidak valid',
                'mahasiswa_id.numeric' => 'Tidak valid',
                'proposal_id.required' => 'Ujian tidak valid',
                'proposal_id.numeric' => 'Ujian tidak valid',
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

        $proposal = PendaftaranUjian::findOrFail($request->proposal_id);
        $mahaasiswa = Mahasiswa::findOrFail($request->mahasiswa_id);
        $proposal->status = $request->status == 'layak' ? '6' : '4';
        $proposal->save();
        $mahaasiswa->progress = $request->status ==  'layak' ? '2' : '1';
        $mahaasiswa->save();

        return response()->json(['message' => 'Nilai berhasil ditambahkan'], 200);
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}