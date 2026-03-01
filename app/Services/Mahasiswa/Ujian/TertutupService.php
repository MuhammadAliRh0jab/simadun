<?php

namespace App\Services\Mahasiswa\Ujian;

use App\Models\PendaftaranUjian;
use App\Models\Dosen;
use App\Models\JadwalUjian;
use App\Models\KomentarUjian;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TertutupService
{
    public function index()
    {
        $nim  = auth()->user()->nim;
        $user = auth()->user();

        if (!$nim) {
            throw new \Exception('NIM tidak ditemukan', 404);
        }

        $tertutup = PendaftaranUjian::where('nim', $nim)
            ->where('jenis_ujian', 'tertutup')
            ->first();

        if ($tertutup) {
            // Aman dari null dengan optional()
            $tertutup->usulan_penguji1 = optional(Dosen::find($tertutup->penguji1_id))->nama;
            $tertutup->usulan_penguji2 = optional(Dosen::find($tertutup->penguji2_id))->nama;
            $tertutup->usulan_penguji3 = $tertutup->penguji3_id
                ? optional(Dosen::find($tertutup->penguji3_id))->nama
                : null;

            // Penguji eksternal disimpan sebagai JSON (array objek {id,nama,email})
            $penguji_eks_raw = $tertutup->penguji_eks;
            $penguji_eks = [];
            if ($penguji_eks_raw) {
                $decoded = json_decode($penguji_eks_raw);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $penguji_eks = $decoded;
                }
            }
            $tertutup->penguji_eks1 = $penguji_eks[0] ?? null; // stdClass {id,nama,email} atau null
            $tertutup->penguji_eks2 = $penguji_eks[1] ?? null;
        }

        // Jadwal ujian
        $jadwal_ujian = JadwalUjian::where('pendaftaran_ujian_id', $tertutup->id ?? null)->first();
        if ($jadwal_ujian) {
            $jadwal_ujian->penguji1   = optional(Dosen::find($jadwal_ujian->penguji1_id))->nama;
            $jadwal_ujian->penguji2   = optional(Dosen::find($jadwal_ujian->penguji2_id))->nama;
            $jadwal_ujian->penguji3   = $jadwal_ujian->penguji3_id ? optional(Dosen::find($jadwal_ujian->penguji3_id))->nama : null;
            $jadwal_ujian->penguji_eks= optional(Dosen::find($jadwal_ujian->penguji_eks_id))->nama;
        }

        // Komentar & status penilaian
        if ($tertutup && $jadwal_ujian) {
            $tertutup->komentar1   = KomentarUjian::where('role', 'dosen')->where('pendaftaran_ujian_id', $tertutup->id)->where('dosen_id', $jadwal_ujian->penguji1_id)->value('komentar');
            $tertutup->komentar2   = KomentarUjian::where('role', 'dosen')->where('pendaftaran_ujian_id', $tertutup->id)->where('dosen_id', $jadwal_ujian->penguji2_id)->value('komentar');
            $tertutup->komentar3   = $jadwal_ujian->penguji3_id ? KomentarUjian::where('role', 'dosen')->where('pendaftaran_ujian_id', $tertutup->id)->where('dosen_id', $jadwal_ujian->penguji3_id)->value('komentar') : null;
            $tertutup->komentar4   = KomentarUjian::where('role', 'dosen')->where('pendaftaran_ujian_id', $tertutup->id)->where('dosen_id', $user->promotor_id)->value('komentar');
            $tertutup->komentar5   = KomentarUjian::where('role', 'dosen')->where('pendaftaran_ujian_id', $tertutup->id)->where('dosen_id', $user->co_promotor1_id)->value('komentar');
            $tertutup->komentar6   = KomentarUjian::where('role', 'kaprodi')->where('pendaftaran_ujian_id', $tertutup->id)->value('komentar');
            $tertutup->komentar7   = $user->co_promotor2_id ? KomentarUjian::where('role', 'dosen')->where('pendaftaran_ujian_id', $tertutup->id)->where('dosen_id', $user->co_promotor2_id)->value('komentar') : null;
            $tertutup->komentar_eks= KomentarUjian::where('role', 'dosen')->where('pendaftaran_ujian_id', $tertutup->id)->where('dosen_id', $jadwal_ujian->penguji_eks_id)->value('komentar');

            $tertutup->is_penilaian_done =
                $tertutup->nilai_penguji1     !== null &&
                $tertutup->nilai_penguji2     !== null &&
                ($jadwal_ujian->penguji3_id   === null || $tertutup->nilai_penguji3 !== null) &&
                $tertutup->nilai_promotor     !== null &&
                $tertutup->nilai_co_promotor1 !== null &&
                ($user->co_promotor2_id       === null || $tertutup->nilai_co_promotor2 !== null) &&
                $tertutup->nilai_kaprodi      !== null &&
                $tertutup->nilai_penguji_eks  !== null;
        }

        return view('pages.mahasiswa.ujian.tertutup', compact('tertutup', 'jadwal_ujian'));
    }

    /**
     * Simpan pendaftaran Ujian Tertutup.
     * Konsisten pakai URL untuk naskah (bukan upload file).
     */
    public function store($request)
    {
        $nim = auth()->user()->nim;
        if (!$nim) {
            throw new \Exception('NIM tidak ditemukan', 404);
        }

        // Konstruksi penguji eksternal (opsional)
        $penguji_eks = [];
        if ($request->id_px1 && $request->nama_px1 && $request->email_px1) {
            $penguji_eks[] = [
                'id'    => $request->id_px1,
                'nama'  => $request->nama_px1,
                'email' => $request->email_px1,
            ];
        }
        if ($request->id_px2 && $request->nama_px2 && $request->email_px2) {
            $penguji_eks[] = [
                'id'    => $request->id_px2,
                'nama'  => $request->nama_px2,
                'email' => $request->email_px2,
            ];
        }

        // Ambil usulan penguji (wajib 2, opsional 3)
        $penguji1_id = $request->usulan_penguji[0] ?? null;
        $penguji2_id = $request->usulan_penguji[1] ?? null;
        $penguji3_id = $request->usulan_penguji[2] ?? null;

        // Simpan URL naskah langsung ke kolom 'file'
        PendaftaranUjian::create([
            'nim'          => $nim,
            'jenis_ujian'  => 'tertutup',
            'penguji1_id'  => $penguji1_id,
            'penguji2_id'  => $penguji2_id,
            'penguji3_id'  => $penguji3_id,
            'penguji_eks'  => json_encode($penguji_eks),
            'kaprodi_id'   => 1, // sementara
            'file'         => $request->naskah, // URL
            'status'       => '2', // diajukan
        ]);

        // Update progress mahasiswa
        $maha = Mahasiswa::where('nim', $nim)->first();
        $maha->progress = '1';

        Alert::success('Berhasil', 'Pendaftaran tertutup berhasil');
        return redirect()->route('ujian.tertutup');
    }

    /**
     * Ajukan revisi.
     * Konsisten pakai URL untuk naskah revisi (bukan upload file).
     */
    public function update($request)
    {
        $request->validate([
            'id_pendaftaran' => 'required|numeric|exists:pendaftaran_ujians,id',
            'naskah_revisi'  => 'required|url|max:2048',
        ], [
            'id_pendaftaran.required' => 'Pendaftaran tidak valid',
            'id_pendaftaran.numeric'  => 'Pendaftaran tidak valid',
            'id_pendaftaran.exists'   => 'Pendaftaran tidak ditemukan',
            'naskah_revisi.required'  => 'Link naskah revisi harus diisi',
            'naskah_revisi.url'       => 'Naskah revisi harus berupa URL yang valid',
            'naskah_revisi.max'       => 'URL terlalu panjang',
        ]);

        $nim = auth()->user()->nim;
        if (!$nim) {
            throw new \Exception('NIM tidak ditemukan', 404);
        }

        $pendaftaran = PendaftaranUjian::findOrFail($request->id_pendaftaran);

        // Simpan URL revisi ke kolom 'file'
        $pendaftaran->file   = $request->naskah_revisi; // URL
        $pendaftaran->status = '5'; // revisi diajukan
        $pendaftaran->save();

        Alert::success('Berhasil', 'Revisi tertutup berhasil diajukan');
        return redirect()->route('ujian.tertutup');
    }

    public function destroy($id)
    {
        // Implement sesuai kebutuhan
    }
}
