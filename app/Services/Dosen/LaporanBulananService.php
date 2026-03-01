<?php
namespace App\Services\Dosen;

use App\Models\LaporanBulanan;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LaporanBulananService
{
    public function show($id)
    {
        $laporan = LaporanBulanan::findOrFail($id);
        $mahasiswa = Mahasiswa::where('nim', $laporan->nim)->first();
        $mahasiswa->promotor1 = Dosen::where('id', $mahasiswa->promotor_id)->first()->nama;
        $mahasiswa->promotor2 = Dosen::where('id', $mahasiswa->co_promotor1_id)->first()->nama;
        $mahasiswa->promotor3 = Dosen::where('id', $mahasiswa->co_promotor2_id)->first()->nama ?? null;
        $currentDosen = auth()->guard('dosen')->user();
        $currentPromotor = $this->checkDosen($currentDosen->id, $mahasiswa->id);

        // is current promotor allready fill the comment
        $isCommented = false;
        if ($currentPromotor == 'Promotor') {
            $isCommented = $laporan->komentar_promotor ? true : false;
            $komentar = $laporan->komentar_promotor;
        } elseif ($currentPromotor == 'CO-Promotor 1') {
            $isCommented = $laporan->komentar_co_promotor1 ? true : false;
            $komentar = $laporan->komentar_co_promotor1;
        } elseif ($currentPromotor == 'CO-Promotor 2') {
            $isCommented = $laporan->komentar_co_promotor2 ? true : false;
            $komentar = $laporan->komentar_co_promotor2;
        }


        return view('pages.dosen.laporan-bulanan.show', compact('laporan', 'mahasiswa', 'currentPromotor', 'isCommented', 'komentar'));
    }

    public function komentar(Request $request, $id)
    {
        $laporan = LaporanBulanan::findOrFail($id);
        $currentDosen = auth()->guard('dosen')->user();
        $currentPromotor = $this->checkDosen($currentDosen->id, $laporan->mahasiswa_id);
        $mahasiswa = Mahasiswa::where('nim', $laporan->nim)->first();

        if ($currentPromotor == 'Promotor') {
            $laporan->update([
                'komentar_promotor' => $request->komentar
            ]);
        } elseif ($currentPromotor == 'CO-Promotor 1') {
            $laporan->update([
                'komentar_co_promotor1' => $request->komentar
            ]);
        } elseif ($currentPromotor == 'CO-Promotor 2') {
            $laporan->update([
                'komentar_co_promotor2' => $request->komentar
            ]);
        }

        $laporan = LaporanBulanan::findOrFail($id);
        if ($mahasiswa->promotor_id && $mahasiswa->co_promotor1_id && $mahasiswa->co_promotor2_id) {
            if ($laporan->komentar_promotor && $laporan->komentar_co_promotor1 && $laporan->komentar_co_promotor2) {
                $laporan->update([
                    'status' => '2'
                ]);
            }
        } elseif ($mahasiswa->promotor_id && $mahasiswa->co_promotor1_id) {
            if ($laporan->komentar_promotor && $laporan->komentar_co_promotor1) {
                $laporan->update([
                    'status' => '2'
                ]);
            }
        }

        return response()->json(['message' => 'Laporan bulanan berhasil dibuat'], 200);
    }

    public function store($request)
    {
        dd($request);


        return response()->json(['message' => 'Laporan bulanan berhasil dibuat'], 200);
    }

    public function update(Request $request, $id)
    {
        dd($request);
    }

    public function destroy($id)
    {
        $laporanBulanan = LaporanBulanan::findOrFail($id);
        $laporanBulanan->delete();

        Alert::success('Berhasil', 'Laporan bulanan berhasil dihapus');
        return redirect()->route('laporan-bulanan.index');

    }

    private function checkDosen($idDosen, $idMahasiswa)
    {
        $mahasiswa = Mahasiswa::where('promotor_id', $idDosen)->orWhere('co_promotor1_id', $idDosen)->orWhere('co_promotor2_id', $idDosen)->where('id', $idMahasiswa)->first();
        if ($mahasiswa) {
            if ($mahasiswa->promotor_id == $idDosen) {
                return 'Promotor';
            } elseif ($mahasiswa->co_promotor1_id == $idDosen) {
                return 'CO-Promotor 1';
            } elseif ($mahasiswa->co_promotor2_id == $idDosen) {
                return 'CO-Promotor 2';
            }
        } else {
            return \abort(403, 'Anda tidak berhak mengakses halaman ini');
        }
    }

}