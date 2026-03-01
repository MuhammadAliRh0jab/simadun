<?php

namespace App\Services\Dosen;

use App\Models\DetailMahasiswa;
use App\Models\PendaftaranUjian;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\JadwalUjian;
use App\Models\KomentarUjian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class BimbinganService
{


    public function show($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $detail = DetailMahasiswa::where('nim', $mahasiswa->nim)->first();

        $ujian = new \stdClass();
        $ujian->proposal = PendaftaranUjian::select('file')->where('jenis_ujian', 'proposal')->where('nim', $mahasiswa->nim)->value('file');
        $ujian->semhas = PendaftaranUjian::select('file')->where('jenis_ujian', 'semhas')->where('nim', $mahasiswa->nim)->value('file');
        $ujian->publikasi = PendaftaranUjian::select('file')->where('jenis_ujian', 'publikasi')->where('nim', $mahasiswa->nim)->value('file');
        $ujian->disertasi = PendaftaranUjian::select('file')->where('jenis_ujian', 'disertasi')->where('nim', $mahasiswa->nim)->value('file');
        $ujian->tertutup = PendaftaranUjian::select('file')->where('jenis_ujian', 'tertutup')->where('nim', $mahasiswa->nim)->value('file');

        // promotors
        $mahasiswa->promotor1 = Dosen::where('id', $mahasiswa->promotor_id)->first()->nama;
        $mahasiswa->promotor2 = Dosen::where('id', $mahasiswa->co_promotor1_id)->first()->nama;
        $mahasiswa->promotor3 = Dosen::where('id', $mahasiswa->co_promotor2_id)->first()->nama ?? '-';


        return view('pages.dosen.bimbingan.show', compact('mahasiswa', 'ujian', 'detail'));
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }


}
