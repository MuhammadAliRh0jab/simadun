<?php

namespace App\Http\Controllers;

use App\Helpers\AuthHelper;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DokumenController extends Controller
{
    protected $document;
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function index()
    {
        $role = AuthHelper::getRole();

        // Jika peran adalah 'guest', hentikan dengan error 404
        if ($role === 'guest') {
            abort(404);
        }

        // Ambil data dokumen dari database
        $dokumen = DB::table('documents')->get();

        // Tampilkan halaman sesuai peran dengan data dokumen
        return match ($role) {
            'mahasiswa' => view('pages.mahasiswa.dokumen.index', compact('dokumen')),
            default => view('pages.dosen.dokumen.index', compact('dokumen')), // Dosen dan peran lain
        };
    }


    public function create()
    {
        if (AuthHelper::getRole() == 'guest') {
            abort(404);
        }

        if (AuthHelper::getRole() == 'mahasiswa') {
            return view('pages.mahasiswa.dokumen.index');
        }

        return view('pages.dosen.dokumen.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'dokumen' => 'required|file',
        ]);

        $create = collect($request->only($this->document->getFillable()))
            ->filter();

        $file = $request->file('dokumen');
        if ($file) {
            $directory = 'files';
            $filename = $file->getClientOriginalName();
            $mimetype = $file->getMimeType();
            $size = $file->getSize();

            $result = $file->move(public_path($directory), $filename);
            if ($result) {
                $create->put('directories', $directory);
                $create->put('filename', $filename);
                $create->put('mimetype', $mimetype);
                $create->put('filesize', $size);
                $this->document->create($create->toArray());
            } else {
                return redirect()->back()->with('error', 'Gagal mengupload dokumen.');
            }
        } else {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan.');
        }

        // Redirect ke halaman yang diinginkan setelah berhasil
        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil disimpan.');
    }

    public function destroy($id)
    {
        // Ambil dokumen berdasarkan ID
        $dokumen = DB::table('documents')->where('id', $id)->first();

        if (!$dokumen) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan.');
        }

        // Hapus file dari storage (jika ingin menghapus fisiknya juga)
        $filePath = public_path('files/' . $dokumen->filename);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Hapus dari database
        DB::table('documents')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
