<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\PublikasiConferenceDataTable;
use DataTables;
use App\Models\PublikasiConference;
use App\Models\PublikasiJurnal;
use App\DataTables\PublikasiMahasiswaDataTable;
use App\Helpers\DataTableHelper;
use App\Models\PendaftaranUjian;



class PublikasiController extends Controller
{
    public function saveEditConference(Request $request){
        try {
            // validation
            $validasi = $request->validate([
                'judul' => 'required',
                'nim' => 'required',
                'namaConference' => 'required',
                'penyelenggra' => 'required',
                'tanggal_conference' => 'required',
                'lokasi_Conference' => 'required',
                'tanggalPublikasi' => 'required',
                'link' => 'required|url',
            ]);

            $dataToSave = [
                'judul' => $request->input('judul'),
                'nim' => $request->input('nim'),
                'namaConference' => $request->input('namaConference'),
                'penyelenggara' => $request->input('penyelenggra'),
                'tanggal_conference' => $request->input('tanggal_conference'),
                'lokasi_Conference' => $request->input('lokasi_Conference'),
                'tanggalPublikasi' => $request->input('tanggalPublikasi'),
                'link' => $request->input('link'),
            ];

            // find the existing data
            $saveData1 = PublikasiConference::find($request->input('id'));

            // if data not found
            if (!$saveData1) {
                return redirect()->back()->with("gagal", "Data tidak ditemukan");
            }

            // update the data
            $saveData1->update($dataToSave);

            // alert hover
            return redirect()->back()->with("berhasil", "berkas berhasil di upload");
        } catch (\Exception $e) {
            // Tangani gagal umum
            return redirect()->back()->with("gagal", "Terjadi kesalahan: " . $e->getMessage() . " refresh page and try again");
        }
    }

    public function saveEditJurnal(Request $request){
        try {
            // validation
            $request->validate([
                'judul_Artikel' => 'required',
                'nim' => 'required',
                'nama_jurnal' => 'required',
                'volume' => 'required',
                'nomor' => 'required',
                'tanggal_terbit' => 'required',
                'link' => 'required|url',
            ]);

            $dataToSave = [
                'judul' => $request->input('judul_Artikel'),
                'nim' => $request->input('nim'),
                'jurnal' => $request->input('nama_jurnal'),
                'volume' => $request->input('volume'),
                'nomor' => $request->input('nomor'),
                'tanggal_terbit' => $request->input('tanggal_terbit'),
                'link' => $request->input('link'),
            ];

            // find the existing data
            $saveData1 = PublikasiJurnal::find($request->input('id'));

            // if data not found
            if (!$saveData1) {
                return redirect()->back()->with("gagal", "Data tidak ditemukan");
            }

            // update the data
            $saveData1->update($dataToSave);

            // alert hover
            return redirect()->back()->with("berhasil", "berkas berhasil di upload");
        } catch (\Exception $e) {
            // Tangani gagal umum
            return redirect()->back()->with("gagal", "Terjadi kesalahan: " . $e->getMessage() . " refresh page and try again");
        }
    }

    public function editPublikasi(Request $id){

        $ambilData  = PublikasiJurnal::where('id', $id->id)->get();
        return view('pages.mahasiswa.publikasi.editPublikasi', compact('ambilData'));
    }
    public function editConference(Request $id){
        $ambilData  = PublikasiConference::where('id', $id->id)->get();
        return view('pages.mahasiswa.publikasi.editConference', compact('ambilData'));
    }

    public function showAllPubilkasi(){
        // show database jurnal by nim
        $dataPublikasiJurnal = PublikasiJurnal::where('nim', auth()->user()->nim)->get();

        // show database conference by nim
        $dataPublikasiConference = PublikasiConference::where('nim', auth()->user()->nim)->get();

        $ambilStatus = PendaftaranUjian::where('nim', auth()->user()->nim)->get();

        return view('pages.mahasiswa.publikasi.index', compact('dataPublikasiJurnal', 'dataPublikasiConference', 'ambilStatus'));
    }

    public function formConference(){

        // if
        return view("pages.mahasiswa.publikasi.fromConference");
    }

    public function formJurnal(){
        return view("pages.mahasiswa.publikasi.fromPublikasi");
    }

