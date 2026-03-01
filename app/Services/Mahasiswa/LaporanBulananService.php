<?php
namespace App\Services\Mahasiswa;

use App\Models\LaporanBulanan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LaporanBulananService
{
    public function store($request)
    {
        $laporanBulanan = LaporanBulanan::where('nim', auth()->user()->nim)
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->first();

        $status = $laporanBulanan ? false : ((date('d') >= 1 && date('d') <= 10) ? true : false);
        if (!$status) {
            throw new \Exception('Pengajuan proposal hanya bisa dilakukan pada tanggal 1-10 setiap bulan', 400);
        }

        $nim = auth()->user()->nim;
        if (!$nim) {
            throw new \Exception('NIM tidak ditemukan', 404);
        }
        LaporanBulanan::create([
            'nim' => $nim,
            'judul' => $request->judul,
            'isi_progress' => $request->isi
        ]);

        return response()->json(['message' => 'Laporan bulanan berhasil dibuat'], 200);
    }

    public function update(Request $request, $id)
    {
        $laporanBulanan = LaporanBulanan::findOrFail($id);
        $laporanBulanan->update([
            'judul' => $request->judul,
            'isi' => $request->isi
        ]);

        return response()->json(['message' => 'Laporan bulanan berhasil diubah'], 200);
    }

    public function destroy($id)
    {
        $laporanBulanan = LaporanBulanan::findOrFail($id);
        $laporanBulanan->delete();

        Alert::success('Berhasil', 'Laporan bulanan berhasil dihapus');
        return redirect()->route('laporan-bulanan.index');

    }

}