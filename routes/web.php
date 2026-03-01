<?php

use App\Http\Controllers\DokumenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Mahasiswa\Ujian\ProposalController;
use App\Http\Controllers\Mahasiswa\Ujian\SemhasController;
use App\Http\Controllers\Mahasiswa\Ujian\PublikasiController;
use App\Http\Controllers\Mahasiswa\Ujian\DisertasiController;
use App\Http\Controllers\Mahasiswa\Ujian\TertutupController;

use App\Http\Controllers\Mahasiswa\ProfileController;
use App\Http\Controllers\Mahasiswa\PublikasiController as MahasiswaPublikasiController;
use App\Http\Controllers\Mahasiswa\LaporanBulananController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Mahasiswa\PublikasiMahasiswaController;
use App\Http\Controllers\Mahasiswa\PublikasiConferenceController;


// dosens
use App\Http\Controllers\Dosen\Ujian\ProposalController as DosenProposalController;
use App\Http\Controllers\Dosen\Ujian\SemhasController as DosenSemhasController;
use App\Http\Controllers\Dosen\Ujian\PublikasiController as DosenPublikasiController;
use App\Http\Controllers\Dosen\Ujian\DisertasiController as DosenDisertasiController;
use App\Http\Controllers\Dosen\Ujian\TertutupController as DosenTertutupController;
use App\Http\Controllers\Dosen\PublikasiMahasiswa\PublikasiConferenceController as DosenShowPublikasi;
use App\Http\Controllers\Dosen\Ujian\ArsipController as DosenArsipController;
use App\Http\Controllers\Dosen\PublikasiMahasiswa\LaporanPublikasiConferenceController;
use App\Http\Controllers\Dosen\PublikasiMahasiswa\LaporanPublikasiJurnalController;

use App\Http\Controllers\Dosen\LaporanBulananController as DosenLaporanBulananController;
use App\Http\Controllers\Dosen\UjianTerjadwalController;
use App\Http\Controllers\Dosen\BimbinganMahasiswaController;
use App\Http\Controllers\Dosen\LaporanProgressController;
use App\Http\Controllers\PDFController;




// manajemen user
use App\Http\Controllers\Dosen\Manajemen\MahasiswaController;
use App\Http\Controllers\Dosen\Manajemen\DosenController;
use App\Models\Dosen; // Pastikan untuk mengimpor model Promotor



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('auth.login');
});

// * mahasiswa route
Route::middleware(['role:mahasiswa'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('mahasiswa.home');

    // ujian porposal
    Route::get('/ujian-proposal', [ProposalController::class, 'index'])->name('ujian.proposal');
    Route::post('/ujian-proposal', [ProposalController::class, 'store'])->name('ujian.proposal.store');
    Route::patch('/ujian-proposal/revisi', [ProposalController::class, 'update'])->name('ujian.proposal.revisi');

    // ujian semhas
    Route::get('/ujian-semhas', [SemhasController::class, 'index'])->name('ujian.semhas');
    Route::post('/ujian-semhas', [SemhasController::class, 'store'])->name('ujian.semhas.store');
    Route::patch('/ujian-semhas/revisi', [SemhasController::class, 'update'])->name('ujian.semhas.revisi');

    // ujian publikasi
    Route::get('/ujian-publikasi', [PublikasiController::class, 'index'])->name('ujian.publikasi');
    Route::post('/ujian-publikasi', [PublikasiController::class, 'store'])->name('ujian.publikasi.store');
    Route::patch('/ujian-publikasi/revisi', [PublikasiController::class, 'update'])->name('ujian.publikasi.revisi');

    // ujian disertasi
    Route::get('/ujian-disertasi', [DisertasiController::class, 'index'])->name('ujian.disertasi');
    Route::post('/ujian-disertasi', [DisertasiController::class, 'store'])->name('ujian.disertasi.store');
    Route::patch('/ujian-disertasi/revisi', [DisertasiController::class, 'update'])->name('ujian.disertasi.revisi');

    // ujian tertutup
    Route::get('/ujian-tertutup', [TertutupController::class, 'index'])->name('ujian.tertutup');
    Route::post('/ujian-tertutup', [TertutupController::class, 'store'])->name('ujian.tertutup.store');
    Route::patch('/ujian-tertutup/revisi', [TertutupController::class, 'update'])->name('ujian.tertutup.revisi');

    // profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    // laporan bulanan
    Route::get('/laporan-bulanan', [LaporanBulananController::class, 'index'])->name('laporan-bulanan.index');
    Route::get('/laporan-bulanan/create', [LaporanBulananController::class, 'create'])->name('laporan-bulanan.create');
    Route::get('/laporan-bulanan/{id}', [LaporanBulananController::class, 'show'])->name('laporan-bulanan.show');
    Route::post('/laporan-bulanan', [LaporanBulananController::class, 'store'])->name('laporan-bulanan.store');
    Route::delete('/laporan-bulanan/{id}', [LaporanBulananController::class, 'destroy'])->name('laporan-bulanan.destroy');
});