    public function saveConference(request $request){
        // dd($request->all());
        try {
            // validation
            $request->validate([
                'judul' => 'required',
                'nim' => 'required',
                'namaConference' => 'required',
                'penyelenggra' => 'required',
                'tanggal_conference' => 'required',
                'lokasi_Conference' => 'required',
                'tanggalPublikasi' => 'required',
                'link' => 'required|url',
            ]);

            // init
            $saveData1 = new PublikasiConference;


            // Simpan data dari request ke dalam array
            $dataToSave = [
                'judul' => $request->input('judul'),
                'nim' => $request->input('nim'),
                'namaConference' => $request->input('namaConference'),
                'penyelenggara' => $request->input('penyelenggra'),
                'tanggal_conference' => $request->input('tanggal_conference'),
                'lokasi_Conference' => $request->input('lokasi_Conference'),
                'tanggalPublikasi' => $request->input('tanggalPublikasi'),
                'link' => $request->input('link'),
            ];

            // Simpan data ke dalam database
            $saveData1->fill($dataToSave)->save();

            // alert hover
            $request->session()->flash("berhasil", "berkas berhasil di upload");
            return redirect()->back()->with("berhasil", "berkas berhasil di upload");
            } catch (QueryException $e) {
            // Tangani error database
            return redirect()->back()->with("gagal", "Terjadi kesalahan dalam menyimpan data: " . $e->getMessage());
        } catch (\Exception $e) {
            // Tangani gagal umum
            return redirect()->back()->with("gagal", "Terjadi kesalahan: " . $e->getMessage() . " refresh page and try again");
        }
    }
    public function saveJurnal(request $request){
        // dd($request->all());
        try {
            // validation
            $request->validate([
                'judul_Artikel' => 'required',
                'nim' => 'required',
                'nama_jurnal' => 'required',
                'volume' => 'required',
                'nomor' => 'required',
                'tanggal_terbit' => 'required',
                'link' => 'required|url',
            ]);

            // init
            $saveData1 = new PublikasiJurnal;


            // Simpan data dari request ke dalam array
            $dataToSave = [
                'judul' => $request->input('judul_Artikel'),
                'nim' => $request->input('nim'),
                'jurnal' => $request->input('nama_jurnal'),
                'volume' => $request->input('volume'),
                'nomor' => $request->input('nomor'),
                'tanggal_terbit' => $request->input('tanggal_terbit'),
                'link' => $request->input('link'),
            ];

            // Simpan data ke dalam database
            $saveData1->fill($dataToSave)->save();

            // alert hover
            $request->session()->flash("berhasil", "berkas berhasil di upload");
            return redirect()->back()->with("berhasil", "berkas berhasil di upload");
            } catch (QueryException $e) {
            // Tangani error database
            return redirect()->back()->with("gagal", "Terjadi kesalahan dalam menyimpan data: " . $e->getMessage());
        } catch (\Exception $e) {
            // Tangani gagal umum
            return redirect()->back()->with("gagal", "Terjadi kesalahan: " . $e->getMessage() . " refresh page and try again");
        }
    }


    public function deleteConference($id){
        try {
            // Cari data berdasarkan ID
            $data = PublikasiConference::where('id', $id)->first();

            // Jika data tidak ditemukan
            if (!$data) {
                return redirect()->back()->with("gagal", "Data tidak ditemukan");
            }

            // Hapus data
            $data->delete();

            // Redirect ke halaman sebelumnya dengan pesan sukses
            return redirect()->back()->with("berhasil", "Data berhasil dihapus");
        } catch (\Exception $e) {
            // Tangani error
            return redirect()->back()->with("gagal", "Terjadi kesalahan: " . $e->getMessage());
        }
    }
    public function deletePublikasi($id){
        try {
            // Cari data berdasarkan ID
            $data = PublikasiJurnal::where('id', $id)->first();

            // Jika data tidak ditemukan
            if (!$data) {
                return redirect()->back()->with("gagal", "Data tidak ditemukan");
            }

            // Hapus data
            $data->delete();

            // Redirect ke halaman sebelumnya dengan pesan sukses
            return redirect()->back()->with("berhasil", "Data berhasil dihapus");
        } catch (\Exception $e) {
            // Tangani error
            return redirect()->back()->with("gagal", "Terjadi kesalahan: " . $e->getMessage());
        }
    }

}
