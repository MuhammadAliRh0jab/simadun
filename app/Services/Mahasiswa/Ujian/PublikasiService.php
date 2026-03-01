<?php

namespace App\Services\Mahasiswa\Ujian;

use App\Models\PendaftaranUjian;
use App\Models\Dosen;
use App\Models\JadwalUjian;
use App\Models\KomentarUjian;
use App\Models\Mahasiswa;
use App\Models\PublikasiJurnal;
use App\Models\PublikasiConference;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PublikasiService
{
    public function index()
    {
        $nim = auth()->user()->nim;
        $user = auth()->user();
        if (!$nim) {
            throw new \Exception('NIM tidak ditemukan', 404);
        }

        $publikasi = PendaftaranUjian::where('nim', $nim)->where('jenis_ujian', 'publikasi')->first();
        if ($publikasi) {
            $publikasi->usulan_penguji1 = Dosen::where('id', $publikasi->penguji1_id)->first()->nama;
            $publikasi->usulan_penguji2 = Dosen::where('id', $publikasi->penguji2_id)->first()->nama;
            $publikasi->usulan_penguji3 = $publikasi->penguji3_id ? Dosen::where('id', $publikasi->penguji3_id)->first()->nama : '-';
        }

        // Jadwal ujian
        $jadwal_ujian = JadwalUjian::where('pendaftaran_ujian_id', $publikasi->id ?? null)->first();
        if ($jadwal_ujian) {
            $jadwal_ujian->penguji1 = Dosen::where('id', $jadwal_ujian->penguji1_id)->first()->nama;
            $jadwal_ujian->penguji2 = Dosen::where('id', $jadwal_ujian->penguji2_id)->first()->nama;
            $jadwal_ujian->penguji3 = $jadwal_ujian->penguji3_id ? Dosen::where('id', $jadwal_ujian->penguji3_id)->first()->nama : null;
        }

        $publikasi_jurnal = PublikasiJurnal::where('nim', $nim)->get();
        $publikasi_conference = PublikasiConference::where('nim', $nim)->get();

        if ($publikasi && $jadwal_ujian) {
            $publikasi->komentar_kaprodi = KomentarUjian::select('komentar')->where('role', 'kaprodi')->where('pendaftaran_ujian_id', $publikasi->id)->value('komentar');
            $publikasi->komentar6 = $user->co_promotor2_id ? KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $publikasi->id)->where('dosen_id', $user->co_promotor2_id)->value('komentar') : null;
            $publikasi->komentar5 = KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $publikasi->id)->where('dosen_id', $user->co_promotor1_id)->value('komentar');
            $publikasi->komentar4 = KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $publikasi->id)->where('dosen_id', $user->promotor_id)->value('komentar');
            $publikasi->komentar3 = $jadwal_ujian->penguji3_id ? KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $publikasi->id)->where('dosen_id', $jadwal_ujian->penguji3_id)->value('komentar') : null;
            $publikasi->komentar2 = KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $publikasi->id)->where('dosen_id', $jadwal_ujian->penguji2_id)->value('komentar');
            $publikasi->komentar1 = KomentarUjian::select('komentar')->where('role', 'dosen')->where('pendaftaran_ujian_id', $publikasi->id)->where('dosen_id', $jadwal_ujian->penguji1_id)->value('komentar');

            $publikasi->komentar6 = KomentarUjian::where('role', 'kaprodi')
                ->where('pendaftaran_ujian_id', $publikasi->id)
                ->value('komentar');

            $publikasi->komentar5 = KomentarUjian::where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $publikasi->id)
                ->where('dosen_id', $user->co_promotor2_id)
                ->value('komentar');

            $publikasi->komentar4 = KomentarUjian::where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $publikasi->id)
                ->where('dosen_id', $user->co_promotor1_id)
                ->value('komentar');

            $publikasi->komentar3 = KomentarUjian::where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $publikasi->id)
                ->where('dosen_id', $user->promotor_id)
                ->value('komentar');

            $publikasi->komentar3_penguji = KomentarUjian::where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $publikasi->id)
                ->where('dosen_id', $jadwal_ujian->penguji3_id)
                ->value('komentar');
            $publikasi->komentar2 = KomentarUjian::where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $publikasi->id)
                ->where('dosen_id', $jadwal_ujian->penguji2_id)
                ->value('komentar');

            $publikasi->komentar1 = KomentarUjian::where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $publikasi->id)
                ->where('dosen_id', $jadwal_ujian->penguji1_id)
                ->value('komentar');


            // Is penilaian all done
            $publikasi->is_penilaian_done = $publikasi->nilai_penguji1 != null &&
                                            $publikasi->nilai_penguji2 != null &&
                                            ($jadwal_ujian->penguji3_id == null || $publikasi->nilai_penguji3 != null) &&
                                            $publikasi->nilai_promotor != null &&
                                            $publikasi->nilai_co_promotor1 != null &&
                                            ($user->co_promotor2_id == null || $publikasi->nilai_co_promotor2 != null) &&
                                            $publikasi->nilai_kaprodi != null;
        }

        return view('pages.mahasiswa.ujian.publikasi', compact('publikasi', 'jadwal_ujian', 'publikasi_jurnal', 'publikasi_conference'));
    }

    /**
     * ============================ METHOD STORE DIPERBARUI ============================
     */
    public function store(Request $request)
    {
        $nim = auth()->user()->nim;
        if (!$nim) {
            throw new \Exception('NIM tidak ditemukan', 404);
        }

        // Check if publikasi jurnal or conference exists
        if (PublikasiJurnal::where('nim', $nim)->count() < 1 && PublikasiConference::where('nim', $nim)->count() < 1) {
            Alert::warning('Peringatan', 'Publikasi Jurnal atau Publikasi Conference harus diisi minimal 1');
            return redirect()->route('ujian.publikasi');
        }

        // Tambahkan validasi untuk input baru
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
            'naskah.required'           => 'Link naskah kelayakan disertasi harus diisi.',
            'naskah.url'                => 'Link naskah harus berupa URL yang valid.',
        ]);

        $penguji1_id = $request->usulan_penguji[0];
        $penguji2_id = $request->usulan_penguji[1];
        $penguji3_id = $request->usulan_penguji[2] ?? null;

        $kaprodi = Dosen::where('role', 'kaprodi')->firstOrFail();

        PendaftaranUjian::create([
            'nim' => $nim,
            'jenis_ujian' => 'publikasi',
            'penguji1_id' => $penguji1_id,
            'penguji2_id' => $penguji2_id,
            'penguji3_id' => $penguji3_id,
            'kaprodi_id' => $kaprodi->id,
            'file' => $request->naskah, // Simpan URL naskah dari form
            'status' => '2'
        ]);

        $maha = Mahasiswa::where('nim', $nim)->first();
        if ($maha) {
            $maha->progress = '3'; // Sesuaikan progress jika perlu
            $maha->save();
        }
        
        Alert::success('Berhasil', 'Pendaftaran ujian publikasi berhasil diajukan');
        return redirect()->route('ujian.publikasi');
    }
    /**
     * ========================== AKHIR PERUBAHAN METHOD STORE ==========================
     */
     
    public function update(Request $request)
    {
        $request->validate([
            'id_pendaftaran' => 'required|numeric',
            'naskah_revisi'  => 'required|url',
        ]);

        $nim = auth()->user()->nim;
        if (!$nim) {
            throw new \Exception('NIM tidak ditemukan', 404);
        }

        $pendaftaran = PendaftaranUjian::findOrFail($request->id_pendaftaran);
        $pendaftaran->file = $request->naskah_revisi;
        $pendaftaran->status = '5';
        $pendaftaran->save();

        Alert::success('Berhasil', 'Revisi publikasi berhasil diajukan');
        return redirect()->route('ujian.publikasi');
    }

    public function destroy($id)
    {
        //
    }
}