// * dosen/kaprodi route
Route::middleware(['role:kaprodi,dosen,eksternal'])->group(function () {
    //group by prefix dosen and name dosen.
    Route::prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/', [HomeController::class, 'dosen'])->name('home');

        // middleware kaprodi only
        Route::middleware(['role:kaprodi'])->group(function () {

            // ujian proposal
            Route::get('/ujian-proposal', [DosenProposalController::class, 'index'])->name('ujian.proposal');
            Route::get('/ujian-proposal/{id}', [DosenProposalController::class, 'show'])->name('ujian.proposal.show');
            Route::post('/ujian-proposal/{id}', [DosenProposalController::class, 'store'])->name('ujian.proposal.store');
            Route::patch('/ujian-proposal/finalisasi', [DosenProposalController::class, 'finalisasi'])->name('ujian.proposal.finalisasi');

            // ujian semhas
            Route::get('/ujian-semhas', [DosenSemhasController::class, 'index'])->name('ujian.semhas');
            Route::get('/ujian-semhas/{id}', [DosenSemhasController::class, 'show'])->name('ujian.semhas.show');
            Route::post('/ujian-semhas/{id}', [DosenSemhasController::class, 'store'])->name('ujian.semhas.store');
            Route::patch('/ujian-semhas/finalisasi', [DosenSemhasController::class, 'finalisasi'])->name('ujian.semhas.finalisasi');

            // ujian publikasi
            Route::get('/ujian-publikasi', [DosenPublikasiController::class, 'index'])->name('ujian.publikasi');
            Route::get('/ujian-publikasi/{id}', [DosenPublikasiController::class, 'show'])->name('ujian.publikasi.show');
            Route::post('/ujian-publikasi/{id}', [DosenPublikasiController::class, 'store'])->name('ujian.publikasi.store');
            Route::patch('/ujian-publikasi/finalisasi', [DosenPublikasiController::class, 'finalisasi'])->name('ujian.publikasi.finalisasi');

            // ujian disertasi
            Route::get('/ujian-disertasi', [DosenDisertasiController::class, 'index'])->name('ujian.disertasi');
            Route::get('/ujian-disertasi/{id}', [DosenDisertasiController::class, 'show'])->name('ujian.disertasi.show');
            Route::post('/ujian-disertasi/{id}', [DosenDisertasiController::class, 'store'])->name('ujian.disertasi.store');
            Route::patch('/ujian-disertasi/finalisasi', [DosenDisertasiController::class, 'finalisasi'])->name('ujian.disertasi.finalisasi');

            // ujian tertutup
            Route::get('/ujian-tertutup', [DosenTertutupController::class, 'index'])->name('ujian.tertutup');
            Route::get('/ujian-tertutup/{id}', [DosenTertutupController::class, 'show'])->name('ujian.tertutup.show');
            Route::patch('/ujian-tertutup/finalisasi', [DosenTertutupController::class, 'finalisasi'])->name('ujian.tertutup.finalisasi');
            Route::post('/ujian-tertutup/penguji-eksternal', [DosenTertutupController::class, 'addPenguji'])->name('ujian.tertutup.addPenguji');
            Route::post('/ujian-tertutup/{id}', [DosenTertutupController::class, 'store'])->name('ujian.tertutup.store'); // try to avoid addPenguji to redirect this route by reorder the route

            // arsip ujian
            Route::get('/ujian-arsip', [DosenArsipController::class, 'index'])->name('ujian.arsip');
            Route::get('/ujian-arsip/{id}', [DosenArsipController::class, 'show'])->name('ujian.arsip.show');

            // manajemen mahasiswa
            Route::get('/manajemen-pengguna/mahasiswa', [MahasiswaController::class, 'index'])->name('manajemen.mahasiswa');
            Route::get('/manajemen-pengguna/mahasiswa/create', [MahasiswaController::class, 'create'])->name('manajemen.mahasiswa.create');
            Route::post('/manajemen-pengguna/mahasiswa', [MahasiswaController::class, 'store'])->name('manajemen.mahasiswa.store');
            Route::get('/manajemen-pengguna/mahasiswa/{id}', [MahasiswaController::class, 'show'])->name('manajemen.mahasiswa.show');
            Route::get('/manajemen-pengguna/mahasiswa/{id}/edit', [MahasiswaController::class, 'edit'])->name('manajemen.mahasiswa.edit');
            Route::put('/manajemen-pengguna/mahasiswa/{id}', [MahasiswaController::class, 'update'])->name('manajemen.mahasiswa.update');
            Route::delete('/manajemen-pengguna/mahasiswa/delete/{id}', [MahasiswaController::class, 'destroy'])->name('manajemen.mahasiswa.destroy');
            Route::post('/manajemen-pengguna/mahasiswa/reset-account/{id}', [MahasiswaController::class, 'resetAccount'])->name('manajemen.mahasiswa.reset');
            Route::post('/manajemen-pengguna/mahasiswa/reset-password/{id}', [MahasiswaController::class, 'resetPassword'])->name('manajemen.mahasiswa.reset-password');

            // manajemen dosen
            Route::get('/manajemen-pengguna/dosen', [DosenController::class, 'index'])->name('manajemen.dosen');
            Route::get('/manajemen-pengguna/dosen/create', [DosenController::class, 'create'])->name('manajemen.dosen.create');
            Route::post('/manajemen-pengguna/dosen', [DosenController::class, 'store'])->name('manajemen.dosen.store');
            Route::get('/manajemen-pengguna/dosen/{id}', [DosenController::class, 'show'])->name('manajemen.dosen.show');
            Route::get('/manajemen-pengguna/dosen/{id}/edit', [DosenController::class, 'edit'])->name('manajemen.dosen.edit');
            Route::put('/manajemen-pengguna/dosen/{id}', [DosenController::class, 'update'])->name('manajemen.dosen.update');
            Route::delete('/manajemen-pengguna/dosen/delete/{id}', [DosenController::class, 'destroy'])->name('manajemen.dosen.destroy');
            Route::post('/manajemen-pengguna/dosen/reset-password/{id}', [DosenController::class, 'resetPassword'])->name('manajemen.dosen.reset-password');
        });

        // group middleware dosen or kaprodi
        Route::middleware(['role:mahasiswa,kaprodi,dosen,eksternal'])->group(function () {
            // Bimbingan Mahasiswa
            Route::get('/bimbingan-mahasiswa', [BimbinganMahasiswaController::class, 'index'])->name('bimbingan.index');
            Route::get('/bimbingan-mahasiswa/{id}', [BimbinganMahasiswaController::class, 'show'])->name('bimbingan.show');

            // Laporan Progress/bulanan
            Route::get('/laporan-progress', [LaporanProgressController::class, 'index'])->name('laporan.index');
            Route::get('/laporan-progress/{id}', [LaporanProgressController::class, 'show'])->name('laporan.show');
            Route::post('/laporan-progress/{id}', [LaporanProgressController::class, 'komentar'])->name('laporan.komentar');
        });

        // Ujian Terjadwal
        Route::get('/ujian-terjadwal', [UjianTerjadwalController::class, 'index'])->name('ujian.terjadwal.index');
        Route::get('/ujian-terjadwal/{id}', [UjianTerjadwalController::class, 'show'])->name('ujian.terjadwal.show');
        Route::post('/ujian-terjadwal', [UjianTerjadwalController::class, 'penilaian'])->name('ujian.terjadwal.penilaian');
    });
});

