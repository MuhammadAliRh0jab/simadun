<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// datatables laporan bulanan
use App\DataTables\LaporanBulananDataTable;
use App\Services\Mahasiswa\LaporanBulananService;
use App\Http\Requests\LaporanBulananRequest;
use App\Models\LaporanBulanan;
use RealRashid\SweetAlert\Facades\Alert;

class LaporanBulananController extends Controller
{
    protected $laporanBulananService;

    public function __construct(LaporanBulananService $laporanBulanan)
    {
        $this->laporanBulananService = $laporanBulanan;
    }

    public function index(LaporanBulananDataTable $dataTable)
    {
        $laporanBulanan = LaporanBulanan::where('nim', auth()->user()->nim)
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->first();

        $status = $laporanBulanan ? false : ((date('d') >= 1 && date('d') <= 10) ? true : false);
        return $dataTable->render('pages.mahasiswa.laporan-bulanan.index', compact('status'));
    }

    public function create()
    {
        // $laporanBulanan = LaporanBulanan::where('nim', auth()->user()->nim)
        //     ->whereMonth('created_at', date('m'))
        //     ->whereYear('created_at', date('Y'))
        //     ->first();

        // $status = $laporanBulanan ? false : ((date('d') >= 1 && date('d') <= 10) ? true : false);
        // if (!$status) {
        //     Alert::error('Error', 'Pengajuan laporan bulanan hanya bisa dilakukan pada tanggal 1-10 setiap bulan');
        //     return redirect()->route('laporan-bulanan.index');
        // }
        return view('pages.mahasiswa.laporan-bulanan.create');
    }

    public function store(LaporanBulananRequest $request)
    {
        $this->laporanBulananService->store($request);
    }

    public function show($id)
    {
        $laporanBulanan = LaporanBulanan::findOrFail($id);
        $status = [
            0 => '<span class="badge bg-label-secondary">Dalam Proses</span>',
            1 => '<span class="badge bg-label-info">Dalam Proses</span>',
            2 => '<span class="badge bg-label-success">Selesai</span>',
        ];
        return view('pages.mahasiswa.laporan-bulanan.show', compact('laporanBulanan', 'status'));
    }

    public function destroy($id)
    {
        return redirect()->route('laporan-bulanan.index');
    }
}