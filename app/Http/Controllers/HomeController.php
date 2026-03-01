<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\JadwalUjian;
use App\Models\PendaftaranUjian;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class HomeController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::user();
        $mahasiswa->promotor1 = Dosen::where('id', $mahasiswa->promotor_id)->first();
        $mahasiswa->promotor2 = Dosen::where('id', $mahasiswa->co_promotor1_id)->first();
        $mahasiswa->promotor3 = Dosen::where('id', $mahasiswa->co_promotor2_id)->first() ?? null;
        return view('pages.mahasiswa.index', compact('mahasiswa'));
    }

    public function dosen()
    {
        $twoDaysAgo = \Carbon\Carbon::now()->subDays(2)->format('Y-m-d');

        $jadwal_ujians = JadwalUjian::where('tanggal', '>=', $twoDaysAgo)
            ->join('pendaftaran_ujians', 'jadwal_ujians.pendaftaran_ujian_id', '=', 'pendaftaran_ujians.id')
            ->join('mahasiswas', 'pendaftaran_ujians.nim', '=', 'mahasiswas.nim')
            ->select('jadwal_ujians.*', 'mahasiswas.nama', 'pendaftaran_ujians.jenis_ujian')
            ->get();
        // const a statistic contain cpunt of pendaftars based on their jenis ujian that status is >= 6
        $statistic = new stdClass();
        $statistic->proposal = PendaftaranUjian::where('status', '<', 6)->where('jenis_ujian', 'proposal')->count();
        $statistic->semhas = PendaftaranUjian::where('status', '<', 6)->where('jenis_ujian', 'semhas')->count();
        $statistic->publikasi = PendaftaranUjian::where('status', '<', 6)->where('jenis_ujian', 'publikasi')->count();
        $statistic->disertasi = PendaftaranUjian::where('status', '<', 6)->where('jenis_ujian', 'disertasi')->count();
        $statistic->tertutup = PendaftaranUjian::where('status', '<', 6)->where('jenis_ujian', 'tertutup')->count();

        // users statistic
        $statistic->mahasiswa = Mahasiswa::all()->count();
        $statistic->dosen = Dosen::where('role', 'dosen')->count();
        $statistic->eks = Dosen::where('role', 'eksternal')->count();
        $statistic->kaprodi = Dosen::where('role', 'kaprodi')->count();
        return view('pages.dosen.index', compact('jadwal_ujians', 'statistic'));
    }
}