// search route
Route::prefix('search')->group(function () {
    Route::post('/dosen', [SearchController::class, 'searchDosen'])->name('search.dosen');
    Route::post('/dosen-eksternal', [SearchController::class, 'searchDosenEksternal'])->name('search.dosen.eksternal');
});

// show publikasi dosen
route::get('/daftar-publikasi-mahasiswa', [DosenShowPublikasi::class, 'index'])->name('show.dosen.publikasi');
Route::get('/publikasi-conference', [LaporanPublikasiConferenceController::class, 'index'])->name('dosen.publikasi.conference.index');
Route::get('/publikasi-jurnal', [LaporanPublikasiJurnalController::class, 'index'])->name('dosen.publikasi.jurnal.index');
route::delete('/delete-jurnal-dosen/{id}', [DosenShowPublikasi::class,'deleteJurnal'])->name('delete.dosen.jurnal');
route::delete('/delete-conference-dosen/{id}', [DosenShowPublikasi::class,'deleteConf'])->name('delete.dosen.Conf');

// file routes
Route::middleware('role:mahasiswa,dosen,eksternal,kaprodi')->group(function () {
    Route::get('/file/{filename}', [PDFController::class, 'show'])->name('file');
});
//  test
Route::get('/test', function () {
    return view('test');
});
// ujian
Route::get('/ujian-proposal', [ProposalController::class, 'index'])->name('ujian.proposal');

