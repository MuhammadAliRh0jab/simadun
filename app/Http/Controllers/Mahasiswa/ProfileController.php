<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dosen;
use App\Models\DetailMahasiswa;
use App\Helpers\UserHelper;
use App\Models\Mahasiswa;



class ProfileController extends Controller
{
    public function index(){
    // Ambil data pengguna yang sudah masuk
    $dosen = Auth::guard('dosen')->user();
    $mahasiswa= Auth::guard('mahasiswa')->user();


    // Periksa apakah pengguna adalah dosen atau mahasiswa
    if ($dosen) {
        // Jika pengguna adalah dosen, cari data dosen berdasarkan no_induk
        $dataDosen = Dosen::where('no_induk', $dosen->no_induk)->first();
        $photo = UserHelper::getDosenPicture($dataDosen);

        // Periksa apakah data profil dosen berhasil ditemukan
        if ($dataDosen) {
            return view('pages.dosen.profile.index', ['dataDosen' => $dataDosen, 'photo' => $photo]);
        } else {
            return back()->withErrors([
                'error' => 'Data profil dosen tidak ditemukan.'
            ]);
        }
    } elseif ($mahasiswa) {
        // Jika pengguna adalah mahasiswa, lakukan seperti sebelumnya
        $profileData = DetailMahasiswa::where('nim', $mahasiswa->nim)->first();
        $photo = UserHelper::getMahasiswaPicture($profileData->nim);
        $statusUjian = Mahasiswa::where('nim', $mahasiswa->nim)->first();
        $tampilPromotor = Dosen::where('id', $statusUjian->promotor_id)->first();
        $tampilPromotor1 = Dosen::where('id', $statusUjian->co_promotor1_id)->first();
        $tampilPromotor2 = Dosen::where('id', $statusUjian->co_promotor2_id)->first();

        // Periksa apakah data profil mahasiswa berhasil ditemukan
        if ($profileData) {
            return view('pages.mahasiswa.profile.index', ['profileData' => $profileData, 'photo' => $photo, 'statusUjian' => $statusUjian, 'tampilPromotor' => $tampilPromotor, 'tampilPromotor2' => $tampilPromotor2, 'tampilPromotor1' => $tampilPromotor1]);
        } else {
            return back()->withErrors([
                'error' => 'Data profil mahasiswa tidak ditemukan.'
            ]);
        }
    } else {
        // Jika pengguna bukan dosen atau mahasiswa, berikan pesan kesalahan
        return back()->withErrors([
            'error' => 'Peran pengguna tidak valid.'
        ]);
    }
}


    public function updateProfile(Request $request)
    {
        // dd($request->all());
        try {
            // update data sesuai inputan user
            $user = Auth::user();
            $profileData = DetailMahasiswa::where('nim', $user->nim)->first();

            // Lakukan validasi inputan
            $validatedData = $request->validate([
                // Tentukan aturan validasi untuk setiap inputan
                'nama' => 'required|string|max:255',
                'nim' => 'required|string|max:255',
                'no_hp' => 'required|string|max:255',
                'email_um' => 'required|string|email|max:255',
                'email_lain' => 'required|string|email|max:255',
                'alamat_asal' => 'required|string|max:255',
                'alamat_malang' => 'required|string|max:255',
                'asal_instansi' => 'required|string|max:255',
                // Tambahkan aturan validasi lainnya sesuai kebutuhan
            ]);

            // Update profil dengan data yang divalidasi
            $profileData->update($validatedData);

            return back()->with('success', 'Data profil berhasil diperbarui.');
        } catch (\Exception $e) {
            // Tangani kesalahan dan berikan pesan error yang jelas
            return back()->with('error', $e->getMessage());
        }
    }


    public function indexProfile(){
        return view('pages.mahasiswa.lengkapi-profil.index');
    }

    public function indexDosen(){
        return view('pages.dosen.profile.index');
    }

    public function saveDatafromNewUser(Request $request){
        // dd($request->all());
        try {
            $validatedData = $request->validate([
                // Tentukan aturan validasi untuk setiap inputan
                'nama' => 'required|string|max:255',
                'nim' => 'required|string|max:255',
                'JudulThesis' => 'required|string|max:255',
                'no_hp' => 'required|string|max:255',
                'email_um' => 'required|string|email|max:255',
                'email_lain' => 'required|string|email|max:255',
                'alamat_malang' => 'required|string|max:255',
                'alamat_asal' => 'required|string|max:255',
                'asal_instansi' => 'required|string|max:255',
                'pt_s1' => 'required',
                'pt_s2' => 'required',
                'skor_tpa' => 'required',
                'skor_toefl' => 'required',
                'usulan_promotor' => 'required',
                // Tambahkan aturan validasi lainnya sesuai kebutuhan
            ]);


            // Kemudian tambahkan ke dalam array $saveData
            $saveData = [
                'nama' => $request->input('nama'),
                'nim' => $request->input('nim'),
                'no_hp' => $request->input('no_hp'),
                'email_um' => $request->input('email_um'),
                'email_lain' => $request->input('email_lain'),
                'alamat_malang' => $request->input('alamat_malang'),
                'alamat_asal' => $request->input('alamat_asal'),
                'asal_instansi' => $request->input('asal_instansi'),
                'PT_s1' => $request->input('pt_s1'),
                'PT_s2' => $request->input('pt_s2'),
                'skor_TPA' => $request->input('skor_tpa'),
                'skor_toefl' => $request->input('skor_toefl'),
            ];


            $saveData1 = [
                'judul' => $request -> input('JudulThesis'),
                'promotor_id' => $request->usulan_promotor[0],
                'co_promotor1_id' => $request->usulan_promotor[1],
                'co_promotor2_id' => $request->usulan_promotor[2] ?? null,
            ];


            // init
            $saveDataMasBro = new DetailMahasiswa;
            $saveDataMasBro ->fill($saveData)->save();

            // inisialisasi model mahasiswa
            $mahasiswa = new Mahasiswa;
            $mahasiswa = Mahasiswa::where('nim', $request->nim)->first();
            $mahasiswa->fill($saveData1)->save();


            $request->session()->flash("berhasil", "berkas berhasil di upload");
            return redirect('/')->with("berhasil", "berkas berhasil di upload");
        } catch (QueryException $e) {
            // Tangani error database
            return redirect()->back()->with("gagal", "Terjadi kesalahan dalam menyimpan data: " . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with("gagal", "Terjadi kesalahan: " . $e->getMessage() . " refresh page and try again");
        }
    }


}
