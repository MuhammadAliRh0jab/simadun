<?php

namespace App\Http\Controllers\Dosen\PublikasiMahasiswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PublikasiJurnal;
use App\Models\PublikasiConference;

class PublikasiConferenceController extends Controller
{
    public function deleteJurnal($id){
        $data = PublikasiJurnal::find($id);
        $data->delete();
        return redirect()->route('dosen.publikasi.jurnal.index')->with('berhasil', 'Data berhasil di hapus');
    }

    public function deleteConf($id){
        $data = PublikasiConference::find($id);
        $data->delete();
        return redirect()->route('dosen.publikasi.conference.index')->with('berhasil', 'Data berhasil di hapus');
    }

    public function showJurnal(Request $nim){
        $getData = PublikasiJurnal::where('nim', $nim)->get();
        return view('pages.dosen.publikasi.show', compact('getData'));
    }

    public function showConfrence(Request $nim){
        $getData = PublikasiJurnal::where('nim', $nim)->get();
        return view('pages.dosen.publikasi.show', compact('getData'));
    }

    public function index(){
        $dataPublikasiJurnal = PublikasiJurnal::all();
        $dataPublikasiConference =  PublikasiConference::all();
        return view('pages.dosen.publikasi.index', compact('dataPublikasiJurnal', 'dataPublikasiConference'));
    }

}