// profile
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
route::post('/update-profile', [ProfileController::class, 'updateProfile']);
route::post('/save-data-profile', [ProfileController::class, 'saveDatafromNewUser'])->name('save-data.new');

// laporan bulanan
Route::get('/laporan-bulanan', [LaporanBulananController::class, 'index'])->name('laporan-bulanan.index');
Route::get('/laporan-bulanan/{id}/edit', [LaporanBulananController::class, 'edit'])->name('laporan-bulanan.edit');



// Menampilkan data publikasi jurnal dan conference
route::get('/publikasi', [MahasiswaPublikasiController::class, 'showAllPubilkasi'])->name('index.Publikasi');

// form conference
route::get('/form-conference', [MahasiswaPublikasiController::class, 'formConference'])->name('form.conference');
// route datatable conference
route::get('/tabel-conference', [MahasiswaPublikasiController::class, 'PublikasiConferencer'])->name('tabelConference');
// save data conference
route::post('/save-conference', [MahasiswaPublikasiController::class, 'saveConference'])->name('save.conference');
// delete jurnal
route::delete('/delete-conference/{id}', [MahasiswaPublikasiController::class, 'deleteConference'])->name('conference.delete');
route::delete('/delete-publikasi/{id}', [MahasiswaPublikasiController::class, 'deletePublikasi'])->name('publikasi.delete');

// route editConference
route::get('/edit-conference/{id}', [MahasiswaPublikasiController::class, 'editConference'])->name('conference.edit');
route::get('/edit-publikasi/{id}', [MahasiswaPublikasiController::class, 'editPublikasi'])->name('publikasi.edit');

// save edit conference
route::post('/save-edit-conference/', [MahasiswaPublikasiController::class, 'saveEditConference'])->name('conference.update');
route::post('/save-edit-publikasi/', [MahasiswaPublikasiController::class, 'saveEditJurnal'])->name('publikasi.update');

// profil - edit password

// form jurnal
route::get('/form-jurnal', [MahasiswaPublikasiController::class, 'formJurnal'])->name('form.jurnal');
// route datatable jurnal
route::get('/tabel-jurnal', [MahasiswaPublikasiController::class, 'PublikasiDataTabel'])->name('tabelJurnal');
// save data jurnal
route::post('/save-jurnal', [MahasiswaPublikasiController::class, 'saveJurnal'])->name('save.jurnal');
// delete jurnal
route::delete('/delete-jurnal/{id}', [MahasiswaPublikasiController::class, 'deleteJurnal'])->name('delete.jurnal');

// profile dosen
route::get('/profile-dosen', [ProfileController::class, 'index'])->name('indexDosen.cihuy');

// Route::get('/dokumen', [\App\Http\Controllers\DokumenController::class, 'index'])->name('dokumen.index');
// Route::get('/dokumen-create', [\App\Http\Controllers\DokumenController::class, 'create'])->name('dokumen.create');
// Route::get('/dokumen-store', [\App\Http\Controllers\DokumenController::class, 'store'])->name('dokumen.store');

Route::resource('dokumen', DokumenController::class);

require __DIR__ . '/auth.php';
require __DIR__ . '/mahasiswa.php';