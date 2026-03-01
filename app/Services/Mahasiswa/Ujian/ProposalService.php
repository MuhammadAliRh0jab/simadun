<?php

namespace App\Services\Mahasiswa\Ujian;

use App\Models\PendaftaranUjian;
use App\Models\Dosen;
use App\Models\JadwalUjian;
use App\Models\KomentarUjian;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProposalService
{
    /**
     * Halaman index Ujian Proposal (menampilkan progress, jadwal, komentar)
     */
    public function index()
    {
        $user = auth()->user();
        $nim  = $user->nim ?? null;

        if (!$nim) {
            throw new \Exception('NIM tidak ditemukan', 404);
        }

        // Ambil pendaftaran proposal terakhir milik mahasiswa
        $proposal = PendaftaranUjian::where('nim', $nim)
            ->where('jenis_ujian', 'proposal')
            ->first();

        // Lengkapi nama usulan penguji (untuk tampilan)
        if ($proposal) {
            $proposal->usulan_penguji1 = optional(Dosen::find($proposal->penguji1_id))->nama ?? '';
            $proposal->usulan_penguji2 = optional(Dosen::find($proposal->penguji2_id))->nama ?? '';
            $proposal->usulan_penguji3 = optional(Dosen::find($proposal->penguji3_id))->nama ?? '';
        }

        // Jadwal ujian (jika sudah ada)
        $jadwal_ujian = null;
        if ($proposal) {
            $jadwal_ujian = JadwalUjian::where('pendaftaran_ujian_id', $proposal->id)->first();
            if ($jadwal_ujian) {
                $jadwal_ujian->penguji1 = optional(Dosen::find($jadwal_ujian->penguji1_id))->nama ?? '';
                $jadwal_ujian->penguji2 = optional(Dosen::find($jadwal_ujian->penguji2_id))->nama ?? '';
                $jadwal_ujian->penguji3 = optional(Dosen::find($jadwal_ujian->penguji3_id))->nama ?? '';
            }
        }

        // Komentar & status penilaian (jika sudah ada jadwal)
        if ($proposal && $jadwal_ujian) {
            $proposal->komentar6 = KomentarUjian::where('role', 'kaprodi')
                ->where('pendaftaran_ujian_id', $proposal->id)
                ->value('komentar');

            $proposal->komentar5 = KomentarUjian::where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $proposal->id)
                ->where('dosen_id', $user->co_promotor2_id)
                ->value('komentar');

            $proposal->komentar4 = KomentarUjian::where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $proposal->id)
                ->where('dosen_id', $user->co_promotor1_id)
                ->value('komentar');

            $proposal->komentar3 = KomentarUjian::where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $proposal->id)
                ->where('dosen_id', $user->promotor_id)
                ->value('komentar');

            $proposal->komentar2 = KomentarUjian::where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $proposal->id)
                ->where('dosen_id', $jadwal_ujian->penguji2_id)
                ->value('komentar');
            $proposal->komentar3_penguji = KomentarUjian::where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $proposal->id)
                ->where('dosen_id', $jadwal_ujian->penguji3_id)
                ->value('komentar');

            $proposal->komentar1 = KomentarUjian::where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $proposal->id)
                ->where('dosen_id', $jadwal_ujian->penguji1_id)
                ->value('komentar');

            // Semua penilaian wajib, kecuali pihak opsional (penguji3 & co_promotor2)
            $proposal->is_penilaian_done =
                $proposal->nilai_penguji1 !== null &&
                $proposal->nilai_penguji2 !== null &&
                ($proposal->penguji3_id === null || $proposal->nilai_penguji3 !== null) &&
                $proposal->nilai_promotor !== null &&
                $proposal->nilai_co_promotor1 !== null &&
                ($user->co_promotor2_id === null || $proposal->nilai_co_promotor2 !== null) &&
                $proposal->nilai_kaprodi !== null;
        }

        return view('pages.mahasiswa.ujian.proposal', compact('proposal', 'jadwal_ujian'));
    }

    /**
     * Simpan pendaftaran ujian proposal
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $nim  = $user->nim ?? null;

        if (!$nim) {
            throw new \Exception('NIM tidak ditemukan', 404);
        }

        // Validasi stabil: 2–3 penguji, semua valid & unik, naskah berupa URL
        $request->validate([
            'usulan_penguji'   => ['required', 'array', 'min:2', 'max:3'],
            'usulan_penguji.*' => ['distinct', 'integer', 'exists:dosens,id'],
            'naskah'           => ['required', 'url'],
        ], [
            'usulan_penguji.required'   => 'Minimal 2 penguji harus dipilih.',
            'usulan_penguji.min'        => 'Minimal 2 penguji harus dipilih.',
            'usulan_penguji.max'        => 'Maksimal 3 penguji yang diperbolehkan.',
            'usulan_penguji.*.distinct' => 'Penguji tidak boleh sama.',
            'usulan_penguji.*.exists'   => 'Penguji yang dipilih tidak valid.',
            'naskah.required'           => 'Link naskah harus diisi.',
            'naskah.url'                => 'Link naskah harus berupa URL yang valid.',
        ]);

        // NORMALISASI: buang nilai kosong & reindex
        $ids = array_values(array_filter(
            $request->input('usulan_penguji', []),
            fn ($v) => filled($v)
        ));

        // Ambil penguji 1–3 (3 opsional)
        $penguji1_id = $ids[0] ?? null;
        $penguji2_id = $ids[1] ?? null;
        $penguji3_id = $ids[2] ?? null; // boleh null

        // Ambil Kaprodi
        $kaprodi = Dosen::where('role', 'kaprodi')->first();
        if (!$kaprodi) {
            throw new \Exception('Kaprodi tidak ditemukan', 404);
        }

        // Simpan pendaftaran
        PendaftaranUjian::create([
            'nim'          => $nim,
            'jenis_ujian'  => 'proposal',
            'penguji1_id'  => $penguji1_id,
            'penguji2_id'  => $penguji2_id,
            'penguji3_id'  => $penguji3_id, // NULL jika hanya memilih 2 penguji
            'kaprodi_id'   => $kaprodi->id,
            'file'         => $request->naskah,
            'status'       => '2', // diajukan
        ]);

        // Update progress mahasiswa
        $maha = Mahasiswa::where('nim', $nim)->first();
        if ($maha) {
            $maha->progress = '1';
            $maha->save();
        }

        Alert::success('Berhasil', 'Pendaftaran proposal berhasil');
        return redirect()->route('ujian.proposal');
    }

    /**
     * Ajukan revisi naskah
     */
    public function update(Request $request)
    {
        $request->validate([
            'id_pendaftaran' => ['required', 'integer'],
            'naskah_revisi'  => ['required', 'url'],
        ], [
            'id_pendaftaran.required' => 'Pendaftaran tidak valid.',
            'id_pendaftaran.integer'  => 'Pendaftaran tidak valid.',
            'naskah_revisi.required'  => 'Link naskah revisi harus diisi.',
            'naskah_revisi.url'       => 'Link naskah revisi harus berupa URL yang valid.',
        ]);

        $user = auth()->user();
        $nim  = $user->nim ?? null;
        if (!$nim) {
            throw new \Exception('NIM tidak ditemukan', 404);
        }

        $pendaftaran = PendaftaranUjian::findOrFail($request->id_pendaftaran);
        $pendaftaran->file   = $request->naskah_revisi;
        $pendaftaran->status = '5'; // revisi diajukan
        $pendaftaran->save();

        Alert::success('Berhasil', 'Revisi proposal berhasil diajukan');
        return redirect()->route('ujian.proposal');
    }

    /**
     * Hapus pendaftaran
     */
    public function destroy($id)
    {
        $pendaftaran = PendaftaranUjian::findOrFail($id);
        $pendaftaran->delete();

        Alert::success('Berhasil', 'Pendaftaran proposal berhasil dihapus');
        return redirect()->route('ujian.proposal');
    }
}
