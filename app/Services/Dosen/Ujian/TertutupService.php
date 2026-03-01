<?php

namespace App\Services\Dosen\Ujian;

use App\Models\PendaftaranUjian;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\JadwalUjian;
use App\Models\KomentarUjian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TertutupService
{
    /**
     * Simpan / perbarui jadwal ujian tertutup oleh dosen.
     * - Validasi & normalisasi input
     * - updateOrCreate jadwal (hindari duplikasi)
     * - Ubah status ke 3 hanya jika masih 2
     * - Redirect ke halaman show (hindari redirect chain)
     */
    public function store($request, $tertutupId)
    {
        // Validasi mirip ProposalService
        $request->validate([
            'tanggal'       => 'required|date',
            'jam'           => 'required|date_format:H:i',
            'ruangan'       => 'required|string|max:255',
            'penguji'       => 'required|array|min:2|max:3',
            'penguji.*'     => 'required|integer|exists:dosens,id|distinct',
            'penguji_eks'   => 'required|array|min:1|max:1',
            'penguji_eks.*' => 'required|integer|exists:dosens,id|distinct',
        ], [
            'penguji.min'           => 'Anda harus memilih minimal 2 penguji.',
            'penguji.max'           => 'Anda hanya dapat memilih maksimal 3 penguji.',
            'penguji.*.exists'      => 'Penguji internal yang dipilih tidak valid.',
            'penguji_eks.min'       => 'Wajib memilih 1 penguji eksternal.',
            'penguji_eks.max'       => 'Hanya boleh 1 penguji eksternal.',
            'penguji_eks.*.exists'  => 'Penguji eksternal yang dipilih tidak valid.',
        ]);

        // Normalisasi Select2 (buang elemen kosong & reindex)
        $penguji = array_values(array_filter($request->input('penguji', []), fn($v) => filled($v)));
        $penguji_eks = array_values(array_filter($request->input('penguji_eks', []), fn($v) => filled($v)));

        $tertutup = PendaftaranUjian::findOrFail($tertutupId);

        // Buat/Update jadwal agar tidak dobel jika tombol terpencet 2x
        JadwalUjian::updateOrCreate(
            ['pendaftaran_ujian_id' => $tertutupId],
            [
                'tanggal'        => $request->tanggal,
                'jam'            => $request->jam,
                'ruangan'        => $request->ruangan,
                'penguji1_id'    => $penguji[0],
                'penguji2_id'    => $penguji[1],
                'penguji3_id'    => $penguji[2] ?? null,    // opsional
                'penguji_eks_id' => $penguji_eks[0],
            ]
        );

        // Naikkan status hanya saat masih diajukan (2)
        if ($tertutup->status === '2') {
            $tertutup->status = '3';
            $tertutup->save();
        }

        Alert::success('Berhasil', 'Jadwal ujian tertutup berhasil disimpan.');
        // Arahkan ke show untuk menghindari loop di index
        return redirect()->route('dosen.ujian.tertutup.show', $tertutupId);
    }

    /**
     * Tampilkan detail pendaftaran + jadwal + komentar.
     * Kolom `file` diasumsikan URL (bukan file pdf), hanya untuk link di view.
     */
    public function show($id)
    {
        $tertutup    = PendaftaranUjian::findOrFail($id);
        $mahasiswa   = Mahasiswa::where('nim', $tertutup->nim)->first();
        $jadwal_ujian = JadwalUjian::where('pendaftaran_ujian_id', $id)->first();

        // Promotor & Co-Promotor (null-safe)
        if ($mahasiswa) {
            $mahasiswa->promotor1 = optional(Dosen::find($mahasiswa->promotor_id))->nama ?? '-';
            $mahasiswa->promotor2 = optional(Dosen::find($mahasiswa->co_promotor1_id))->nama ?? '-';
            $mahasiswa->promotor3 = optional(Dosen::find($mahasiswa->co_promotor2_id))->nama ?? '-';
        }

        // Usulan penguji internal (null-safe)
        $tertutup->usulan_penguji1 = optional(Dosen::find($tertutup->penguji1_id))->nama;
        $tertutup->usulan_penguji2 = optional(Dosen::find($tertutup->penguji2_id))->nama;
        $tertutup->usulan_penguji3 = $tertutup->penguji3_id ? optional(Dosen::find($tertutup->penguji3_id))->nama : null;

        // Pecah penguji eksternal (JSON array objek {id,nama,email}) — hanya untuk tampilan
        if ($tertutup->penguji_eks) {
            $decoded = json_decode($tertutup->penguji_eks);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $tertutup->penguji_eks1 = $decoded[0] ?? null;
                $tertutup->penguji_eks2 = $decoded[1] ?? null;
            }
        }

        if ($jadwal_ujian) {
            // Nama penguji pada jadwal (null-safe)
            $jadwal_ujian->penguji1    = optional(Dosen::find($jadwal_ujian->penguji1_id))->nama;
            $jadwal_ujian->penguji2    = optional(Dosen::find($jadwal_ujian->penguji2_id))->nama;
            $jadwal_ujian->penguji3    = $jadwal_ujian->penguji3_id ? optional(Dosen::find($jadwal_ujian->penguji3_id))->nama : null;
            $jadwal_ujian->penguji_eks = optional(Dosen::find($jadwal_ujian->penguji_eks_id))->nama;

            // Komentar (null-safe)
            $tertutup->komentar1 = KomentarUjian::where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $id)
                ->where('dosen_id', $jadwal_ujian->penguji1_id)
                ->value('komentar');

            $tertutup->komentar2 = KomentarUjian::where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $id)
                ->where('dosen_id', $jadwal_ujian->penguji2_id)
                ->value('komentar');

            $tertutup->komentar3 = $jadwal_ujian->penguji3_id
                ? KomentarUjian::where('role', 'dosen')
                    ->where('pendaftaran_ujian_id', $id)
                    ->where('dosen_id', $jadwal_ujian->penguji3_id)
                    ->value('komentar')
                : null;

            if ($mahasiswa) {
                $tertutup->komentar4 = KomentarUjian::where('role', 'dosen')
                    ->where('pendaftaran_ujian_id', $id)
                    ->where('dosen_id', $mahasiswa->promotor_id)
                    ->value('komentar');

                $tertutup->komentar5 = KomentarUjian::where('role', 'dosen')
                    ->where('pendaftaran_ujian_id', $id)
                    ->where('dosen_id', $mahasiswa->co_promotor1_id)
                    ->value('komentar');

                $tertutup->komentar7 = $mahasiswa->co_promotor2_id
                    ? KomentarUjian::where('role', 'dosen')
                        ->where('pendaftaran_ujian_id', $id)
                        ->where('dosen_id', $mahasiswa->co_promotor2_id)
                        ->value('komentar')
                    : null;
            }

            $tertutup->komentar6 = KomentarUjian::where('role', 'kaprodi')
                ->where('pendaftaran_ujian_id', $id)
                ->value('komentar');

            $tertutup->komentar_eks = KomentarUjian::where('role', 'dosen')
                ->where('pendaftaran_ujian_id', $id)
                ->where('dosen_id', $jadwal_ujian->penguji_eks_id)
                ->value('komentar');

            // Cek semua penilaian selesai (sertakan eksternal sesuai skema)
            $tertutup->is_penilaian_done =
                $tertutup->nilai_penguji1 !== null &&
                $tertutup->nilai_penguji2 !== null &&
                ($jadwal_ujian->penguji3_id === null || $tertutup->nilai_penguji3 !== null) &&
                $tertutup->nilai_promotor !== null &&
                $tertutup->nilai_co_promotor1 !== null &&
                ($mahasiswa?->co_promotor2_id === null || $tertutup->nilai_co_promotor2 !== null) &&
                $tertutup->nilai_kaprodi !== null &&
                $tertutup->nilai_penguji_eks !== null;

            // Periode penilaian aktif?
            $jadwal_ujian->penilaian =
                date('Y-m-d H:i:s') >= Carbon::parse($jadwal_ujian->tanggal)->format('Y-m-d') . ' ' . $jadwal_ujian->jam;
        }

        return view('pages.dosen.ujian.tertutup.show', compact('tertutup', 'mahasiswa', 'jadwal_ujian'));
    }

    /**
     * Finalisasi oleh Kaprodi — tidak menyentuh file, hanya status & progress.
     */
    public function finalisasi($request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|numeric|exists:mahasiswas,id',
            'tertutup_id'  => 'required|numeric|exists:pendaftaran_ujians,id',
            'role'         => 'required|string|in:kaprodi',
            'status'       => 'required|string|in:layak,revisi',
            'jenis_ujian'  => 'required|string|in:tertutup'
        ]);

        $tertutup  = PendaftaranUjian::findOrFail($request->tertutup_id);
        $mahasiswa = Mahasiswa::findOrFail($request->mahasiswa_id);

        $tertutup->status   = $request->status === 'layak' ? '6' : '4';
        $tertutup->save();

        // Mapping progress: silakan sesuaikan aturan internal
        $mahasiswa->progress = $request->status === 'layak' ? '6' : '5';
        $mahasiswa->save();

        return response()->json(['message' => 'Nilai berhasil ditambahkan'], 200);
    }

    public function update(Request $request, $id) {}
    public function destroy($id) {}

    public function addPenguji(Request $request)
    {
        try {
            $request->validate([
                'no_induk' => 'required|unique:dosens,no_induk',
                'nama'     => 'required|string',
                'email'    => 'required|email|unique:dosens,email',
            ], [
                'no_induk.unique' => 'No Induk sudah terdaftar',
                'email.unique'    => 'Email sudah terdaftar',
            ]);

            Dosen::create([
                'no_induk' => $request->no_induk,
                'nama'     => $request->nama,
                'role'     => 'eksternal',
                'email'    => $request->email,
                'password' => bcrypt($request->no_induk)
            ]);

            return response()->json(['message' => 'Penguji Eksternal berhasil ditambahkan'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan pada server'], 500);
        }
    }
}
